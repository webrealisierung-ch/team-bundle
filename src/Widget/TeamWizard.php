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
namespace Wr\TeamBundle\Widget;

use Contao\Image;
use Contao\Model\Collection;

class TeamWizard extends \Widget
{

    /**
     * Submit user input
     * @var boolean
     */
    protected $blnSubmitInput = true;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_widget';

    /**
     * Order ID
     * @var string
     */
    protected $strOrderId;

    /**
     * Order name
     * @var string
     */
    protected $strOrderName;


    /**
     * Load the database object
     *
     * @param array $arrAttributes
     */
    public function __construct($arrAttributes=null)
    {
        $this->import('Database');
        parent::__construct($arrAttributes);

    }

    protected function validator($varInput)
    {

        if(!$this->isValidValue($varInput)) {
            return '';
        }

        if($this->hasErrors()) {
            return '';
        }

        if (strpos($varInput, ',') === false) {
            $arrIds = array($varInput);
        } else {
            $arrIds = array_filter(explode(',', $varInput));
        }
        $return = serialize($arrIds);
        return $return;

    }


    public function generate()
    {
        $employees = array();
        $newArrSort = array();

        $categories = deserialize($this->activeRecord->wr_team_category);

        $teamEmployees = $this->loadEmployees();

        if($teamEmployees){
            foreach ($teamEmployees as $employee){
                $givenName = $employee->givenName;
                $familyName = $employee->familyName;

                if($employee->singleSRC){
                    $image = \FilesModel::findByUuid($employee->singleSRC);
                    $imageAsset = \System::getContainer()->get('contao.image.image_factory')->create(TL_ROOT . '/' . $image->path, array(75, 50, 'center_center'))->getUrl(TL_ROOT);

                    unset($image);
                } else{
                    $imageAsset = \Image::getPath('placeholder.svg');
                }

                $imageHtml = Image::getHtml($imageAsset,"","");
                unset($imageAsset);

                array_push($employees,"<li data-id='". $employee->id ."'>".$imageHtml."<p>" . $givenName ." ". $familyName ."</p></li>");

                array_push($newArrSort, $employee->id);

                unset($imageHtml);
                unset($employee);
            }

            $input2 = implode(',',deserialize($newArrSort));
            if($this->activeRecord->orderTeam){
                $input1 = $this->activeRecord->orderTeam;
            } else{
                $input1 = $input2;
            }

            $input1 = "<input type='hidden' id='ctlr_orderTeam' name='orderTeam' value='".$input1."'>";
            $hint = '<p class="sort_hint">' . $GLOBALS['TL_LANG']['MSC']['dragItemsHint'] . '</p>';
            $return = '<div class="selector_container">'.$hint."<ul id = 'sort_".$this->strId."' class='sortable sgallery'>".implode($employees)."</ul>"."</div>";
            $script = '<script>Backend.makeMultiSrcSortable("sort_orderTeam","ctlr_orderTeam", "ctlr_orderTeam")</script>';
            unset($employees);
        }
        return "<div>".$input1.$return."</div>".$script;
    }

    private function loadEmployees(){

        $categories = deserialize($this->activeRecord->wr_team_category);

        $activeRecordOrderTeam = $this->activeRecord->orderTeam;

        $arrCheck1 = array();

        $employeesByCategories = \WrTeamEmployeeModel::findTeamEmployeesByCategories($categories);
        $arrCheck1 = $this->generateCategoryArray($employeesByCategories);

        if($activeRecordOrderTeam){

            if(is_array($activeRecordOrderTeam)){
                $employeesBySort = \WrTeamEmployeeModel::findMultipleByIds($activeRecordOrderTeam);
            } else {
                $employeesBySort = \WrTeamEmployeeModel::findMultipleByIds(unserialize($activeRecordOrderTeam));
            }

            $arrCheck2 = $this->generateCategoryArray($employeesBySort);

            if(sort($arrCheck1) === sort($arrCheck2)){
                return $employeesBySort;
            }

        }

        return $employeesByCategories;

    }

    private function generateCategoryArray(Collection $Employees){

        $arrCheckValue = array();

        foreach($Employees as $employee){

            if(!in_array($employee->id,$arrCheckValue)){
                array_push($arrCheckValue,$employee->id);
            };

        }

        return $arrCheckValue;
    }

    public static function isValidValue($varValue)
    {
        return preg_match('/^-?\d+(\,\d+)?$/', $varValue);
    }
}