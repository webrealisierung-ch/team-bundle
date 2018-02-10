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
class WrTeamEmployeeModel extends \Model
{
	protected static $strTable = 'tl_wr_team_employee';

	static function findTeamEmployeesByCategories($arrCategories=array(),$arrOptions=array("sort"=>"ASC"))
    {
        $i=0;
        $arrColumns = "";
        $arrValues = array();
        $t = static::$strTable;
        if (isset($arrCategories))
        {

            foreach ($arrCategories as $category) {

                if($i===0){
                    $arrColumns = $t . '.categories LIKE %s';
                } else {
                    $arrColumns .= " OR ".$t . '.categories LIKE %s';
                }

                $arrValues[] = '%:"' . $category . '"%';
                $i++;

            }

            unset($i);

            return static::findBy(array($arrColumns),$arrValues,$arrOptions);

        }

        return static::findAll($arrOptions);

    }

    static function findAndSortByMultipleIds($arrCategories = array(),$arrOptions = array()){
        $t = static::$strTable;
        $i = 0;
        $arrValues= array();
        $query = "";
        if($arrCategories){
            foreach ($arrCategories as $category){
                if($i === 0){
                    $query .= "?";
                } else{
                    $query .=" ,?";
                }
                $arrValues[] = $category;
                $i++;
            }
            $query = $t.".id IN(".$query.") order by FIELD(id ,".$query.")";
            $arrValues = array_merge($arrValues,$arrValues);
            return static::findBy(array($query),$arrValues,$arrOptions);
        }

        return static::findAll($arrOptions);
    }
}
