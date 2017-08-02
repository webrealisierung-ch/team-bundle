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

$GLOBALS['TL_DCA']['tl_wr_team_category'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
        'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 0,
            'flag'                    => 1,
            'panelLayout'             => 'sort,search',
            'fields'                  => array('title DESC')
		),
        'label'=>array
        (
            'fields'                  => array('title','alias'),
            'showColumns'             => true,
            //'format'                  => '%s <span style="color:#b3b3b3;padding-left:3px">[%s]</span>',

        ),
		'global_operations'           => array
        (
            'back' => array
            (
                'label'=>&$GLOBALS['TL_LANG']['MSC']['backBT'],
                'href'=>'do=wr_team&table=tl_wr_team_employee',
                'class'=>'header_back',
                'attributes'=>'accesskey="b" onclick="Backend.getScrollOffset()"'
            )
        ),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wr_team_category']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wr_team_category']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},title,alias,description;',
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_wr_team_category']['title'],
			'search'                  => true,
            'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'alias' => array
		(
				'label'                   => &$GLOBALS['TL_LANG']['tl_wr_team_category']['alias'],
				'inputType'               => 'text',
				'eval'                    => array('rgxp'=>'alias', 'doNotCopy'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
				'save_callback' => array
				(
						array('tl_wr_team_category', 'generateAlias')
				),
				'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_wr_team_category']['description'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true, 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'                     => "text NULL"
		),
	)
);

class tl_wr_team_category extends Backend
{

	public function generateAlias($varValue, DataContainer $dc)
	{
			$autoAlias = false;

			if ($varValue == '')
			{
					$autoAlias = true;
					$varValue = StringUtil::generateAlias($dc->activeRecord->title);
			}

			$objAlias = $this->Database->prepare("SELECT id FROM tl_wr_team_category WHERE id=? OR alias=?")
					->execute($dc->id, $varValue);

			if ($objAlias->numRows > 1)
			{
					if (!$autoAlias)
					{
							throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
					}

					$varValue .= '-' . $dc->id;
			}

			return $varValue;
	}
}
