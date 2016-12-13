<?php

namespace Hawk\Plugins\HSales;

App::router()->prefix('/h-sales', function () {
    /**
     * Clients
     */
    App::router()->auth(App::session()->isAllowed('h-sales.see-client-file'), function () {
        App::router()->get('h-sales-clients', '/clients', array('action' => 'ClientController.index'));


        App::router()->auth(App::session()->isAllowed('h-sales.edit-client-file'), function () {
            // Insert / Modify client file
            App::router()->any('h-sales-client-edit', '/clients/{id}', array('where' => array('id' => '\d+'), 'action' => 'ClientController.edit'));
        });
        // Display client file
        App::router()->get('h-sales-client-file', '/clients/{id}', array('where' => array('id' => '\d+'), 'action' => 'ClientController.edit'));

        // Autocomplete client
        App::router()->get('h-sales-autocomplete-clients', '/clients/autocomplete', array('action' => 'ClientController.autocomplete'));
    });

    /**
     * Quotes
     */
    App::router()->auth(App::session()->isAllowed('h-sales.see-quotes'), function () {
        App::router()->get('h-sales-quotes', '/quotes', array('action' => 'QuoteController.index'));

        // Display quote file
        App::router()->get('h-sales-quote-file', '/quotes/{id}', array('where' => array('id' => '\d+'), 'action' => 'QuoteController.edit'));

        App::router()->auth(App::session()->isAllowed('h-sales.edit-quote'), function () {
            // Insert / Modify quote file
            App::router()->any('h-sales-quote-edit', '/quote/{id}', array('where' => array('id' => '\d+'), 'action' => 'QuoteController.edit'));
        });
    });

    /**
     * Bills
     */
    App::router()->auth(App::session()->isAllowed('h-sales.see-bill'), function () {
        App::router()->get('h-sales-bills', '/bills', array('action' => 'BillController.index'));
        App::router()->get('h-sales-bills-list', '/bills-list', array('action' => 'BillController.displayList'));

        // Display bill file
        App::router()->get('h-sales-bill-file', '/bills/{id}', array('where' => array('id' => '\d+'), 'action' => 'BillController.edit'));

        App::router()->auth(App::session()->isAllowed('h-sales.edit-bill'), function () {
            // Insert / Modify bill file
            App::router()->any('h-sales-bill-edit', '/bills/{id}', array('where' => array('id' => '\d+'), 'action' => 'BillController.edit'));
        });
    });

    /**
     * Templates
     */
    App::router()->auth(App::session()->isAllowed('h-sales.edit-template'), function () {
        App::router()->get('h-sales-templates', '/templates', array('action' => 'TemplateController.index'));
        App::router()->get('h-sales-templates-list', '/templates-list', array('action' => 'TemplateController.displayList'));

        // Edit document template
        App::router()->any('h-sales-template-edit', '/templates/{id}', array('where' => array('id' => '\d+'), 'action' => 'TemplateController.edit'));
    });
});
