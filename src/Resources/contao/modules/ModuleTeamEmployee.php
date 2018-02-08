<?php

/**
 * @copyright 2017 Webrealisierung GmbH
 *
 * @license LGPL-3.0+
 */

namespace Wr;

/**
 * @author Daniel Steuri <mail@webrealisierung.ch>
 * @package Wr\TeamBundle
 */
class ModuleTeamEmployee extends \Module
{
    protected $strTemplate = 'mod_wr_teamemployee';

    protected function compile()
    {

        $categories=deserialize($this->objModel->wr_team_category);

        $order = $this->objModel->sortTeam;

        switch ($order){
            case "name_asc":
                $employees = \WrTeamEmployeeModel::findTeamEmployeesByCategories($categories,array('order' => 'tl_wr_team_employee.title ASC'));
                break;
            case "name_desc":
                $employees = \WrTeamEmployeeModel::findTeamEmployeesByCategories($categories,array('order' => 'tl_wr_team_employee.title DESC'));
                break;
            case "date_asc":
                $employees = \WrTeamEmployeeModel::findTeamEmployeesByCategories($categories,array('order' => 'tl_wr_team_employee.tstamp ASC'));
                break;
            case "date_desc":
                $employees = \WrTeamEmployeeModel::findTeamEmployeesByCategories($categories,array('order' => 'tl_wr_team_employee.tstamp DESC'));
                break;
            default:
                $employees = \WrTeamEmployeeModel::findTeamEmployeesByCategories($categories,array('order' => 'tl_wr_team_employee.tstamp ASC'));
                break;
        }

        $this->Template->Team = $employees;
    }
}
