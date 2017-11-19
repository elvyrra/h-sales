<?php

/**
 * ClientController.php
 */

namespace Hawk\Plugins\HSales;

class ClientController extends Controller{
    /**
     * Index page
     */
    public function index(){
        $list = new ItemList(array(
            'id' => 'clients-list',
            'model' => 'Client',
            'controls' => array(
                App::session()->isAllowed($this->_plugin . '.edit-client-file') ?
                    array(
                        'icon' => 'plus',
                        'class' => 'btn-success',
                        'label' => Lang::get($this->_plugin . '.new-client-btn'),
                        'href' => App::router()->getUri('h-sales-client-file', array('id' => 0))
                    )
                : null
            ),
            'fields' => array(
                'displayName' => array(
                    'field' => 'IF(!pro, CONCAT_WS(" ", firstname, lastname), companyName)',
                    'label' => Lang::get($this->_plugin . '.clients-list-display-name-label'),
                    'href' => function($value, $field, $client){
                        return App::router()->getUri('h-sales-client-file', array(
                            'id' => $client->id
                        ));
                    }
                ),

                'address' => array(
                    'field' => 'CONCAT_WS("<br />", addressLine1, addressLine2, zipCode, city, country)',
                    'label' => Lang::get($this->_plugin . '.clients-list-address-label')
                ),

                'phoneNumber' => array(
                    'label' => Lang::get($this->_plugin . '.clients-list-phoneNumber-label')
                ),

                'cellularNumber' => array(
                    'label' => Lang::get($this->_plugin . '.clients-list-cellularNumber-label')
                ),

                'email' => array(
                    'label' => Lang::get($this->_plugin . '.clients-list-email-label')
                )
            )
        ));

        if(App::request()->getParams('refresh')){
            return $list->display();
        }
        return NoSidebarTab::make(array(
            'title' => Lang::get($this->_plugin . '.clients-list-title'),
            'icon' => 'suitcase',
            'page' => $list
        ));
    }


    /**
     * Edit a client file
     */
    public function edit(){
        $form = new Form(array(
            'id' => 'client-form',
            'model' => 'Client',
            'reference' => array('id' => $this->id),
            'columns' => 2,
            'fieldsets' => array(
                'identity' => array(
                    'legend' => Lang::get($this->_plugin . '.client-form-identity-legend'),

                    ($this->id) ? null : new HiddenInput(array(
                        'name' => 'creationDate',
                        'value' => time()
                    )),

                    new HiddenInput(array(
                        'name' => 'modificationDate',
                        'value' => time()
                    )),

                    new RadioInput(array(
                        'name' => 'pro',
                        'options' => array(
                            0 => Lang::get($this->_plugin . '.client-form-pro-individual-label'),
                            1 => Lang::get($this->_plugin . '.client-form-pro-pro-label')
                        ),
                        'label' => Lang::get($this->_plugin . '.client-form-pro-label'),
                        'default' => 0,
                        'attributes' => array(
                            'e-value' => 'pro'
                        )
                    )),

                    new TextInput(array(
                        'name' => 'companyName',
                        'label' => Lang::get($this->_plugin . '.client-form-companyName-label'),
                        'required' => App::request()->getBody('pro'),
                        'labelClass' => 'required'
                    )),

                    new TextInput(array(
                        'name' => 'firstname',
                        'label' => Lang::get($this->_plugin . '.client-form-firstname-label'),
                        'required' => true
                    )),

                    new TextInput(array(
                        'name' => 'lastname',
                        'label' => Lang::get($this->_plugin . '.client-form-lastname-label'),
                        'required' => true
                    ))
                ),

                'contact' => array(
                    'legend' => lang::get($this->_plugin . '.client-form-contact-legend'),

                    new TextInput(array(
                        'name' => 'addressLine1',
                        'label' => Lang::get($this->_plugin . '.client-form-addressLine1-label')
                    )),

                    new TextInput(array(
                        'name' => 'addressLine2',
                        'label' => Lang::get($this->_plugin . '.client-form-addressLine2-label')
                    )),

                    new TextInput(array(
                        'name' => 'zipCode',
                        'label' => Lang::get($this->_plugin . '.client-form-zipCode-label')
                    )),

                    new TextInput(array(
                        'name' => 'city',
                        'label' => Lang::get($this->_plugin . '.client-form-city-label')
                    )),

                    new TextInput(array(
                        'name' => 'country',
                        'label' => Lang::get($this->_plugin . '.client-form-country-label')
                    )),

                    new TextInput(array(
                        'name' => 'phoneNumber',
                        'label' => Lang::get($this->_plugin . '.client-form-phoneNumber-label')
                    )),

                    new TextInput(array(
                        'name' => 'cellularNumber',
                        'label' => Lang::get($this->_plugin . '.client-form-cellularNumber-label')
                    )),

                    new TextInput(array(
                        'name' => 'fax',
                        'label' => Lang::get($this->_plugin . '.client-form-fax-label')
                    )),

                    new EmailInput(array(
                        'name' => 'email',
                        'label' => Lang::get($this->_plugin . '.client-form-email-label')
                    )),

                    new TextInput(array(
                        'name' => 'website',
                        'label' => Lang::get($this->_plugin . '.client-form-website-label'),
                    )),
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
                        'href' => App::router()->getUri('h-sales-clients')
                    ))
                )
            ),
            'onsuccess' => 'app.load(app.getUri("h-sales-clients"));'
        ));

        if(!$form->submitted()){
            $this->addJavaScript($this->getPlugin()->getjsUrl('clients.js'));

            return NoSidebarTab::make(array(
                'title' => $this->id ?
                            Lang::get($this->_plugin . '.client-form-title', array(
                                'client' => $form->getData('firstname') . ' ' . $form->getData('lastname')
                            )) :
                            Lang::get($this->_plugin . '.client-form-new-title'),
                'icon' => 'suitcase',
                'page' => $form->wrap(View::make($this->getPlugin()->getView('client-form.tpl'), array(
                    'form' => $form
                )))
            ));
        }
        else{
            return $form->treat();
        }
    }


    /**
     * Autocomplete client list by name
     */
    public function autocomplete(){
        App::response()->setContentType('json');

        $search = App::request()->getParams('q');

        if(!$search){
            return array();
        }

        $example = new DBExample(array(
            '$or' => array(
                array(
                    '$and' => array(
                        'pro' => 0,
                        'CONCAT_WS(" ", firstname, lastname)' => array(
                            '$like' => '%' . $search . '%'
                        )
                    )
                ),

                array(
                    '$and' => array(
                        'pro' => 1,
                        'companyName' => array(
                            '$like' => '%' . $search . '%'
                        )
                    )
                )
            )
        ));

        $clients = Client::getListByExample(
            $example,
            null,
            array(
                '*',
                'IF(pro, companyName, CONCAT_WS (" " , firstname, lastname))' => 'label'
            )
        );

        return $clients;
    }
}