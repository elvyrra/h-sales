'use strict';

require(['app', 'emv', 'lang', 'jquery'], function(app, EMV, Lang, $) {
    let maxId = 0;

    let fullWidth;
    let colWidth;
    let width5;

    /**
     * SaleDoc line object
     */
    class SaleDocLine extends EMV {
        /**
         * Constructor
         * @param {Object} data The initial line data
         * @param {SaleDoc} saleDoc The parent sale document
         */
        constructor(data, saleDoc) {
            maxId++;

            super({
                data : {
                    id : maxId,
                    isTitle : data.isTitle || false,
                    label : data.label || '',
                    quantity : data.quantity || 1,
                    unit : data.unit || '',
                    unitPrice : data.unitPrice || 0,
                    taxRate : data.taxRate || 20,
                    content : [],
                    parentId : data.parentId || 0,
                    width5 : width5,
                    width1 : colWidth
                },
                computed : {
                    depth : function() {
                        if(!this.isTitle) {
                            return 1;
                        }

                        if(!this.content.length) {
                            return 2;
                        }

                        const childrenDepth = this.content.map((line) => line.depth);

                        return Math.max.apply(this, childrenDepth) + 1;
                    },

                    level : function() {
                        const parent = this.getParent();

                        if(!parent) {
                            return 1;
                        }

                        return parent.level + 1;
                    },

                    // The duty toal of the line
                    total : function() {
                        const result = {
                            duty : 0,
                            taxes : 0,
                            ati : 0
                        };

                        if(this.isTitle) {
                            this.content.forEach((line) => {
                                result.duty += line.total.duty;
                                result.taxes += line.total.taxes;
                            });

                            result.duty = result.duty * (this.quantity || 1);
                            result.taxes = result.taxes * (this.quantity || 1);
                        }
                        else {
                            result.duty = this.unitPrice * this.quantity;
                            result.taxes = result.duty * this.taxRate / 100;
                        }

                        result.ati = result.duty + result.taxes;

                        return result;
                    },

                    number : function() {
                        const parent = this.getParent();
                        const index = (parent || saleDoc).content.indexOf(this);

                        if(index === -1) {
                            return 0;
                        }

                        if(!parent || !parent.number) {
                            return `${index + 1}`;
                        }

                        return `${parent.number}.${index + 1}`;
                    }
                }
            }, saleDoc);

            this.constructor.instancesById[this.id] = this;
            this.content = this.isTitle && data.content ?
                data.content.map((child) => new SaleDocLine(child, saleDoc)) :
                [];
        }

        /**
         * Get the parent line
         * @returns {SaleDocLine} The parent line, or null if the line is at the first level
         */
        getParent() {
            return this.constructor.instancesById[this.parentId] || null;
        }
    }


    SaleDocLine.MAX_DEPTH = 4;

    SaleDocLine.instancesById = {};

    /**
     * Manage the sale document object
     */
    class SaleDoc extends EMV {
        /**
         * Constructor
         *
         * @param {Form} The form containing the sale document
         */
        constructor(form) {
            super({
                data : {
                    status : form.inputs.status.val(),
                    client : {
                        id : form.inputs.clientId.val(),
                        name : form.inputs.clientName.val(),
                        addressLine1 : form.inputs.clientAddressLine1.val(),
                        addressLine2 : form.inputs.clientAddressLine2.val(),
                        zipCode : form.inputs.clientZipCode.val(),
                        city : form.inputs.clientCity.val(),
                        country : form.inputs.clientCountry.val()
                    },
                    content : [],
                    id : 0,
                    maxLineId : 0
                },
                computed : {
                    total : function() {
                        const result = {
                            duty : 0,
                            taxes : 0,
                            ati : 0
                        };

                        this.content.forEach((line) => {
                            result.duty += line.total.duty;
                            result.taxes += line.total.taxes;
                            result.ati += line.total.ati;
                        });

                        return result;
                    }
                }
            });

            fullWidth = form.node.find('.nav-tabs').width();
            colWidth = fullWidth / 12;
            width5 = colWidth * 5;

            const content = JSON.parse(form.inputs.content.val()).map((line) => new SaleDocLine(line, this));

            this.content = content;
        }

        /**
         * Initialise the content of the quote
         */
        init() {
            $('#quote-content-container').sortable({
                handle: '.move-line',
                placeholder : '<li class="row placeholder"></li>',

                isValidTarget: ($item, container) => {
                    const moved = this.$getContext($item.get(0));

                    if(!moved.isTitle) {
                        return true;
                    }

                    const parent = this.$getContext(container.target.get(0));

                    if(parent !== this && !parent.isTitle) {
                        return false;
                    }

                    return moved.depth + (parent.level || 0) <= SaleDocLine.MAX_DEPTH;
                },

                onDrop: ($item, container, _super) => {
                    _super($item, container);

                    // Get the moved item and it new item
                    const moved = this.$getContext($item.get(0));

                    // Get the new parent item
                    const parent = this.$getContext(container.target.get(0));
                    const index = $item.parent().children().index($item);

                    // Get the prevous item parent and it previous index
                    const oldParent = moved.getParent() || this;
                    let oldIndex = oldParent.content.indexOf(moved);

                    if(parent === oldParent) {
                        if(index === oldIndex) {
                            // The line didn't move
                            return;
                        }

                        // The line moved in the same container
                        parent.content.splice(oldIndex, 1);
                        parent.content.splice(index, 0, moved);

                        return;
                    }

                    oldParent.content.splice(oldIndex, 1);
                    parent.content.splice(index, 0, moved);
                    moved.parentId = parent.id;
                }
            });
        }

        /**
         * callback when a client is found by autocomplete
         * @param  {Object} client The found client
         */
        onClientChange(client) {
            Object.keys(this.client).forEach((field) => {
                this.client[field] = client && client[field] || '';
            });
        }

        /**
         * Add a line to the quote
         *
         * @param {SaleDocLine} parentLine The parent line to add the line into
         * @param {int}       index      The index to insert the line at.
         *                               If not set, the line will be inserted at the end of the content
         * @param {bool}      isTitle    Defines if the line is a title or not
         */
        addLine(parentLine, index, isTitle) {
            const param = {
                isTitle : isTitle,
                parentId : parentLine && parentLine.id || 0
            };

            const line = new SaleDocLine(param, this);
            const content = parentLine && parentLine.content || this.content;

            if(index === undefined || index === null) {
                content.push(line);
            }
            else {
                content.splice(index, 0, line);
            }
        }

        /**
         * Find a line by it id
         * @param   {int} id    The line id
         * @returns {SaleDocLine} The found line
         */
        getLineById(id) {
            if(!id) {
                return null;
            }

            return SaleDocLine.instancesById[id] || null;
        }

        /**
         * The filter to get the children lines of a line
         * @param   {SaleDocLine} parentLine The parent line to get the children
         * @returns {Function}             The filter function to find the children
         */
        childFilter(parentLine) {
            return function(line) {
                return line.parentId === (parentLine && parentLine.id || 0);
            };
        }

        /**
         * Delete a line
         * @param {SaleDocLine} line  The line to delete
         */
        deleteLine(line) {
            if(confirm(Lang.get(`h-sales.confirm-delete-${line.isTitle ? 'title' : 'line'}`))) {
                const parent = line.getParent() || this;
                const index = parent.content.indexOf(line);

                parent.content.splice(index, 1);
            }
        }
    }

    SaleDoc.defaultLine = {
        isTitle : false,
        number : '1',
        label : '',
        quantity : 0,
        unit : '',
        unitPrice : 0,
        taxRate : 20
    };


    const quote = new SaleDoc();

    window.quote = quote;

    quote.init();

    quote.$apply(form.node.get(0));
})();