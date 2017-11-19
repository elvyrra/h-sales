{assign name="identity"}
    <div class="row">
        <div class="col-sm-6">
            {{ $form->inputs['code'] }}
            {{ $form->inputs['title'] }}
            {{ $form->inputs['ctime'] }}
            {{ $form->inputs['userId'] }}
            {{ $form->inputs['mtime'] }}
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                {{ $form->inputs['status'] }}
                {{ $form->inputs['billed'] }}
            </div>
        </div>
    </div>

    <fieldset>
        <legend>{text key='h-sales.bill-form-client-panel-title'}</legend>
        {{ $form->inputs['clientId'] }}
        {{ $form->inputs['clientName'] }}
        {{ $form->inputs['clientAddressLine1'] }}
        {{ $form->inputs['clientAddressLine2'] }}
        {{ $form->inputs['clientZipCode'] }}
        {{ $form->inputs['clientCity'] }}
        {{ $form->inputs['clientCountry'] }}
    </fieldset>

{/assign}

{assign name="content"}
    {{ $form->inputs['content'] }}
    <div class="row">
        <div class="col-xs-12">
            {button class="btn-primary" icon="font" label="{text key='h-sales.bill-form-add-title'}" e-click="$root.addLine(null, null, true)"}
            {button class="btn-success" icon="plus-circle" label="{text key='h-sales.bill-form-add-line'}" e-click="$root.addLine()"}
        </div>
    </div>
    <div class="row content-title">
        <div class="col-xs-1 line-actions"></div>
        <div class="col-xs-1">{text key="h-sales.bill-form-line-number"}</div>
        <div class="col-xs-5 line-label">{text key="h-sales.bill-form-line-title"}</div>
        <div class="col-xs-1">{text key="h-sales.bill-form-line-quantity"}</div>
        <div class="col-xs-1">{text key="h-sales.bill-form-line-unit"}</div>
        <div class="col-xs-1">{text key="h-sales.bill-form-line-unit-price"}</div>
        <div class="col-xs-1">{text key="h-sales.bill-form-line-duty-total"}</div>
        <div class="col-xs-1">{text key="h-sales.bill-form-line-tax-rate"}</div>
    </div>

    <template id="bill-line-template">
        <div class="row content-line" e-class="{
                                            ['level-' + level] : true,
                                            'title-line' : isTitle,
                                            'text-primary' : isTitle && level === 1,
                                            'text-info' : isTitle && level === 2,
                                            'text-success' : isTitle && level === 3,
                                        }">
            <div class="col-xs-1 line-actions" e-style="{width : width1 + 'px'}">
                <div class="dropdown">
                    {icon icon="arrows" class="move-line pointer"}
                    {icon icon="bars" data-toggle="dropdown" class="dropdown-toggle pointer text-primary pull-right"}
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" e-click="$root.addLine($this, null, true)" e-show="isTitle && level < $this.constructor.MAX_DEPTH - 1">
                                {icon icon="indent" size="fw" class="text-primary"} {text key="h-sales.bill-form-add-subtitle"}
                            </a>
                        </li>
                        <li>
                            <a href="#" e-click="$root.addLine($this.getParent(), $index, true)" e-show="isTitle">
                                {icon icon="caret-up" size="fw" class="text-primary"} {text key="h-sales.bill-form-add-title-before"}
                            </a>
                        </li>
                        <li>
                            <a href="#" e-click="$root.addLine($this.getParent(), $index + 1, true)" e-show="isTitle">
                                {icon icon="caret-down" size="fw" class="text-primary"} {text key="h-sales.bill-form-add-title-after"}
                            </a>
                        </li>
                        <li role="separator" class="divider" e-show="isTitle"></li>
                        <li>
                            <a href="#" e-click="$root.addLine($this)" e-show="isTitle">
                                {icon icon="plus-circle" size="fw" class="text-info"} {text key="h-sales.bill-form-add-line-under"}
                            </a>
                        </li>
                        <li>
                            <a href="#" e-click="$root.addLine($this.getParent(), $index)" e-show="!isTitle">
                                {icon icon="caret-up" size="fw" class="text-info"} {text key="h-sales.bill-form-add-line-before"}
                            </a>
                        </li>
                        <li>
                            <a href="#" e-click="$root.addLine($this.getParent(), $index + 1)" e-show="!isTitle">
                                {icon icon="caret-down" size="fw" class="text-info"} {text key="h-sales.bill-form-add-line-after"}
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="#" e-click="$root.deleteLine($this, false)">
                                {icon icon="trash" size="fw" class="text-danger"} {text key="h-sales.bill-form-delete-line"}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-1 line-number" e-style="{width : width1 + 'px'}">${number}</div>
            <div class="col-xs-5 line-label" e-style="{width : width5 + 'px'}">
                <input type="text" e-value="label" e-if="isTitle" />
                <div contenteditable e-value="label" e-unless="isTitle"></div>
            </div>
            <div class="col-xs-1 line-quantity" min="0" e-style="{width : width1 + 'px'}"><input type="number" e-value="quantity" /></div>
            <div class="col-xs-1 line-unit" e-style="{width : width1 + 'px'}"><input type="text" e-value="unit" e-unless="isTitle"/></div>
            <div class="col-xs-1 line-unit-price" min="0" e-style="{width : width1 + 'px'}"><input type="number" e-unless="isTitle" e-value="unitPrice" /></div>
            <div class="col-xs-1 line-duty-total" e-style="{width : width1 + 'px'}">${total.duty.toFixed(2)}</div>
            <div class="col-xs-1 line-tax-rate" min="0" max="100" e-style="{width : width1 + 'px'}"><input type="number" e-value="taxRate" e-unless="isTitle"/></div>
        </div>
        <ol e-if="isTitle" class="children">
            <li e-each="{$data : $this.content}" e-template="'bill-line-template'"></li>
        </ol>
    </template>

    <ol class="content-wrapper sortable" id="bill-content-container">
        <li e-each="{$data : $root.content}" e-template="'bill-line-template'"></li>
    </ol>
{/assign}

{assign name="footer"}
    {{ $form->inputs['dutyTotal'] }}
    {{ $form->inputs['taxes'] }}
    {{ $form->inputs['atiTotal'] }}
{/assign}

{assign name="formContent"}
    {{ $form->fieldsets['submits'] }}

    {tabs id="bill-accordion" tabs="{array(
        array(
            'title' => Lang::get('h-sales.bill-form-panel-identity-title'),
            'type' => 'primary',
            'content' => $identity,
            'id' => 'h-sales-bill-form-header'
        ),
        array(
            'title' => Lang::get('h-sales.bill-form-panel-content-title'),
            'type' => 'primary',
            'content' => $content,
            'id' => 'h-sales-bill-form-body'
        ),
        array(
            'title' => Lang::get('h-sales.bill-form-panel-footer-title'),
            'type' => 'primary',
            'content' => $footer,
            'id' => 'h-sales-bill-form-footer'
        ))}"}

{/assign}

{form id="h-sales-bill-form" content="{$formContent}"}