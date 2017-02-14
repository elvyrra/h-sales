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
            'fields' => array(

            )
        ));
    }


    /**
     * Display the list of templates
     */
    public function displayList() {

    }


    /**
     * Edit a template
     */
    public function edit() {

    }
}
