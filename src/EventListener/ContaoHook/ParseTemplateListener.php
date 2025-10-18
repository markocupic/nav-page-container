<?php

declare(strict_types=1);

/*
 * This file is part of Nav Page Container.
 *
 * (c) Marko Cupic <m.cupic@gmx.ch>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/nav-page-container
 */

namespace Markocupic\NavPageContainer\EventListener\ContaoHook;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\Template;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsHook(ParseTemplateListener::HOOK)]
class ParseTemplateListener
{
    public const HOOK = 'parseTemplate';

    private const PAGE_CONTAINER_CSS_CLASS = 'page-container';

    private static bool $disableHook = false;

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly ScopeMatcher $scopeMatcher,
    ) {
    }

    /**
     * Add the "page-container" CSS class to all nav items class attributes if the
     * page acts as a page container.
     */
    public function __invoke(Template $objTemplate): void
    {
        if (static::$disableHook) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();

        if (!$this->scopeMatcher->isFrontendRequest($request)) {
            return;
        }

        if (!str_starts_with($objTemplate->getName(), 'nav_')) {
            return;
        }

        $this->processNavigationTemplate($objTemplate);
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

    private function processNavigationTemplate(Template $objTemplate): void
    {
        $items = $objTemplate->items;

        if (empty($items) || !\is_array($items)) {
            return;
        }

        foreach (array_keys($items) as $k) {
            if (!$items[$k]['isPageContainer'] ?? false) {
                continue;
            }

            $items[$k]['class'] = $this->addCssClass($items[$k]['class'] ?? '', self::PAGE_CONTAINER_CSS_CLASS);
        }

        $objTemplate->items = $items;
    }

    private function addCssClass(string $existingClassList, string $additionalClasses): string
    {
        $classes = [...explode(' ', trim($existingClassList)), ...explode(' ', trim($additionalClasses))];
        $classes = array_values(array_filter(array_unique($classes)));

        return implode(' ', $classes);
    }
}
