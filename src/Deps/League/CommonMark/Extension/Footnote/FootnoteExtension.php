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

namespace Enpii_Base\Deps\League\CommonMark\Extension\Footnote;

use Enpii_Base\Deps\League\CommonMark\ConfigurableEnvironmentInterface;
use Enpii_Base\Deps\League\CommonMark\Event\DocumentParsedEvent;
use Enpii_Base\Deps\League\CommonMark\Extension\ExtensionInterface;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Event\AnonymousFootnotesListener;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Event\GatherFootnotesListener;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Event\NumberFootnotesListener;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Node\Footnote;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Node\FootnoteBackref;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Node\FootnoteContainer;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Node\FootnoteRef;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Parser\AnonymousFootnoteRefParser;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Parser\FootnoteParser;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Parser\FootnoteRefParser;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Renderer\FootnoteBackrefRenderer;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Renderer\FootnoteContainerRenderer;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Renderer\FootnoteRefRenderer;
use Enpii_Base\Deps\League\CommonMark\Extension\Footnote\Renderer\FootnoteRenderer;

final class FootnoteExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addBlockParser(new FootnoteParser(), 51);
        $environment->addInlineParser(new AnonymousFootnoteRefParser(), 35);
        $environment->addInlineParser(new FootnoteRefParser(), 51);

        $environment->addBlockRenderer(FootnoteContainer::class, new FootnoteContainerRenderer());
        $environment->addBlockRenderer(Footnote::class, new FootnoteRenderer());

        $environment->addInlineRenderer(FootnoteRef::class, new FootnoteRefRenderer());
        $environment->addInlineRenderer(FootnoteBackref::class, new FootnoteBackrefRenderer());

        $environment->addEventListener(DocumentParsedEvent::class, [new AnonymousFootnotesListener(), 'onDocumentParsed']);
        $environment->addEventListener(DocumentParsedEvent::class, [new NumberFootnotesListener(), 'onDocumentParsed']);
        $environment->addEventListener(DocumentParsedEvent::class, [new GatherFootnotesListener(), 'onDocumentParsed']);
    }
}
