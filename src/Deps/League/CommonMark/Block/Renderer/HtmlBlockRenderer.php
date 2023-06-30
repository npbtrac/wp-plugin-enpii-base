<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (https://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\League\CommonMark\Block\Renderer;

use Enpii_Base\Deps\League\CommonMark\Block\Element\AbstractBlock;
use Enpii_Base\Deps\League\CommonMark\Block\Element\HtmlBlock;
use Enpii_Base\Deps\League\CommonMark\ElementRendererInterface;
use Enpii_Base\Deps\League\CommonMark\EnvironmentInterface;
use Enpii_Base\Deps\League\CommonMark\Util\ConfigurationAwareInterface;
use Enpii_Base\Deps\League\CommonMark\Util\ConfigurationInterface;

final class HtmlBlockRenderer implements BlockRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected $config;

    /**
     * @param HtmlBlock                $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return string
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof HtmlBlock)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

        if ($this->config->get('html_input') === EnvironmentInterface::HTML_INPUT_STRIP) {
            return '';
        }

        if ($this->config->get('html_input') === EnvironmentInterface::HTML_INPUT_ESCAPE) {
            return \htmlspecialchars($block->getStringContent(), \ENT_NOQUOTES);
        }

        return $block->getStringContent();
    }

    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}