<?php

declare(strict_types=1);

/*
 * This file is part of Nav Page Container.
 *
 * (c) Marko Cupic 2021 <m.cupic@gmx.ch>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/nav-page-container
 */

namespace Markocupic\NavPageContainer\EventListener\ContaoHook;

use Contao\Template;

/**
 * @Hook(ParseTemplateListener::HOOK, priority=100)
 */
class ParseTemplateListener
{
    public const HOOK = 'parseTemplateHook';

    /**
     * Add the "not-clickable-page-container" CSS class to all nav items.
     */
    public function __invoke(Template $objTemplate): void
    {
        // Check if login is allowed, if not replace the default error message
        if (TL_MODE === 'FE') {
            if (0 === strpos($objTemplate->getName(), 'nav_')) {
                $items = $objTemplate->items;

                if (!empty($items) && \is_array($items)) {
                    foreach (array_keys($items) as $k) {
                        if ($items[$k]['isPageContainer']) {
                            $items[$k]['class'] .= ' not-clickable-page-container';
                        }
                    }
                    $objTemplate->items = $items;
                }
            }
        }
    }
}
