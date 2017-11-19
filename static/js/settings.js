'use strict';

require(['app', 'emv', 'lang', 'jquery'], function(app, EMV, Lang, $) {
    const form = app.forms['h-sales-settings-form'];


    class SettingsElement extends EMV {
        /**
         * Constructor
         */
        constructor(data) {
            super({
                data : {
                    status : data.status || '',
                    companyName : data.companyName || '',
                    tradeName : data.tradeName || '',
                    siren : data.siren || '',
                    siret : data.siret || '',
                    tva : data.tva || '',
                    capital : data.capital || '',
                    phone : data.phone || '',
                    fax : data.fax || '',
                    email : data.email || '',
                    address : data.address || '',
                    postalCode : data.postalCode || '',
                    city : data.city || '',
                    country : data.country || ''
                },
                computed : {
                    companyAddress : function() {
                    
                        return this.address + '\r\n' + this.postalCode + ' - ' + this.city + '\r\n' + this.country;
                    },

                    correspondance : function() {
                        let str = '';

                        if(this.phone)
                            str = this.phone + '\r\n';

                        if(this.fax)
                            str = str + this.fax + '\r\n';

                        if(this.email)
                            str = str + this.email;

                        return str;
                    },
                }
            });
        }
    }

    class Model extends EMV {
        /**
         * Constructor
         */
        constructor() {
            super({
                data : {
                    settings : new SettingsElement(JSON.parse(form.inputs.settings.val())),
                }
            });
        }
    }

    var myModel = new Model();

    myModel.$apply(form.node.get(0));
})();