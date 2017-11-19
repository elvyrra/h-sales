'use strict';

require(['app', 'emv'], function(app, EMV) {
    const form  = app.forms['client-form'];
    const model = new EMV({
        pro : form.inputs.pro.val()
    });

    model.$apply(form.node.get(0));
});
