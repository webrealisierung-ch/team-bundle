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
class ContentTeamEmployee extends \ContentElement
{
    protected $strTemplate = 'ce_wr_teamemployee';

    protected function compile()
    {

        $categories=deserialize($this->objModel->wr_team_category);

        $order = unserialize($this->objModel->orderTeam);

        $sort =  $this->objModel->sortTeam;

        switch ($sort){
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
            case "custom":
                $employees = \WrTeamEmployeeModel::findAndSortByMultipleIds($order);
                break;
            default:
                $employees = \WrTeamEmployeeModel::findTeamEmployeesByCategories($categories,array('order' => 'tl_wr_team_employee.tstamp ASC'));
                break;
        }

        $this->Template->Team = $employees;
    }
}