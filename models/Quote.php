<?php

/**
 * Estimate.php
 */

namespace Hawk\Plugins\HSales;

class Quote extends Model {
    /**
     * The table name containing the data in database
     *
     * @var string
     */
    protected static $tablename = 'HSalesQuote';

    /**
     * The primary column of the elements in the table (default 'id')
     *
     * @var string
     */
    protected static $primaryColumn = 'id';

    protected static $fields = array (
        'id' => array(
            'type' => 'INT(11)',
            'auto_increment' => true
        ),

        'userId' => array(
            'type' => 'INT(11)',
            'null' => false
        ),

        'code' => array(
            'type' => 'VARCHAR(64)'
        ),

        'clientId' => array(
            'type' => 'INT(11)',
            'null' => false
        ),

        'title' => array(
            'type' => 'VARCHAR(256)'
        ),

        'content' => array(
            'type' => 'MEDIUMTEXT'
        ),

        'status' => array(
            'type' => 'ENUM("edition", "sent", "accepted", "refused", "billed")'
        ),

        'dutyTotal' => array(
            'type' => 'FLOAT(15,2)'
        ),

        'taxes' => array(
            'type' => 'FLOAT(15,2)'
        ),

        'atiTotal' => array(
            'type' => 'FLOAT(15,2)',
        ),

        'ctime' => array(
            'type' => 'INT(11)'
        ),

        'mtime' => array(
            'type' => 'INT(11)'
        )
    );

    protected static $constraints = array(
        'clientId' => array(
            'type' => 'index',
            'fields' => array('clientId')
        ),

        'code' => array(
            'type' => 'index',
            'fields' => array('code')
        ),

        'estimateClientId' => array(
            'type' => 'foreign',
            'fields' => array(
                'clientId'
            ),
            'references' => array(
                'model' => 'Client',
                'fields' => array(
                    'id'
                )
            ),
            'on_update' => 'RESTRICT',
            'on_delete' => 'RESTRICT'
        )
    );

    /**
     * Get the bills that have been created from this quote
     * @return array The bills that have been created from the quote
     */
    public function getBills() {
        return Bill::getListByExample(new DBExample(array(
            'quoteId' => $this->id
        )));
    }
}
