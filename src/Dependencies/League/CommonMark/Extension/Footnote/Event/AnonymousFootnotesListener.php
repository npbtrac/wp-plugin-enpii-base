<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 * (c) Rezo Zero / Ambroise Maupate
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Footnote\Event;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Block\Element\Paragraph;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Event\DocumentParsedEvent;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Footnote\Node\Footnote;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Footnote\Node\FootnoteBackref;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Footnote\Node\FootnoteRef;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Inline\Element\Text;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Reference\Reference;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Util\ConfigurationAwareInterface;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Util\ConfigurationInterface;

final class AnonymousFootnotesListener implements ConfigurationAwareInterface
{
    /** @var ConfigurationInterface */
    private $config;

    public function onDocumentParsed(DocumentParsedEvent $event): void
    {
        $document = $event->getDocument();
        $walker = $document->walker();

        while ($event = $walker->next()) {
            $node = $event->getNode();
            if ($node instanceof FootnoteRef && $event->isEntering() && null !== $text = $node->getContent()) {
                // Anonymous footnote needs to create a footnote from its content
                $existingReference = $node->getReference();
                $reference = new Reference(
                    $existingReference->getLabel(),
                    '#' . $this->config->get('footnote/ref_id_prefix', 'fnref:') . $existingReference->getLabel(),
                    $existingReference->getTitle()
                );
                $footnote = new Footnote($reference);
                $footnote->addBackref(new FootnoteBackref($reference));
                $paragraph = new Paragraph();
                $paragraph->appendChild(new Text($text));
                $footnote->appendChild($paragraph);
                $document->appendChild($footnote);
            }
        }
    }

    public function setConfiguration(ConfigurationInterface $config): void
    {
        $this->config = $config;
    }
}
