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

$GLOBALS['TL_DCA']['tl_wr_team_employee'] = array
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
            'fields'                  => array('title ASC'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;search,limit'
        ),
        'label'=>array
        (
            'fields'                  => array('title','categories'),
            'format'                  => '%s <span style="color:#b3b3b3;padding-left:3px">[%s]</span>',
        ),
        'global_operations' => array
        (
            'categories' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['categories'],
                'href'                => 'table=tl_wr_team_category',
                'class'               => 'header_categories',
                'attributes'          => 'onclick="Backend.getScrollOffset()"',
            ),
        ),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
            'toggle' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['toggle'],
                'icon'                => 'visible.gif',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback'     => array('tl_wr_team_employee', 'toggleIcon')
            ),
		)
	),

	// Palettes
	'palettes' => array
	(
		"__selector__" => array("published"),
	    'default'                     => '{title_legend},title,alias,description;{image_legend},singleSRC;{category_legend},categories;{publish_legend},published',
	),
    // Subpalettes
    'subpalettes' => array
    (
        'published'                   => 'start,stop'
    ),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'sorting' => array
		(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'alias' => array
		(
				'label'                   => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['alias'],
				'exclude'                 => true,
				'inputType'               => 'text',
				'search'                  => true,
				'eval'                    => array('rgxp'=>'alias', 'doNotCopy'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
				'save_callback' => array
				(
						array('tl_wr_team_employee', 'generateAlias')
				),
				'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['description'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true, 'tl_class'=>'clr'),
			'explanation'             => 'insertTags',
			'sql'                     => "text NULL"
		),

        'singleSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['employeeSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>'gif,jpg,jpeg,png', 'mandatory'=>false, 'tl_class'=>'clr'),
            'sql'                     => "binary(16) NULL"
        ),
        'categories' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['categories'],
            'exclude'                 => true,
            'search'                  => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'options_callback'        => array('tl_wr_team_employee', 'getCategories'),
            'eval'                    => array('multiple'=>true, 'mandatory'=>true),
            'sql'                     => "blob NULL"
        ),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['published'],
			'exclude'                 => true,
			'filter'                  => true,
            'default'                 => false,
            'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true),
            'inputType'               => 'checkbox',
            'sql'                     => "char(1) NOT NULL default ''"
		),
        'start' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['start'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
            'sql'                     => "varchar(10) NOT NULL default ''"
        ),
        'stop' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_wr_team_employee']['stop'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
            'sql'                     => "varchar(10) NOT NULL default ''"
        )

	)
);


class tl_wr_team_employee extends Backend
{

    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

	public function generateAlias($varValue, DataContainer $dc)
	{
			$autoAlias = false;

			if ($varValue == '')
			{
					$autoAlias = true;
					$varValue = StringUtil::generateAlias($dc->activeRecord->title);
			}

			$objAlias = $this->Database->prepare("SELECT id FROM tl_wr_team_employee WHERE id=? OR alias=?")
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



    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        if (!$this->User->hasAccess('tl_wr_team_employee::published', 'alexf'))
        {
            return '';
        }

        $href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.gif';
        }

        $objPage = $this->Database->prepare("SELECT * FROM tl_wr_team_employee WHERE id=?")
            ->limit(1)
            ->execute($row['id']);

        if (!$this->User->isAllowed(BackendUser::CAN_EDIT_ARTICLES, $objPage->row()))
        {
            return Image::getHtml($icon) . ' ';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').'</a> ';
    }

    public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
    {

        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');

        if ($dc)
        {
            $dc->id = $intId; // see #8043
        }

        if (!$this->User->hasAccess('tl_wr_team_employee::published', 'alexf'))
        {
            $this->log('Not enough permissions to publish/unpublish article ID "'.$intId.'"', __METHOD__, TL_ERROR);
            $this->redirect('contao/main.php?act=error');
        }

        $objVersions = new Versions('tl_wr_team_employee', $intId);
        $objVersions->initialize();

        if (is_array($GLOBALS['TL_DCA']['tl_wr_team_employee']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_wr_team_employee']['fields']['published']['save_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, ($dc ?: $this));
                }
                elseif (is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, ($dc ?: $this));
                }
            }
        }

        $this->Database->prepare("UPDATE tl_wr_team_employee SET tstamp=". time() .", published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
            ->execute($intId);

        $objVersions->create();
    }

    public function getCategories()
    {
			
        $arrCategories = array();
        $objCategories = $this->Database->execute("SELECT id, title FROM tl_wr_team_category ORDER BY title");

        while ($objCategories->next()) {
            {
                $arrCategories[$objCategories->id] = $objCategories->title;
            }
        }
        return $arrCategories;
    }
    public function pasteElement(DataContainer $dc, $row, $table)
    {

        $imagePasteAfter = Image::getHtml('pasteafter.gif', sprintf($GLOBALS['TL_LANG'][$table]['pasteafter'][1], $row['id']));
        return '<a href="'.$this->addToUrl('act=cut&mode=1&pid='.$row['id']).'" title="'.specialchars(sprintf($GLOBALS['TL_LANG'][$table]['pasteafter'][1], $row['id'])).'" onclick="Backend.getScrollOffset()">'.$imagePasteAfter.'</a> ';

    }
}
