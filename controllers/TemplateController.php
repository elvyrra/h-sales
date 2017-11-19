<?php

/**
 * TemplateController.php
 */

namespace Hawk\Plugins\HSales;

class TemplateController extends Controller {
    /**
     * Index page
     */
    public function index() {
        $list = new ItemList(array(
            'id' => 'h-sales-templates-list',
            'model' => 'DocTemplate',
            'controls' => array(
                App::session()->isAllowed($this->_plugin . '.edit-template') ?
                    array(
                        'icon' => 'plus',
                        'class' => 'btn-success',
                        'label' => Lang::get($this->_plugin . '.new-template-btn'),
                        'href' => App::router()->getUri('h-sales-template-edit', array(
                            'id' => 0
                        ))
                    ) : null
            ),
            'fields' => array(

                'title' => array(
                    'label' => Lang::get($this->_plugin . '.template-list-title-label'),
                    'href' => function($value, $field, $template){
                        return App::router()->getUri('h-sales-template-edit', array(
                            'id' => $template->id
                        ));
                    }
                ),

                'template' => array(
                    'label' => Lang::get($this->_plugin . '.template-list-preview-label'),
                    'display' => function($value) {
                        return '';
                    },
                    'href' => function($value, $field, $template){
                        return App::router()->getUri('h-sales-template-edit', array(
                            'id' => $template->id
                        ));
                    }
                ),

            )
        ));

        if(App::request()->getParams('refresh')){
            return $list->display();
        }

        return NoSidebarTab::make(array(
            'title' => Lang::get($this->_plugin . '.template-list-title'),
            'icon' => 'picture-o',
            'page' => $list
        ));
    }

    /**
     * Edit a template
     */
    public function edit() {
        $template = DocTemplate::getById($this->id);

        $content = "{}";

        if($template)
            $content = $template->template;

        $form = new Form(array(
            'id' => 'h-sales-template-form',
            'action' => App::router()->getUri('h-sales-template-edit', array(
                'id' => $this->id
            )),
            'object' => $template,
            'model' => 'DocTemplate',
            'reference' => array(
                'id' => $this->id
            ),
            'fieldsets' => array(
                'identity' => array(
                    new TextInput(array(
                        'name' => 'title',
                        'required' => true,
                        'maxLength' => 256,
                        'attributes' => array(
                            'style' => "width: 300px;",
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-title-label'),
                    )),

                    new ObjectInput(array(
                        'name'       => 'settings',
                        'hidden'     => true,
                        'attributes' => array(
                            'e-value' => 'settings'
                        ),
                        'default'    => Option::get($this->_plugin . '.settings'),
                    )),

                    new ObjectInput(array(
                        'name'       => 'logo',
                        'hidden'     => true,
                        'attributes' => array(
                            'e-value' => 'logo'
                        ),
                        'default'    => Option::get($this->_plugin . '.logo'),
                    )),
                ),

                'pageHeader' => array(
                    new SelectInput(array(
                        'name' => 'fontFamily',
                        'options' => array(
                            'Verdana' => 'Verdana',
                            'Times New Roman' => 'Times New Roman',
                            'Comic sans ms' => 'Comic sans ms',
                            'Trebuchet' => 'Trebuchet',
                            'Arial black' => 'Arial black',
                            'Arial' => 'Arial',
                            'Courrier New' => 'Courrier New',
                            'Georgia' => 'Georgia',
                            'Impact' => 'Impact'
                        ),
                        'attributes' => array(
                           'e-value' => 'pageHeader.fontFamily'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-fontFamily-label'),
                    )),

                    new SelectInput(array(
                        'name' => 'fontSize',
                        'options' => array(
                            '5pt' => '5pt',
                            '6pt' => '6pt',
                            '7pt' => '7pt',
                            '8pt' => '8pt',
                            '9pt' => '9pt',
                            '10pt' => '10pt',
                            '11pt' => '11pt',
                            '12pt' => '12pt',
                            '13pt' => '13pt',
                            '14pt' => '14pt',
                            '15pt' => '15pt',
                        ),
                        'attributes' => array(
                           'e-value' => 'pageHeader.fontSize'
                        ),
                        //'label' => Lang::get($this->_plugin . '.template-form-fontSize-label'),
                        'nl' => false
                    )),

                    new ColorInput(array(
                        'name' => 'color',
                        'attributes' => array(
                           'e-value' => 'pageHeader.color'
                        ),
                        'default' => '#171111',
                        'label' => Lang::get($this->_plugin . '.template-form-color-label'),
                    )),

                    new CheckboxInput(array(
                        'name' => 'bold',
                        'label' => Lang::get($this->_plugin . '.template-form-bold-label'),
                        'attributes' => array(
                           'e-value' => 'pageHeader.bold'
                        ),
                        'labelWidth'  => 'auto',
                    )),

                    new CheckboxInput(array(
                        'name' => 'italic',
                        'label' => Lang::get($this->_plugin . '.template-form-italic-label'),
                        'dataType' => 'bool',
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'pageHeader.italic'
                        ),
                        'nl' => false,
                        'labelWidth'  => 'auto',
                    )),

                    new CheckboxInput(array(
                        'name' => 'underline',
                        'label' => Lang::get($this->_plugin . '.template-form-underline-label'),
                        'dataType' => 'bool',
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'pageHeader.underline'
                        ),
                        'nl' => false,
                        'labelWidth'  => 'auto',
                    )),

                    new SelectInput(array(
                        'name' => 'left',
                        'options' => array(
                            '' => ' - ',
                            'number' => Lang::get($this->_plugin . '.template-form-number-file-label'),
                            'ctime' => Lang::get($this->_plugin . '.template-form-date-ctime-label'),
                            'mtime' => Lang::get($this->_plugin . '.template-form-date-mtime-label'),
                            'siren' => Lang::get($this->_plugin . '.template-form-date-siren-label'),
                            'tva' => Lang::get($this->_plugin . '.template-form-date-tva-label'),
                            'companyName' => Lang::get($this->_plugin . '.template-form-companyName-label'),
                            'companyAddress' => Lang::get($this->_plugin . '.template-form-companyAddress-label'),
                            'correspondance' => Lang::get($this->_plugin . '.template-form-correspondence-label'),
                            'status' => Lang::get($this->_plugin . '.template-form-status-label')
                        ),
                        'attributes' => array(
                           'e-value' => 'pageHeader.left'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-left-label'),
                    )),

                    new SelectInput(array(
                        'name' => 'center',
                        'options' => array(
                            '' => ' - ',
                            'number' => Lang::get($this->_plugin . '.template-form-number-file-label'),
                            'ctime' => Lang::get($this->_plugin . '.template-form-date-ctime-label'),
                            'mtime' => Lang::get($this->_plugin . '.template-form-date-mtime-label'),
                            'siren' => Lang::get($this->_plugin . '.template-form-date-siren-label'),
                            'tva' => Lang::get($this->_plugin . '.template-form-date-tva-label'),
                            'companyName' => Lang::get($this->_plugin . '.template-form-companyName-label'),
                            'companyAddress' => Lang::get($this->_plugin . '.template-form-companyAddress-label'),
                            'correspondance' => Lang::get($this->_plugin . '.template-form-correspondence-label'),
                            'status' => Lang::get($this->_plugin . '.template-form-status-label')
                        ),
                        'attributes' => array(
                           'e-value' => 'pageHeader.center'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-center-label'),
                    )),

                    new SelectInput(array(
                        'name' => 'right',
                        'options' => array(
                            '' => ' - ',
                            'number' => Lang::get($this->_plugin . '.template-form-number-file-label'),
                            'ctime' => Lang::get($this->_plugin . '.template-form-date-ctime-label'),
                            'mtime' => Lang::get($this->_plugin . '.template-form-date-mtime-label'),
                            'siren' => Lang::get($this->_plugin . '.template-form-date-siren-label'),
                            'tva' => Lang::get($this->_plugin . '.template-form-date-tva-label'),
                            'companyName' => Lang::get($this->_plugin . '.template-form-companyName-file-label'),
                            'companyAddress' => Lang::get($this->_plugin . '.template-form-companyAddress-label'),
                            'correspondance' => Lang::get($this->_plugin . '.template-form-correspondence-label'),
                            'status' => Lang::get($this->_plugin . '.template-form-status-label')
                        ),
                        'attributes' => array(
                           'e-value' => 'pageHeader.right'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-right-label'),
                    )),

                    new CheckboxInput(array(
                        'name' => 'separator',
                        'label' => Lang::get($this->_plugin . '.template-form-separator-label'),
                        'dataType' => 'bool',
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'pageHeader.separator'
                        ),
                    )),
                ),

                'documentHeader' => array(
                    new SelectInput(array(
                        'name' => 'fontFamily',
                        'options' => array(
                            'Verdana' => 'Verdana',
                            'Times New Roman' => 'Times New Roman',
                            'Comic sans ms' => 'Comic sans ms',
                            'Trebuchet' => 'Trebuchet',
                            'Arial black' => 'Arial black',
                            'Arial' => 'Arial',
                            'Courrier New' => 'Courrier New',
                            'Georgia' => 'Georgia',
                            'Impact' => 'Impact'
                        ),
                        'attributes' => array(
                           'e-value' => 'documentHeader.fontFamily'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-fontFamily-label'),
                    )),

                    new SelectInput(array(
                        'name' => 'fontSize',
                        'options' => array(
                            '5pt' => '5pt',
                            '6pt' => '6pt',
                            '7pt' => '7pt',
                            '8pt' => '8pt',
                            '9pt' => '9pt',
                            '10pt' => '10pt',
                            '11pt' => '11pt',
                            '12pt' => '12pt',
                            '13pt' => '13pt',
                            '14pt' => '14pt',
                            '15pt' => '15pt',
                        ),
                        'attributes' => array(
                           'e-value' => 'documentHeader.fontSize'
                        ),
                        'nl' => false,
                        //'label' => Lang::get($this->_plugin . '.template-form-fontSize-label'),
                    )),

                    new ColorInput(array(
                        'name' => 'color',
                        'attributes' => array(
                           'e-value' => 'documentHeader.color'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-color-label'),
                    )),

                    new CheckboxInput(array(
                        'name' => 'bold',
                        'label' => Lang::get($this->_plugin . '.template-form-bold-label'),
                        'attributes' => array(
                           'e-value' => 'documentHeader.bold'
                        ),
                        'labelWidth'  => 'auto',
                    )),

                    new CheckboxInput(array(
                        'name' => 'italic',
                        'label' => Lang::get($this->_plugin . '.template-form-italic-label'),
                        'dataType' => 'bool',
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'documentHeader.italic'
                        ),
                        'nl' => false,
                        'labelWidth'  => 'auto',
                    )),

                    new CheckboxInput(array(
                        'name' => 'underline',
                        'label' => Lang::get($this->_plugin . '.template-form-underline-label'),
                        'dataType' => 'bool',
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'documentHeader.underline'
                        ),
                        'nl' => false,
                        'labelWidth'  => 'auto',
                    )),

                    new SelectInput(array(
                        'name' => 'left',
                        'options' => array(
                            '' => ' - ',
                            'address' => Lang::get($this->_plugin . '.template-form-companyAddress-label'),
                            'addressAndCorrespondance' => Lang::get($this->_plugin . '.template-form-address-and-correspondance-label'),
                            'correspondence' => Lang::get($this->_plugin . '.template-form-correspondence-label'),
                            'logo' => Lang::get($this->_plugin . '.template-form-logo-label'),
                        ),
                        'attributes' => array(
                           'e-value' => 'documentHeader.left'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-left-label'),
                    )),

                    new SelectInput(array(
                        'name' => 'center',
                        'options' => array(
                            '' => ' - ',
                            'address' => Lang::get($this->_plugin . '.template-form-companyAddress-label'),
                            'addressAndCorrespondance' => Lang::get($this->_plugin . '.template-form-address-and-correspondance-label'),
                            'correspondence' => Lang::get($this->_plugin . '.template-form-correspondence-label'),
                            'logo' => Lang::get($this->_plugin . '.template-form-logo-label'),
                        ),
                        'attributes' => array(
                           'e-value' => 'documentHeader.center'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-center-label'),
                    )),

                    new SelectInput(array(
                        'name' => 'right',
                        'options' => array(
                            '' => ' - ',
                            'address' => Lang::get($this->_plugin . '.template-form-companyAddress-label'),
                            'addressAndCorrespondance' => Lang::get($this->_plugin . '.template-form-address-and-correspondance-label'),
                            'correspondence' => Lang::get($this->_plugin . '.template-form-correspondence-label'),
                            'logo' => Lang::get($this->_plugin . '.template-form-logo-label'),
                        ),
                        'attributes' => array(
                           'e-value' => 'documentHeader.right'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-right-label'),
                    )),

                    new SelectInput(array(
                        'name' => 'textAlign',
                        'options' => array(
                            'left' => Lang::get($this->_plugin . '.template-form-text-align-left-label'),
                            'center' => Lang::get($this->_plugin . '.template-form-text-align-center-label'),
                            'right' => Lang::get($this->_plugin . '.template-form-text-align-right-label'),
                        ),
                        'attributes' => array(
                           'e-value' => 'documentHeader.textAlign'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-text-align-label'),
                    )),


                    new CheckboxInput(array(
                        'name' => 'separator',
                        'label' => Lang::get($this->_plugin . '.template-form-separator-label'),
                        'dataType' => 'bool',
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'documentHeader.separator'
                        ),
                    )),

                    new IntegerInput(array(
                        'name' => 'logoHeight',
                        'label' => Lang::get($this->_plugin . '.template-form-logo-size-label'),
                        'dataType' => 'bool',
                        'min' => 30,
                        'max' => 100,
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'documentHeader.logoHeight'
                        ),
                    )),

                    new IntegerInput(array(
                        'name' => 'logoWidth',
                        'dataType' => 'bool',
                        'min' => 30,
                        'max' => 100,
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'documentHeader.logoWidth'
                        ),
                        'nl' => false
                    )),

                    new CheckboxInput(array(
                        'name' => 'separator',
                        'label' => Lang::get($this->_plugin . '.template-form-separator-label'),
                        'dataType' => 'bool',
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'documentHeader.separator'
                        ),
                    )),

                ),

                'documentBody' => array(

                ),
    
                'pageFooter' => array(
                    new SelectInput(array(
                        'name' => 'fontFamily',
                        'options' => array(
                            'Verdana' => 'Verdana',
                            'Times New Roman' => 'Times New Roman',
                            'Comic sans ms' => 'Comic sans ms',
                            'Trebuchet' => 'Trebuchet',
                            'Arial black' => 'Arial black',
                            'Arial' => 'Arial',
                            'Courrier New' => 'Courrier New',
                            'Georgia' => 'Georgia',
                            'Impact' => 'Impact'
                        ),
                        'attributes' => array(
                           'e-value' => 'pageFooter.fontFamily'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-fontFamily-label'),
                    )),

                    new SelectInput(array(
                        'name' => 'fontSize',
                        'options' => array(
                            '5pt' => '5pt',
                            '6pt' => '6pt',
                            '7pt' => '7pt',
                            '8pt' => '8pt',
                            '9pt' => '9pt',
                            '10pt' => '10pt',
                            '11pt' => '11pt',
                            '12pt' => '12pt',
                            '13pt' => '13pt',
                            '14pt' => '14pt',
                            '15pt' => '15pt',
                        ),
                        'attributes' => array(
                           'e-value' => 'pageFooter.fontSize'
                        ),
                        'nl' => false,
                        //'label' => Lang::get($this->_plugin . '.template-form-fontSize-label'),
                    )),

                    new ColorInput(array(
                        'name' => 'color',
                        'attributes' => array(
                           'e-value' => 'pageFooter.color'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-color-label'),
                    )),

                    new CheckboxInput(array(
                        'name' => 'bold',
                        'label' => Lang::get($this->_plugin . '.template-form-bold-label'),
                        'attributes' => array(
                           'e-value' => 'pageFooter.bold'
                        ),
                        'labelWidth'  => 'auto',
                    )),

                    new CheckboxInput(array(
                        'name' => 'italic',
                        'label' => Lang::get($this->_plugin . '.template-form-italic-label'),
                        'dataType' => 'bool',
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'pageFooter.italic'
                        ),
                        'nl' => false,
                        'labelWidth'  => 'auto',
                    )),

                    new CheckboxInput(array(
                        'name' => 'underline',
                        'label' => Lang::get($this->_plugin . '.template-form-underline-label'),
                        'dataType' => 'bool',
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'pageFooter.underline'
                        ),
                        'nl' => false,
                        'labelWidth'  => 'auto',
                    )),

                    new SelectInput(array(
                        'name' => 'left',
                        'options' => array(
                            '' => ' - ',
                            'number' => Lang::get($this->_plugin . '.template-form-number-file-label'),
                            'ctime' => Lang::get($this->_plugin . '.template-form-date-ctime-label'),
                            'mtime' => Lang::get($this->_plugin . '.template-form-date-mtime-label'),
                            'siren' => Lang::get($this->_plugin . '.template-form-date-siren-label'),
                            'tva' => Lang::get($this->_plugin . '.template-form-date-tva-label'),
                            'companyName' => Lang::get($this->_plugin . '.template-form-companyName-file-label'),
                            'companyAddress' => Lang::get($this->_plugin . '.template-form-companyAddress-file-label'),
                            'correspondance' => Lang::get($this->_plugin . '.template-form-correspondance-file-label'),
                            'status' => Lang::get($this->_plugin . '.template-form-status-file-label')
                        ),
                        'attributes' => array(
                           'e-value' => 'pageFooter.left'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-left-label'),
                    )),

                    new SelectInput(array(
                        'name' => 'center',
                        'options' => array(
                            '' => ' - ',
                            'number' => Lang::get($this->_plugin . '.template-form-number-file-label'),
                            'ctime' => Lang::get($this->_plugin . '.template-form-date-ctime-label'),
                            'mtime' => Lang::get($this->_plugin . '.template-form-date-mtime-label'),
                            'siren' => Lang::get($this->_plugin . '.template-form-date-siren-label'),
                            'tva' => Lang::get($this->_plugin . '.template-form-date-tva-label'),
                            'companyName' => Lang::get($this->_plugin . '.template-form-companyName-file-label'),
                            'companyAddress' => Lang::get($this->_plugin . '.template-form-companyAddress-file-label'),
                            'correspondance' => Lang::get($this->_plugin . '.template-form-correspondance-file-label'),
                            'status' => Lang::get($this->_plugin . '.template-form-status-file-label')
                        ),
                        'attributes' => array(
                           'e-value' => 'pageFooter.center'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-center-label'),
                    )),

                    new SelectInput(array(
                        'name' => 'right',
                        'options' => array(
                            '' => ' - ',
                            'number' => Lang::get($this->_plugin . '.template-form-number-file-label'),
                            'ctime' => Lang::get($this->_plugin . '.template-form-date-ctime-label'),
                            'mtime' => Lang::get($this->_plugin . '.template-form-date-mtime-label'),
                            'siren' => Lang::get($this->_plugin . '.template-form-date-siren-label'),
                            'tva' => Lang::get($this->_plugin . '.template-form-date-tva-label'),
                            'companyName' => Lang::get($this->_plugin . '.template-form-companyName-file-label'),
                            'companyAddress' => Lang::get($this->_plugin . '.template-form-companyAddress-file-label'),
                            'correspondance' => Lang::get($this->_plugin . '.template-form-correspondance-file-label'),
                            'status' => Lang::get($this->_plugin . '.template-form-status-file-label')
                        ),
                        'attributes' => array(
                           'e-value' => 'pageFooter.right'
                        ),
                        'label' => Lang::get($this->_plugin . '.template-form-right-label'),
                    )),

                    new CheckboxInput(array(
                        'name' => 'separator',
                        'label' => Lang::get($this->_plugin . '.template-form-separator-label'),
                        'dataType' => 'bool',
                        'default' => false,
                        'attributes' => array(
                           'e-value' => 'pageFooter.separator'
                        ),
                    )),
                ),


                'template_' => array(
                    new ObjectInput(array(
                        'name' => 'content',
                        'hidden' => true,
                        'default' => $content,
                        'attributes' => array(
                            'e-value' => 'content.toString()'
                        )
                    )),
                ),

                '_submits' => array(
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
                        'onclick' => 'app.load(app.getUri("h-sales-templates"));'
                    ))
                )
            )
        ));

        if(!$form->submitted()){
            $page = View::make($this->getPlugin()->getView('template-form.tpl'), array(
                'form' => $form,
                'content' => $content,
            ));

            $this->addJavaScript($this->getPlugin()->getJsUrl('template.js'));
            $this->addCss($this->getPlugin()->getCssUrl('template.less'));

            $this->addKeysToJavaScript(
                $this->_plugin . '.template-form-number-file-label',
                $this->_plugin . '.template-form-number-label',
                $this->_plugin . '.confirm-delete-title'
            );

            return NoSidebarTab::make(array(
                'icon' => 'picture-o',
                'title' => !$this->id ?
                    Lang::get($this->_plugin . '.template-new-form-title') :
                    Lang::get($this->_plugin . '.template-form-title', array(
                        'title' => $form->getData('title')
                    )),
                'page' => array(
                    'content' => $page
                )
            ));
        }
        else{
            return $form->treat();
        }
    }
}
