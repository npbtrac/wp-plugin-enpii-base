<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\ConfigurableEnvironmentInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Autolink\AutolinkExtension;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Table\TableExtension;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\TaskList\TaskListExtension;

final class GithubFlavoredMarkdownExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addExtension(new AutolinkExtension());
        $environment->addExtension(new DisallowedRawHtmlExtension());
        $environment->addExtension(new StrikethroughExtension());
        $environment->addExtension(new TableExtension());
        $environment->addExtension(new TaskListExtension());
    }
}
