<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\TableOfContents;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Parser\BlockParserInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\ContextInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Cursor;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\TableOfContents\Node\TableOfContentsPlaceholder;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Util\ConfigurationAwareInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Util\ConfigurationInterface;

final class TableOfContentsPlaceholderParser implements BlockParserInterface, ConfigurationAwareInterface
{
    /** @var ConfigurationInterface */
    private $config;

    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        $placeholder = $this->config->get('table_of_contents/placeholder');
        if ($placeholder === null) {
            return false;
        }

        // The placeholder must be the only thing on the line
        if ($cursor->match('/^' . \preg_quote($placeholder, '/') . '$/') === null) {
            return false;
        }

        $context->addBlock(new TableOfContentsPlaceholder());

        return true;
    }

    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}
