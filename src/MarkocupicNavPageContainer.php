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

namespace Markocupic\NavPageContainerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MarkocupicNavPageContainer extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
