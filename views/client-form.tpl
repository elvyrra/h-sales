<div class="row">
    <div class="col-md-6">
        <fieldset>
            <legend> {{ $form->fieldsets['identity']->legend }} </legend>
            {{ $form->inputs['pro'] }}
            <div e-show="pro === '1'">
                {{ $form->inputs['companyName'] }}
            </div>
            {{ $form->inputs['firstname'] }}
            {{ $form->inputs['lastname'] }}

            <div class="clearfix"></div>
            <hr />
            <div class="clearfix"></div>

            {{ $form->inputs['addressLine1'] }}
            {{ $form->inputs['addressLine2'] }}
            {{ $form->inputs['zipCode'] }}
            {{ $form->inputs['city'] }}
            {{ $form->inputs['country'] }}
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset>
            <legend> {{ $form->fieldsets['contact']->legend }} </legend>
            {{ $form->inputs['phoneNumber'] }}
            {{ $form->inputs['cellularNumber'] }}
            {{ $form->inputs['fax'] }}
            {{ $form->inputs['email'] }}
            {{ $form->inputs['website'] }}
        </fieldset>
    </div>
</div>

{{ $form->fieldsets['submits'] }}