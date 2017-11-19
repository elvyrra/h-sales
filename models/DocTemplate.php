<?php

/**
 * DocTemplate.php
 */

namespace Hawk\Plugins\HSales;

class DocTemplate extends Model
{
    /**
     * The table name containing the data in database
     *
     * @var string
     */
    protected static $tablename = 'HSalesTemplate';

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

        'title' => array(
            'type' => 'varchar(128)'
        ),

        'template' => array(
            'type' => 'MEDIUMTEXT'
        )
    );


    /**
     * Get the directory contaning the article logo
     */
    public function getLogoDir(){
        return $this->getStaticFilesRootDir() . 'logo/';
    }

    /**
     * Get the article logo filename
     */
    public function getLogoFilename($logo){
        return $this->getLogoDir() . $logo;
    }

    /**
     * Get the article logo URL
     */
    public function getLogoUrl($logo){
        return $this->getStaticFilesRootUrl() . 'logo/' . $logo;
    }
}
