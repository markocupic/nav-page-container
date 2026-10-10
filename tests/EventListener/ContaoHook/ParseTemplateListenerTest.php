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

namespace Markocupic\NavPageContainer\Tests\EventListener\ContaoHook;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\FrontendTemplate;
use Markocupic\NavPageContainer\EventListener\ContaoHook\ParseTemplateListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ParseTemplateListenerTest extends TestCase
{
    public function testAddsTheCssClassToPageContainers(): void
    {
        $template = $this->createTemplate('nav_pagecontainer', [
            ['class' => 'first', 'isPageContainer' => true],
            ['class' => 'last', 'isPageContainer' => false],
            ['class' => 'page-container'],
            ['isPageContainer' => '1'],
        ]);

        $this->createListener(true)($template);

        $this->assertSame('first page-container', $template->items[0]['class']);
        $this->assertSame('last', $template->items[1]['class']);
        $this->assertSame('page-container', $template->items[2]['class']);
        $this->assertSame('page-container', $template->items[3]['class']);
    }

    public function testIgnoresOtherTemplatesAndTheBackend(): void
    {
        $template = $this->createTemplate('mod_navigation', [['class' => 'first', 'isPageContainer' => true]]);
        $this->createListener(true)($template);
        $this->assertSame('first', $template->items[0]['class']);

        $template = $this->createTemplate('nav_default', [['class' => 'first', 'isPageContainer' => true]]);
        $this->createListener(false)($template);
        $this->assertSame('first', $template->items[0]['class']);
    }

    private function createListener(bool $isFrontend): ParseTemplateListener
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request());

        $scopeMatcher = $this->createStub(ScopeMatcher::class);
        $scopeMatcher
            ->method('isFrontendRequest')
            ->willReturn($isFrontend)
        ;

        return new ParseTemplateListener($requestStack, $scopeMatcher);
    }

    private function createTemplate(string $name, array $items): FrontendTemplate
    {
        $template = (new \ReflectionClass(FrontendTemplate::class))->newInstanceWithoutConstructor();
        $template->setName($name);
        $template->items = $items;

        return $template;
    }
}
