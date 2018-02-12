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

$GLOBALS['TL_DCA']['tl_content']['palettes']['team-employee'] = '{type_legend},type,headline;{team_legend},wr_team_category,orderTeam,sortTeam;{image_legend:hide},size;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['wr_team_category'] =  array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['category'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'checkbox',
    'options_callback'        => array('tl_content_wr_team_employee', 'getCategories'),
    'eval'                    => array('multiple'=>true, 'submitOnChange'=>true, 'mandatory'=>true),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sortTeam'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['orderSRC'],
    'exclude'                 => true,
    'search'                  => false,
    'inputType'               => 'select',
    'options'                 => array('custom','name_asc','name_desc','date_asc','date_desc'),
    'reference'               => array(
        'custom'=> &$GLOBALS['TL_LANG']['tl_content']['custom'],
        'name_asc'=> &$GLOBALS['TL_LANG']['tl_content']['employee_name_asc'],
        'name_desc'=> &$GLOBALS['TL_LANG']['tl_content']['employee_name_desc'],
        'date_asc'=> &$GLOBALS['TL_LANG']['tl_content']['date_asc'],
        'date_desc'=> &$GLOBALS['TL_LANG']['tl_content']['date_desc']
    ),
    'eval'                    => array('tl_class'=>'w50 clr'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['orderTeam'] =  array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['orderTeam'],
    'exclude'                 => true,
    'inputType'               => 'teamWizard',
    'eval'                    => array('mandatory'=>true),
    'sql'                     => "blob NULL"
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
     * Get all categories and return them as array
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