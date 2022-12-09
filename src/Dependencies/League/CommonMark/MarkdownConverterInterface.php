<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark;

/**
 * Interface for a service which converts Markdown to HTML.
 */
interface MarkdownConverterInterface
{
    /**
     * Converts Markdown to HTML.
     *
     * @param string $markdown
     *
     * @throws \RuntimeException
     *
     * @return string HTML
     *
     * @api
     */
    public function convertToHtml(string $markdown): string;
}
