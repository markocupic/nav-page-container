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

namespace Markocupic\NavPageContainerBundle\EventListener\ContaoHook;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Template;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @Hook(ParseTemplateListener::HOOK, priority=ParseTemplateListener::PRIORITY)
 */
class ParseTemplateListener
{
    public const HOOK = 'parseTemplate';
    public const PRIORITY = 100;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var ScopeMatcher
     */
    private $scopeMatcher;

    /**
     * @var bool
     */
    private static $disableHook = false;

    public function __construct(RequestStack $requestStack, ScopeMatcher $scopeMatcher)
    {
        $this->requestStack = $requestStack;
        $this->scopeMatcher = $scopeMatcher;
    }

    /**
     * Add the "not-clickable-page-container" CSS class to all nav items class attribute.
     */
    public function __invoke(Template $objTemplate): void
    {
        if (static::$disableHook) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();

        if ($request && $this->scopeMatcher->isFrontendRequest($request)) {
            if (0 === strpos($objTemplate->getName(), 'nav_')) {
                $items = $objTemplate->items;

                if (!empty($items) && \is_array($items)) {
                    foreach (array_keys($items) as $k) {
                        if ($items[$k]['isPageContainer']) {
                            $class = '' !== $items[$k]['class'] ? $items[$k]['class'] : '';
                            $arrClass = explode(' ', $class);
                            $arrClass[] = 'page-container';
                            $arrClass = array_filter(array_unique($arrClass));
                            $items[$k]['class'] = implode(' ', $arrClass);
                        }
                    }
                    $objTemplate->items = $items;
                }
            }
        }
    }

    public static function disableHook(): void
    {
        self::$disableHook = true;
    }

    public static function enableHook(): void
    {
        self::$disableHook = false;
    }

    public static function isEnabled(): bool
    {
        return self::$disableHook;
    }
}
