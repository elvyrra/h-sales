<?php

/**
 * SettingsController.php
 */

namespace Hawk\Plugins\HSales;

class SettingsController extends Controller{
    
    /**
     * Edit settings h-sales
     */
    public function index(){
        $form = new Form(array(
            'id' => 'h-sales-settings-form',
            'fieldsets' => array(
                'identity' => array(
                    'legend' => Lang::get($this->_plugin . '.settings-form-identity-legend'),

                    new ObjectInput(array(
                        'name'       => 'settings',
                        'hidden'     => true,
                        'attributes' => array(
                            'e-value' => 'settings'
                        ),
                        'default'    => Option::get($this->_plugin . '.settings'),
                    )),

                    new TextInput(array(
                        'name'       => 'status',
                        'label' => Lang::get($this->_plugin . '.settings-form-status-label'),
                        'attributes' => array(
                            'e-value' => 'settings.status'
                        ),
                    )),

                    new TextInput(array(
                        'name'       => 'companyName',
                        'label' => Lang::get($this->_plugin . '.settings-form-companyName-label'),
                        'attributes' => array(
                            'e-value' => 'settings.companyName'
                        )
                    )),

                    new TextInput(array(
                        'name'       => 'tradeName',
                        'label' => Lang::get($this->_plugin . '.settings-form-tradeName-label'),
                        'attributes' => array(
                            'e-value' => 'settings.tradeName'
                        )
                    )),

                    new TextInput(array(
                        'name'       => 'siren',
                        'label' => Lang::get($this->_plugin . '.settings-form-siren-label'),
                        'attributes' => array(
                            'e-value' => 'settings.siren'
                        ),
                    )),

                    new TextInput(array(
                        'name'       => 'siret',
                        'label' => Lang::get($this->_plugin . '.settings-form-siret-label'),
                        'attributes' => array(
                            'e-value' => 'settings.siret'
                        ),
                    )),

                    new TextInput(array(
                        'name'       => 'tva',
                        'label' => Lang::get($this->_plugin . '.settings-form-tva-label'),
                        'attributes' => array(
                            'e-value' => 'settings.tva'
                        ),
                    )),

                    new TextInput(array(
                        'name'       => 'capital',
                        'label' => Lang::get($this->_plugin . '.settings-form-capital-label'),
                        'attributes' => array(
                            'e-value' => 'settings.capital'
                        ),
                    )),

                    new FileInput(array(
                        'name' => 'logo',
                        'extensions' => array('jpeg', 'png'),
                        'label' => Lang::get($this->_plugin . '.image-label'),
                        'before' => '<div>',
                        'after' => sprintf('<img src="%s" class="profile-image" /></div>', Option::get($this->_plugin . '.logo') ? Option::get($this->_plugin . '.logo') : ''),
                    )),
                ),


                'informations' => array(
                    'legend' => Lang::get($this->_plugin . '.settings-form-informations-legend'),

                    new TextInput(array(
                        'name'       => 'phone',
                        'label' => Lang::get($this->_plugin . '.settings-form-phone-label'),
                        'attributes' => array(
                            'e-value' => 'settings.phone'
                        ),
                    )),

                    new TextInput(array(
                        'name'       => 'fax',
                        'label' => Lang::get($this->_plugin . '.settings-form-fax-label'),
                        'attributes' => array(
                            'e-value' => 'settings.fax'
                        ),
                    )),

                    new TextInput(array(
                        'name'       => 'email',
                        'label' => Lang::get($this->_plugin . '.settings-form-email-label'),
                        'attributes' => array(
                            'e-value' => 'settings.email'
                        ),
                    )),

                    new TextareaInput(array(
                        'name'       => 'address',
                        'label' => Lang::get($this->_plugin . '.settings-form-address-label'),
                        'attributes' => array(
                            'e-value' => 'settings.address'
                        ),
                    )),

                    new TextInput(array(
                        'name'       => 'postalCode',
                        'label' => Lang::get($this->_plugin . '.settings-form-postalCode-label'),
                        'attributes' => array(
                            'e-value' => 'settings.postalCode'
                        ),
                    )),

                    new TextInput(array(
                        'name'       => 'city',
                        'label' => Lang::get($this->_plugin . '.settings-form-city-label'),
                        'attributes' => array(
                            'e-value' => 'settings.city'
                        ),
                    )),

                    new TextInput(array(
                        'name'       => 'country',
                        'label' => Lang::get($this->_plugin . '.settings-form-country-label'),
                        'attributes' => array(
                            'e-value' => 'settings.country'
                        ),
                    )),
                ),

                '_submits' => array(
                    new SubmitInput(array(
                        'name' => 'valid',
                        'value' => Lang::get('main.valid-button')
                    )),

                    new ButtonInput(array(
                        'name' => 'cancel',
                        'value' => Lang::get('main.cancel-button'),
                        'onclick' => 'app.load(app.getUri("h-sales-clients"));'
                    ))
                )
            ),
            'onsuccess' => 'app.load(app.getUri("h-sales-settings"));'
        ));

        if(!$form->submitted()){
            $this->addJavaScript($this->getPlugin()->getjsUrl('settings.js'));

            return NoSidebarTab::make(array(
                'title' => Lang::get($this->_plugin . '.settings-form-title'),
                'icon' => 'cogs',
                'page' => $form->wrap(View::make($this->getPlugin()->getView('settings-form.tpl'), array(
                    'form' => $form
                )))
            ));
        }
        else{
            if($form->check()) {
                
                Option::set($this->_plugin . '.settings', $form->getData('settings'));

                try{
                    /*
                    $uploaderLogo = Upload::getInstance('logo');
                    if($uploaderLogo){
                        $fileLogo = $uploaderLogo->getFile();
                        $basename =  $plugin->name . '.' . $fileLogo->extension;

                        if(! is_dir($plugin->getLogoDir())){
                            mkdir($plugin->getLogoDir(), 0775, true);
                        }

                        $uploaderLogo->move($fileLogo, $plugin->getLogoDir(), $basename);
                        Option::set($this->_plugin . '.logo', $basename);
                    }*/

                    $upload = Upload::getInstance('logo');
                    if($upload) {
                        $file = $upload->getFile(0);

                        $dir = Plugin::current()->getPublicUserfilesDir()  . 'img/';
                        $url = Plugin::current()->getUserfilesUrl() . 'img/';
                        
                        if(!is_dir($dir)) {
                            mkdir($dir, 0755, true);
                        }

                        $basename = uniqid() . '.' . $file->extension;
                        $upload->move($file, $dir, $basename);
                                    
                        Option::set($this->_plugin . '.logo', ($url . $basename));
                    }
                }
                catch(\Exception $e){
                    return $form->response(Form::STATUS_ERROR, DEBUG_MODE ? $e->getMessage() : Lang::get('store.register-plugin-error'));
                }

                return $form->response(Form::STATUS_SUCCESS);
            }
        }
    }
}