<?php
/**
 * Installer.class.php
 */

namespace Hawk\Plugins\HSales;

/**
 * This class describes the behavio of the installer for the plugin {$data['name']}
 */
class Installer extends PluginInstaller{

    /**
     * Install the plugin. This method is called on plugin installation, after the plugin has been inserted in the database
     */
    public function install() {
        Client::createTable();
        Quote::createTable();
        Bill::createTable();
        DocTemplate::createTable();
    }

    /**
     * Uninstall the plugin. This method is called on plugin uninstallation, after it has been removed from the database
     */
    public function uninstall() {
        Bill::dropTable();
        Quote::dropTable();
        Client::dropTable();
        DocTempalte::dropTable();
    }

    /**
     * Activate the plugin. This method is called when the plugin is activated, just after the activation in the database
     */
    public function activate() {
        // Add permissions to read and edit sales documents and clients files
        $permissions = array(
            'client' => array(
                'see' => Permission::add($this->_plugin . '.see-client-file', 0, 0),
                'edit' => Permission::add($this->_plugin . '.edit-client-file', 0, 0)
            ),
            'quote' => array(
                'see' => Permission::add($this->_plugin . '.see-quote', 0, 0),
                'edit' => Permission::add($this->_plugin . '.edit-quote', 0, 0)
            ),
            'bill' => array(
                'see' => Permission::add($this->_plugin . '.see-bill', 0, 0),
                'edit' => Permission::add($this->_plugin . '.edit-bill', 0, 0),
            ),
            'template' => array(
                'edit' => Permission::add($this->_plugin . '.edit-template', 0, 0)
            )
        );

        $menu = MenuItem::add(array(
            'plugin' => $this->_plugin,
            'name' => 'menu',
            'parentId' => 0,
            'labelKey' => $this->_plugin . '.menu-title',
            'icon' => 'money'
        ));

        $clientItem = MenuItem::add(array(
            'plugin' => $this->_plugin,
            'name' => 'clients',
            'parentId' => $menu->id,
            'labelKey' => $this->_plugin . '.menu-item-clients-title',
            'action' => 'h-sales-clients',
            'icon' => 'suitcase'
        ));

        $quoteItem = MenuItem::add(array(
            'plugin' => $this->_plugin,
            'name' => 'quotes',
            'parentId' => $menu->id,
            'labelKey' => $this->_plugin . '.menu-item-quotes-title',
            'action' => 'h-sales-quotes',
            'icon' => 'file-o'
        ));

        $billItem = MenuItem::add(array(
            'plugin' => $this->_plugin,
            'name' => 'bills',
            'parentId' => $menu->id,
            'labelKey' => $this->_plugin . '.menu-item-bills-title',
            'action' => 'h-sales-bills',
            'icon' => 'file-text-o'
        ));

        $templateItem = MenuItem::add(array(
            'plugin' => $this->_plugin,
            'name' => 'templates',
            'parentId' => $menu->id,
            'labelKey' => $this->_plugin . '.menu-item-templates-title',
            'action' => 'h-sales-templates',
            'icon' => 'picture-o'
        ));

        // Set default options
        Option::set($this->_plugin . '.quote-number-pattern', 'EST-{year4}{month}-{counter}');
        Option::set($this->_plugin . '.bill-number-pattern', 'BIL-{year4}{month}-{counter}');
    }

    /**
     * Deactivate the plugin. This method is called when the plugin is deactivated, just after the deactivation in the database
     */
    public function deactivate(){
        $items = MenuItem::getPluginMenuItems($this->_plugin);
        foreach($items as $item){
            $item->delete();
        }

        $permissions = Permission::getPluginPermissions($this->_plugin);
        foreach($permissions as $permission){
            $permission->delete();
        }
    }

    /**
     * Configure the plugin. This method contains a page that display the plugin configuration. To treat the submission of the configuration
     * you'll have to create another method, and make a route which action is this method. Uncomment the following function only if your plugin if
     * configurable.
     */
    /*
    public function settings(){

    }
    */
}