<?php

/**
 * @copyright 2017 Webrealisierung GmbH
 *
 * @license LGPL-3.0+
 */

/**
 * @author Daniel Steuri <mail@webrealisierung.ch>
 * @package Wr\TeamBundle
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['team-employee'] = '\'{type_legend},type,headline;{team_legend},wr_team_category,orderTeam;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['fields']['wr_team_category'] =  array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['category'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'checkbox',
    'options_callback'        => array('tl_content_wr_team_employee', 'getCategories'),
    'eval'                    => array('multiple'=>true, 'mandatory'=>true),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['orderTeam'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['orderSRC'],
    'exclude'                 => true,
    'search'                  => false,
    'inputType'               => 'select',
    'options'                 => array('name_asc','name_desc','date_asc','date_desc'),
    'reference'               => array(
        'name_asc'=> &$GLOBALS['TL_LANG']['tl_content']['employee_name_asc'],
        'name_desc'=> &$GLOBALS['TL_LANG']['tl_content']['employee_name_desc'],
        'date_asc'=> &$GLOBALS['TL_LANG']['tl_content']['date_asc'],
        'date_desc'=> &$GLOBALS['TL_LANG']['tl_content']['date_desc']
    ),
    'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50 clr'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

class tl_content_wr_team_employee extends Backend
{
    /**
     * Import the back end user object
     */

    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }


    /**
     * Get all calendars and return them as array
     *
     * @return array
     */
    public function getCategories()
    {
        if (!$this->User->isAdmin)
        {
            return array();
        }

        $arrCategories = array();
        $objCategories = $this->Database->execute("SELECT id, title FROM tl_wr_team_category ORDER BY title");

        while ($objCategories->next()) {
            {
                $arrCategories[$objCategories->id] = $objCategories->title;
            }
        }
        return $arrCategories;
    }
}