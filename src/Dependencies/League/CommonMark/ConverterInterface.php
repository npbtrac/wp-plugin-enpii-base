<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark;

/**
 * Interface for a service which converts CommonMark to HTML.
 *
 * @deprecated ConverterInterface is deprecated since league/commonmark 1.4, use MarkdownConverterInterface instead
 */
interface ConverterInterface extends MarkdownConverterInterface
{
}