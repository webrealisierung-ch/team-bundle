<?php

/**
 * @copyright 2017 Webrealisierung GmbH
 *
 * @license LGPL-3.0+
 */

namespace Wr\TeamBundle\ContaoManager;

use Wr\TeamBundle\WrTeamBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
 * @author Daniel Steuri <mail@webrealisierung.ch>
 * @package Wr\TeamBundle
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(WrTeamBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}