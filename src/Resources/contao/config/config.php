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

if(TL_MODE=="BE"){
    $GLOBALS['TL_CSS'][]="bundles/wrteam/team.css";
}

/**
 * BACK END MODULES
 */
array_insert($GLOBALS['BE_MOD']['wr'],1,array(
        'wr_team' => array
        (
            'tables' => array('tl_wr_team_employee', 'tl_wr_team_category'),
            'icon' => 'system/modules/wr_tools/assets/icon/team.png',
        )
    )
);
/**
 * FRONT END MODULES
 */
$GLOBALS['FE_MOD']['wr']['team-employee'] = 'Wr\ModuleTeamEmployee';

/**
 * FRONT END CONTENT ELEMENTS
 */
$GLOBALS['TL_CTE']['wr']['team-employee'] = 'Wr\ContentTeamEmployee';

$GLOBALS['BE_FFL']['teamWizard'] = 'Wr\TeamBundle\Widget\TeamWizard';