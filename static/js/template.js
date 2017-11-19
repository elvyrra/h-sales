'use strict';

require(['app', 'emv', 'lang', 'jquery'], function(app, EMV, Lang, $) {
    const form = app.forms['h-sales-template-form'];
    const settings = JSON.parse(form.inputs.settings.val());
    const logo = form.inputs.logo.val();

    class PageHeader extends EMV {
        constructor(data) {
            super({
                data : {
                    fontFamily : data.fontFamily || 'Verdana',
                    fontSize : data.fontSize || '8pt',
                    color : data.color || '#3b0d0d',
                    bold : data.bold || 0,
                    italic : data.italic || 0,
                    underline : data.underline || 0,
                    left : data.left || '',
                    center : data.center || '',
                    right : data.right || '',
                    separator : data.separator || false,
                },
                computed : {
                    depth : function() {
                        return '';
                    },

                    displayLeft : function() {
                        if(this.left == 'number'){
                            return Lang.get('h-sales.template-form-number-label');
                        }

                        if(this.left == 'ctime'){
                            let d = new Date();
                            return d.getDate()  + '/' + ('0'+(d.getMonth()+1)).slice(-2) + '/' + d.getFullYear();
                        }

                        if(this.left == 'mtime'){
                            let d = new Date();
                            return d.getDate()  + '/' + ('0'+(d.getMonth()+1)).slice(-2) + '/' + d.getFullYear();
                        }

                        if(this.left == 'siren'){
                            return settings.siren ? settings.siren : Lang.get(`h-sales.template-siren-format`);
                        }

                        if(this.left == 'tva'){
                            return settings.tva ? settings.tva : Lang.get(`h-sales.template-tva-format`);
                        }

                        if(this.left == 'companyName'){
                            return settings.companyName ? settings.companyName : Lang.get(`h-sales.template-companyName-format`);
                        }

                        if(this.left == 'companyAddress'){
                            return settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`);
                        }

                        if(this.left == 'correspondance'){
                            return settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`);
                        }

                         if(this.left == 'status'){
                            if((settings.companyName) && (settings.capital))
                                return settings.companyName + " au Capital de " + settings.capital;
                            else
                                return Lang.get(`h-sales.template-status-format`);
                        }

                        return '';
                    },

                    displayCenter : function() {

                        if(this.center == 'number'){
                            return Lang.get(`h-sales.template-form-number-label`);
                        }

                        if(this.center == 'ctime'){
                            let d = new Date();
                            return d.getDate()  + '/' + ('0'+(d.getMonth()+1)).slice(-2) + '/' + d.getFullYear();
                        }

                        if(this.center == 'mtime'){
                            let d = new Date();
                            return d.getDate()  + '/' + ('0'+(d.getMonth()+1)).slice(-2) + '/' + d.getFullYear();
                        }

                        if(this.center == 'siren'){
                            return settings.siren ? settings.siren : Lang.get(`h-sales.template-siren-format`);
                        }

                        if(this.center == 'tva'){
                            return settings.tva ? settings.tva : Lang.get(`h-sales.template-tva-format`);
                        }

                        if(this.center == 'companyName'){
                            return settings.companyName ? settings.companyName : Lang.get(`h-sales.template-companyName-format`);
                        }

                        if(this.center == 'companyAddress'){
                            return settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`);
                        }

                        if(this.center == 'correspondance'){
                            return settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`);
                        }

                        if(this.center == 'status'){
                            if((settings.companyName) && (settings.capital))
                                return settings.companyName + " au Capital de " + settings.capital;
                            else
                                return Lang.get(`h-sales.template-status-format`);
                        }

                        return '';
                    },

                    displayRight : function() {

                        if(this.right == 'number'){
                            return Lang.get(`h-sales.template-form-number-label`);
                        }

                        if(this.right == 'ctime'){
                            let d = new Date();
                            return d.getDate()  + '/' + ('0'+(d.getMonth()+1)).slice(-2) + '/' + d.getFullYear();
                        }

                        if(this.right == 'mtime'){
                            let d = new Date();
                            return d.getDate()  + '/' + ('0'+(d.getMonth()+1)).slice(-2) + '/' + d.getFullYear();
                        }

                        if(this.right == 'siren'){
                            return settings.siren ? settings.siren : Lang.get(`h-sales.template-siren-format`);
                        }

                        if(this.right == 'tva'){
                            return settings.tva ? settings.tva : Lang.get(`h-sales.template-tva-format`);
                        }

                        if(this.right == 'companyName'){
                            return settings.companyName ? settings.companyName : Lang.get(`h-sales.template-companyName-format`);
                        }

                        if(this.right == 'companyAddress'){
                            return settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`);
                        }

                        if(this.right == 'correspondance'){
                            return settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`);
                        }

                        if(this.right == 'status'){
                            if((settings.companyName) && (settings.capital))
                                return settings.companyName + " au Capital de " + settings.capital;
                            else
                                return Lang.get(`h-sales.template-status-format`);
                        }

                        return '';
                    },

                    displayBold : function() {

                        if(this.bold){
                            return 'bold';
                        }

                        return 'normal';
                    },

                    displayItalic : function() {

                        if(this.italic){
                            return 'italic';
                        }

                        return 'normal';
                    },

                    displayUnderline: function() {

                        if(this.underline){
                            return 'underline';
                        }

                        return 'none';
                    }
                }
            });
        }
    }   

    class DocumentHeader extends EMV {
        constructor(data) {
            super({
                data : {
                    fontFamily : data.fontFamily || 'Verdana',
                    fontSize : data.fontSize || '8pt',
                    color : data.color || '#3b0d0d',
                    bold : data.bold || false,
                    italic : data.italic || false,
                    underline : data.underline || false,
                    left : data.left || '',
                    center : data.center || '',
                    right : data.right || '',
                    textAlign : data.textAlign || 0,
                    logoWidth : data.logoWidth || 200,
                    logoHeight : data.logoHeight || 30,
                },
                computed : {
                    mab: function(){
                        return "10px";
                    },

                    displayLeft : function() {
                        if(this.left == 'address'){
                            return settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`);
                        }
                        
                        if(this.left == 'addressAndCorrespondance'){
                            var a = settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`);
                            return "coucou" + settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`);
                        }

                        if(this.left == 'correspondence'){
                            return settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`);
                        }

                        if(this.left == 'logo'){
                            return '<img src="' + logo + '" class="logo" e-style="{\'width\' : documentHeader.mab}">';
                        }

                        return '';
                    },

                    displayCenter : function() {
                        if(this.center == 'address'){
                            return settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`);
                        }
                        
                        if(this.center == 'addressAndCorrespondance'){
                            return '<p>' + settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`) + "</p></br><p>" + settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`) + '</p>';
                        }

                        if(this.center == 'correspondence'){
                            return settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`);
                        }

                        if(this.center == 'logo'){
                            return '<img src="' + logo + '" class="logo" e-style="{\'width\' : documentHeader.mab}">';
                        }

                        return '';
                    },

                    displayRight : function() {
                        if(this.right == 'address'){
                            return settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`);
                        }
                        
                        if(this.right == 'addressAndCorrespondance'){
                            return '<p>' + settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`) + "</p></br><p>" + settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`) + '</p>';
                        }

                        if(this.right == 'correspondence'){
                            return settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`);
                        }

                        if(this.right == 'logo'){
                            return '<img src="' + logo + '" class="logo" e-style="{\'width\' : documentHeader.mab}">';
                        }

                        return '';
                    }
                }
            });
        }

        /**
         * Get the parent line
         * @returns {QuoteLine} The parent line, or null if the line is at the first level
         */
        getParent() {
            return this.constructor.instancesById[this.parentId] || null;
        }
    }

    class BodyElement extends EMV {
        constructor(data) {
            super({
                data : {
                    fontFamily : data.fontFamily || 'Verdana',
                    fontSize : data.fontSize || '8pt',
                    color : data.color || '#22228b',
                    bold : data.bold || 0,
                    italic : data.italic || 0,
                    underline : data.underline || 0
                },
                computed : {
                    depth : function() {
                        return '';
                    }
                }
            });
        }
    }

    class Document extends EMV {
        constructor(data) {
            super({
                data : {
                    title1 : new BodyElement(data.title1 || {}),
                    title2 : new BodyElement(data.title2 || {}),
                    title3 : new BodyElement(data.title3 || {}),
                    element : new BodyElement(data.element || {}),
                    comment : new BodyElement(data.comment || {}),
                    display_title_totals : data.display_title_totals || false,
                    totals : data.totals || false
                },
                computed : {
                    depth : function() {
                        return '';
                    }
                }
            });
        }
    }

    class PageFooter extends EMV {
        constructor(data) {
            super({
                data : {
                    fontFamily : data.fontFamily || 'Verdana',
                    fontSize : data.fontSize || '8pt',
                    color : data.color || '#3b0d0d',
                    bold : data.bold || 0,
                    italic : data.italic || 0,
                    underline : data.underline || 0,
                    left : data.left || '',
                    center : data.center || '',
                    right : data.right || '',
                    separator : data.separator || false,
                },
                computed : {
                    depth : function() {
                        return '';
                    },

                    displayLeft : function() {

                        if(this.left == 'companyName'){
                            return Lang.get(`h-sales.template-number-format`);
                        }

                        if(this.left == 'ctime'){
                            return Lang.get(`h-sales.template-ctime-format`);
                        }

                        if(this.left == 'mtime'){
                            return Lang.get(`h-sales.template-mtime-format`);
                        }

                        if(this.left == 'siren'){
                            return settings.siren ? settings.siren : Lang.get(`h-sales.template-siren-format`);
                        }

                        if(this.left == 'tva'){
                            return settings.tva ? settings.tva : Lang.get(`h-sales.template-tva-format`);
                        }

                        if(this.left == 'companyName'){
                            return settings.companyName ? settings.companyName : Lang.get(`h-sales.template-companyName-format`);
                        }

                        if(this.left == 'companyAddress'){
                            return settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`);
                        }

                        if(this.left == 'correspondance'){
                            return settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`);
                        }

                        if(this.left == 'status'){
                            if((settings.companyName) && (settings.capital))
                                return settings.companyName + " au Capital de " + settings.capital;
                            else
                                return Lang.get(`h-sales.template-status-format`);
                        }

                        return '';
                    },

                    displayCenter : function() {

                        if(this.center == 'number'){
                            return Lang.get(`h-sales.template-number-format`);
                        }

                        if(this.center == 'ctime'){
                            return Lang.get(`h-sales.template-ctime-format`);
                        }

                        if(this.center == 'mtime'){
                            return Lang.get(`h-sales.template-mtime-format`);
                        }

                        if(this.center == 'siren'){
                            return settings.siren ? settings.siren : Lang.get(`h-sales.template-siren-format`);
                        }

                        if(this.center == 'tva'){
                            return settings.tva ? settings.tva : Lang.get(`h-sales.template-tva-format`);
                        }

                        if(this.center == 'companyName'){
                            return settings.companyName ? settings.companyName : Lang.get(`h-sales.template-companyName-format`);
                        }

                        if(this.center == 'companyAddress'){
                            return settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`);
                        }

                        if(this.center == 'correspondance'){
                            return settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`);
                        }

                        if(this.center == 'status'){
                            if((settings.companyName) && (settings.capital))
                                return settings.companyName + " au Capital de " + settings.capital;
                            else
                                return Lang.get(`h-sales.template-status-format`);
                        }

                        return '';
                    },

                    displayRight : function() {

                        if(this.right == 'number'){
                            return Lang.get(`h-sales.template-number-format`);
                        }

                        if(this.right == 'ctime'){
                            return Lang.get(`h-sales.template-ctime-format`);
                        }

                        if(this.right == 'mtime'){
                            return Lang.get(`h-sales.template-mtime-format`);
                        }

                        if(this.right == 'siren'){
                            return settings.siren ? settings.siren : Lang.get(`h-sales.template-siren-format`);
                        }

                        if(this.right == 'tva'){
                            return settings.tva ? settings.tva : Lang.get(`h-sales.template-tva-format`);
                        }

                        if(this.right == 'companyName'){
                            return settings.companyName ? settings.companyName : Lang.get(`h-sales.template-companyName-format`);
                        }

                        if(this.right == 'companyAddress'){
                            return settings.companyAddress ? settings.companyAddress : Lang.get(`h-sales.template-companyAddress-format`);
                        }

                        if(this.right == 'correspondance'){
                            return settings.correspondance ? settings.correspondance : Lang.get(`h-sales.template-correspondance-format`);
                        }

                        if(this.right == 'status'){
                            if((settings.companyName) && (settings.capital))
                                return settings.companyName + " au Capital de " + settings.capital;
                            else
                                return Lang.get(`h-sales.template-status-format`);
                        }

                        return '';
                    },

                    displayBold : function() {
                        if(this.bold){
                            return 'bold';
                        }

                        return 'normal';
                    },

                    displayItalic : function() {
                        if(this.italic){
                            return 'italic';
                        }

                        return 'normal';
                    },

                    displayUnderline: function() {
                        if(this.underline){
                            return 'underline';
                        }

                        return 'none';
                    }
                }
            });
        }
    }

    //const contentTemplate = JSON.parse(form.inputs.content.val());  //JSON.parse(form.inputs.toto.val());
    const contentTemplate = JSON.parse($('#h-sales-template-init-value').val() || '[]');

    /**
     * Manage the template object
     */
    class Template extends EMV {
        /**
         * Constructor
         */
        constructor() {
            super({
                data : {
                    pageHeader : new PageHeader(contentTemplate.PageHeader || {}),
                    documentHeader : new DocumentHeader(contentTemplate.DocumentHeader || {}),
                    document : new Document(contentTemplate.Document || {}),
                    pageFooter : new PageFooter(contentTemplate.PageFooter || {}),
                    content : [],
                },
                computed : {
                    total : function() {
                    
                        return '';
                    }
                }
            });
        }

        init(){


        }

    }

    const template = new Template();

    window.template = template;

    template.init();

    template.$apply(form.node.get(0));
})();