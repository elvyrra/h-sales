<?php

/**
 * Client.php
 */

namespace Hawk\Plugins\HSales;

class Client extends Model
{
    /**
     * The table name containing the data in database
     *
     * @var string
     */
    protected static $tablename = 'HSalesClient';

    /**
     * The primary column of the elements in the table (default 'id')
     *
     * @var string
     */
    protected static $primaryColumn = 'id';

    protected static $fields = array(
        'id' => array(
            'type' => 'INT(11)',
            'auto_increment' => true
        ),

        'pro' => array(
            'type' => 'TINYINT(1)',
            'default' => '0'
        ),

        'firstname' => array(
            'type' => 'VARCHAR(128)'
        ),

        'lastname' => array(
            'type' => 'VARCHAR(128)'
        ),

        'companyName' => array(
            'type' => 'VARCHAR(128)'
        ),

        'addressLine1' => array(
            'type' => 'VARCHAR(128)'
        ),

        'addressLine2' => array(
            'type' => 'VARCHAR(128)'
        ),

        'zipCode' => array(
            'type' => 'VARCHAR(128)'
        ),

        'city' => array(
            'type' => 'VARCHAR(128)'
        ),

        'country' => array(
            'type' => 'VARCHAR(128)'
        ),

        'phoneNumber' => array(
            'type' => 'VARCHAR(20)'
        ),

        'cellularNumber' => array(
            'type' => 'VARCHAR(20)'
        ),

        'email' => array(
            'type' => 'VARCHAR(256)'
        ),

        'fax' => array(
            'type' => 'VARCHAR(20)'
        ),

        'website' => array(
            'type' => 'VARCHAR(256)'
        ),

        'ctime' => array(
            'type' => 'INT(11)'
        ),

        'mtime' => array(
            'type' => 'INT(11)'
        ),
    );

    protected static $constraints = array(
        'fullname' => array(
            'fields' => array(
                'firstname',
                'lastname'
            ),
            'type' => 'index'
        )
    );


    public function getDisplayedName() {
        return ($this->companyName ? $this->companyName.' - ' : '').$this->firstname.' '.strtoupper($this->lastname);
    }
}
