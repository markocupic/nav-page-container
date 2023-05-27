<?php

declare(strict_types=1);

/*
 * This file is part of Nav Page Container.
 *
 * (c) Marko Cupic 2023 <m.cupic@gmx.ch>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/nav-page-container
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;

PaletteManipulator::create()
    ->addField(['isPageContainer'], 'expert_legend', PaletteManipulator::POSITION_PREPEND)
    ->applyToPalette('default', 'tl_page')
    ->applyToPalette('regular', 'tl_page')
    ->applyToPalette('forward', 'tl_page')
    ->applyToPalette('redirect', 'tl_page');

// Fields
$GLOBALS['TL_DCA']['tl_page']['fields']['isPageContainer'] = [
    'exclude'   => true,
    'search'    => true,
    'sorting'   => true,
    'filter'    => true,
    'inputType' => 'checkbox',
    'eval'      => ['mandatory' => false, 'tl_class' => 'clr'],
    'sql'       => "varchar(1) NOT NULL default ''",
];
