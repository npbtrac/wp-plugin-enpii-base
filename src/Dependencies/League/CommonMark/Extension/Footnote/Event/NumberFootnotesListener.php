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

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Event\DocumentParsedEvent;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Extension\Footnote\Node\FootnoteRef;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\CommonMark\Reference\Reference;

final class NumberFootnotesListener
{
    public function onDocumentParsed(DocumentParsedEvent $event): void
    {
        $document = $event->getDocument();
        $walker = $document->walker();
        $nextCounter = 1;
        $usedLabels = [];
        $usedCounters = [];

        while ($event = $walker->next()) {
            if (!$event->isEntering()) {
                continue;
            }

            $node = $event->getNode();

            if (!$node instanceof FootnoteRef) {
                continue;
            }

            $existingReference = $node->getReference();
            $label = $existingReference->getLabel();
            $counter = $nextCounter;
            $canIncrementCounter = true;

            if (\array_key_exists($label, $usedLabels)) {
                /*
                 * Reference is used again, we need to point
                 * to the same footnote. But with a different ID
                 */
                $counter = $usedCounters[$label];
                $label = $label . '__' . ++$usedLabels[$label];
                $canIncrementCounter = false;
            }

            // rewrite reference title to use a numeric link
            $newReference = new Reference(
                $label,
                $existingReference->getDestination(),
                (string) $counter
            );

            // Override reference with numeric link
            $node->setReference($newReference);
            $document->getReferenceMap()->addReference($newReference);

            /*
             * Store created references in document for
             * creating FootnoteBackrefs
             */
            if (false === $document->getData($existingReference->getDestination(), false)) {
                $document->data[$existingReference->getDestination()] = [];
            }

            $document->data[$existingReference->getDestination()][] = $newReference;

            $usedLabels[$label] = 1;
            $usedCounters[$label] = $nextCounter;

            if ($canIncrementCounter) {
                $nextCounter++;
            }
        }
    }
}