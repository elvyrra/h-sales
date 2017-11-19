<?php

/**
 * BIll.php
 */

namespace Hawk\Plugins\HSales;

class Bill extends Model
{
    /**
     * The table name containing the data in database
     *
     * @var string
     */
    protected static $tablename = 'HSalesBill';

    /**
     * The primary column of the elements in the table (default 'id')
     *
     * @var string
     */
    protected static $primaryColumn = 'id';

    protected static $fields = array(
        'id' => array(
            'type' => 'int(11)',
            'auto_increment' => true
        ),

        'userId' => array(
            'type' => 'int(11)'
        ),

        'code' => array(
            'type' => 'varchar(64)'
        ),

        'quoteId' => array(
            'type' => 'int(11)',
            'null' => true
        ),

        'clientId' => array(
            'type' => 'int(11)',
        ),

        'title' => array(
            'type' => 'varchar(256)'
        ),

        'content' => array(
            'type' => 'MEDIUMTEXT'
        ),

        'status' => array(
            'type' => 'ENUM("edition", "sent", "paid", "conflict")'
        ),

        'dutyTotal' => array(
            'type' => 'float(15,2)'
        ),

        'taxes' => array(
            'type' => 'float(15, 2)'
        ),

        'atiTotal' => array(
            'type' => 'float(15,2)'
        ),

        'ctime' => array(
            'type' => 'int(11)'
        ),

        'mtime' => array(
            'type' => 'int(11)'
        )
    );

    protected static $constraints = array(
        'code' => array(
            'type' => 'index',
            'fields' => array(
                'code'
            )
        ),

        'clientId' => array(
            'type' => 'index',
            'fields' => array(
                'clientId'
            )
        ),

        'quoteId' => array(
            'type' => 'index',
            'fields' => array(
                'quoteId'
            )
        ),

        'billClientId' => array(
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
}
