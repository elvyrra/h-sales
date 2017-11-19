<?php

/**
 * BillController.php
 */

namespace Hawk\Plugins\HSales;

class BillController extends Controller
{
    /**
     * Index page
     */
    public function index(){

        $list = new ItemList(array(
            'id' => 'bills-list',
            'model' => 'Bill',
            'controls' => array(
                App::session()->isAllowed($this->_plugin . '.edit-bill') ?
                    array(
                        'icon' => 'plus',
                        'class' => 'btn-success',
                        'label' => Lang::get($this->_plugin . '.new-bill-btn'),
                        'href' => App::router()->getUri('h-sales-bill-file', array(
                            'id' => 0,
                            'from' => 0,
                        ))
                    ) : null
            ),
            'fields' => array(
                'code' => array(
                    'label' => Lang::get($this->_plugin . '.bills-list-code-label'),
                    'href' => function($value, $field, $bill){
                        return App::router()->getUri('h-sales-bill-edit', array(
                            'id' => $bill->id
                        ));
                    }
                ),

                'title' => array(
                    'label' => Lang::get($this->_plugin . '.bills-list-title-label')
                ),

                'clientId' => array(
                    'label' => Lang::get($this->_plugin . '.bills-list-client-label'),
                    'display' => function($value) {
                        return Client::getById($value)->getDisplayedName();
                    },
                    'href' => function($value) {
                        return App::router()->getUri('h-sales-client-file', array(
                            'id' => $value
                        ));
                    },
                    'target' => 'newtab'
                ),

                'dutyTotal' => array(
                    'label' => Lang::get($this->_plugin . '.bills-list-duty-total-label'),
                    'display' => function($value){
                        return number_format($value, 2) . ' '. Option::get($this->_plugin . '.currency');
                    }
                )
            )
        ));

        if(App::request()->getParams('refresh')){
            return $list->display();
        }

        return NoSidebarTab::make(array(
            'title' => Lang::get($this->_plugin . '.bills-list-title'),
            'icon' => 'list-alt',
            'page' => $list
        ));
    }

    /**
     * Edit a quote
     */
    public function edit(){
        $bill = Bill::getById($this->id);

        if($bill){
            $client = Client::getById($bill->clientId);
        }
        else{
            $client = null;
        }

        $form = new Form(array(
            'id' => 'h-sales-bill-form',
            'action' => App::router()->getUri('h-sales-bill-edit', array(
                'id' => $this->id
            )),
            'object' => $bill,
            'model' => 'Bill',
            'reference' => array(
                'id' => $this->id
            ),
            'fieldsets' => array(
                'identity' => array(
                    new HiddenInput(array(
                        'name' => 'ctime',
                        'value' => time(),
                        'notDisplayed' => (bool) $bill
                    )),

                    new HiddenInput(array(
                        'name' => 'mtime',
                        'value' => time()
                    )),

                    new HiddenInput(array(
                        'name' => 'userId',
                        'default' => App::session()->getUser()->id,
                        'notDisplayed' => (bool) $bill
                    )),

                    new TextInput(array(
                        'name' => 'code',
                        'readonly' => (bool) $bill,
                        'required' => true,
                        'maxLength' => 64,
                        'label' => Lang::get($this->_plugin . '.bill-form-code-label'),
                        'default' => $this->getNewBillCode()
                    )),

                    new HiddenInput(array(
                        'name' => 'clientId',
                        'required' => true,
                        'errorAt' => 'clientName',
                        'attributes' => array(
                            'e-value' => 'client.id'
                        )
                    )),

                    new TextInput(array(
                        'name' => 'clientName',
                        'required' => true,
                        'independant' => true,
                        'label' => Lang::get($this->_plugin . '.bill-form-client-name-label'),
                        'default' => $client ? $client->getDisplayedName() : '',
                        'attributes' => array(
                            'e-autocomplete' => '{source : "' . App::router()->getUri('h-sales-autocomplete-clients') . '", change : onClientChange}',
                            'e-value' => 'client.label',
                            'style' => "width: 300px;",
                        )
                    )),

                    new TextInput(array(
                        'name' => 'clientAddressLine1',
                        'independant' => true,
                        'readonly' => true,
                        'label' => Lang::get($this->_plugin . '.bill-form-client-address-line1-label'),
                        'default' => $client ? $client->addressLine1 : '',
                        'attributes' => array(
                            'e-value' => 'client.addressLine1'
                        )
                    )),

                    new TextInput(array(
                        'name' => 'clientAddressLine2',
                        'independant' => true,
                        'readonly' => true,
                        'label' => Lang::get($this->_plugin . '.bill-form-client-address-line2-label'),
                        'default' => $client ? $client->addressLine2 : '',
                        'attributes' => array(
                            'e-value' => 'client.addressLine2'
                        )
                    )),

                    new TextInput(array(
                        'name' => 'clientZipCode',
                        'independant' => true,
                        'readonly' => true,
                        'label' => Lang::get($this->_plugin . '.bill-form-client-zipcode-label'),
                        'default' => $client ? $client->zipCode : '',
                        'attributes' => array(
                            'e-value' => 'client.zipCode'
                        )
                    )),

                    new TextInput(array(
                        'name' => 'clientCity',
                        'independant' => true,
                        'readonly' => true,
                        'label' => Lang::get($this->_plugin . '.bill-form-client-city-label'),
                        'default' => $client ? $client->city : '',
                        'attributes' => array(
                            'e-value' => 'client.city'
                        )
                    )),

                    new TextInput(array(
                        'name' => 'clientCountry',
                        'independant' => true,
                        'readonly' => true,
                        'label' => Lang::get($this->_plugin . '.bill-form-client-country-label'),
                        'default' => $client ? $client->country : '',
                        'attributes' => array(
                            'e-value' => 'client.country'
                        )
                    )),

                    new TextInput(array(
                        'name' => 'title',
                        'required' => true,
                        'maxLength' => 256,
                        'attributes' => array(
                            'style' => "width: 300px;",
                        ),
                        'label' => Lang::get($this->_plugin . '.bill-form-title-label'),
                    )),

                    new SelectInput(array(
                        'name' => 'status',
                        'required' => true,
                        'options' => $this->getStatusOptions(),
                        'default' => 'edition',
                        'label' => Lang::get($this->_plugin . '.quote-form-status-label'),
                        'attributes' => array(
                            'e-value' => 'status'
                        )
                    )),

                    new RadioInput(array(
                        'name' => 'billed',
                        'readonly' => true,
                        'label' => 'Facturé ?',
                        'options' => array(
                            0 => Lang::get('main.no-txt'),
                            1 => Lang::get('main.yes-txt')
                        )
                    ))
                ),

                'content' => array(
                    new ObjectInput(array(
                        'name' => 'content',
                        'hidden' => true,
                        'default' => '[]',
                        'attributes' => array(
                            'e-value' => 'content.toString()'
                        )
                    )),
                ),

                'totals' => array(
                    new FloatInput(array(
                        'name' => 'dutyTotal',
                        'required' => true,
                        'readonly' => true,
                        'label' => Lang::get($this->_plugin . '.bill-form-duty-total-label'),
                        'attributes' => array(
                            'e-value' => 'total.duty.toFixed(2)'
                        )
                    )),

                    new FloatInput(array(
                        'name' => 'taxes',
                        'required' => true,
                        'readonly' => true,
                        'label' => Lang::get($this->_plugin . '.bill-form-taxes-label'),
                        'attributes' => array(
                            'e-value' => 'total.taxes.toFixed(2)'
                        )
                    )),

                    new FloatInput(array(
                        'name' => 'atiTotal',
                        'required' => true,
                        'readonly' => true,
                        'label' => Lang::get($this->_plugin . '.bill-form-ati-total-label'),
                        'attributes' => array(
                            'e-value' => 'total.ati.toFixed(2)'
                        )
                    ))
                ),

                'submits' => array(
                    new SubmitInput(array(
                        'name' => 'valid',
                        'value' => Lang::get('main.valid-button')
                    )),

                    new DeleteInput(array(
                        'name' => 'delete',
                        'value' => Lang::get('main.delete-button'),
                        'notDisplayed' => ! $this->id
                    )),

                    new ButtonInput(array(
                        'name' => 'cancel',
                        'value' => Lang::get('main.cancel-button'),
                        'onclick' => 'app.load(app.getUri("h-sales-quotes"));'
                    ))
                )
            )
        ));

        if(!$form->submitted()){
            $page = View::make($this->getPlugin()->getView('bill-form.tpl'), array(
                'form' => $form
            ));

            $this->addJavaScript($this->getPlugin()->getJsUrl('bill.js'));
            $this->addCss($this->getPlugin()->getCssUrl('bill.less'));

            $this->addKeysToJavaScript(
                $this->_plugin . '.confirm-delete-line',
                $this->_plugin . '.confirm-delete-title'
            );

            return RightSidebarTab::make(array(
                'icon' => 'list-alt',
                'title' => !$this->id ?
                    Lang::get($this->_plugin . '.bill-new-form-title') :
                    Lang::get($this->_plugin . '.bill-form-title', array(
                        'code' => $form->getData('code')
                    )),
                'page' => array(
                    'content' => $page
                ),
                'sidebar' => array(/*
                    'widgets' => array(
                        QuoteActionsWidget::getInstance(array(
                            'quote' => $quote
                        )),
                        QuoteBillsWidget::getInstance(array(
                            'quote' => $quote
                        ))
                    )*/
                )
            ));
        }
        else{
            return $form->treat();
        }
    }

        /**
     * Get the status options
     */
    private function getStatusOptions(){
        $result = array();
        foreach(array('edition', 'sent', 'paid', 'conflict') as $status){
            $result[$status] = Lang::get($this->_plugin . '.bill-status-' . $status);
        }

        return $result;
    }


    /**
     * Get the code for a new quote
     */
    private function getNewBillCode(){
        $pattern = Option::get($this->_plugin . '.bill-number-pattern');

        $replaces = array(
            '{year4}' => date('Y'),
            '{year2}' => date('y'),
            '{month}' => date('m'),
            '{day}' => date('d')
        );

        $code = str_replace(array_keys($replaces), $replaces, $pattern);

        $counterTag = '{counter}';
        if(strpos($code, $counterTag) !== false){
            $counter = 1;
            // Search for documents with the same pattern, and get the max current counter value
            $quotes = Quote::getListByExample(
                new DBExample(array(
                    'code' => array(
                        '$like' => str_replace($counterTag, '%', $code)
                    )
                )),
                null,
                array('code'),
                array('code' => DB::SORT_DESC)
            );


            if(!empty($quotes)){
                $last = $quotes[0]->code;

                $regex = '/^' . preg_quote(str_replace($counterTag, '(\d+)', $code), '/') . '$/';

                $code = preg_replace_callback($regex, function($matches){
                    return (int) $matches[1] + 1;
                }, $code);
            }

            $code = str_replace($counterTag, $counter, $code);
        }

        return $code;
    }


}//end class
