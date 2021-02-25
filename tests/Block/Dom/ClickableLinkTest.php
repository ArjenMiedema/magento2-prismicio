<?php

/**
 * Copyright - elgentos ecommerce solutions (https://elgentos.nl)
 */

declare(strict_types=1);

namespace Elgentos\PrismicIO\Tests\Block\Dom;

use Elgentos\PrismicIO\Block\Dom\ClickableLink;
use Elgentos\PrismicIO\ViewModel\DocumentResolver;
use Elgentos\PrismicIO\ViewModel\LinkResolver;
use Magento\Framework\View\Element\Template\Context;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @coversDefaultClass \Elgentos\PrismicIO\BLock\Dom\ClickableLink
 */
class ClickableLinkTest extends TestCase
{
    /**
     * @covers ::fetchDocumentView
     *
     * @return void
     */
    public function testFetchDocumentView(): void
    {
        $documentResolver = $this->createMock(DocumentResolver::class);
        $subject          = new ClickableLink(
            $this->createMock(Context::class),
            $documentResolver,
            $this->createMock(LinkResolver::class)
        );

        $documentResolver->expects(self::once())
            ->method('getContext')
            ->willReturn(new stdClass());

        $subject->setData('link_title', 'Test Link');
        $expected = '<a href="">Test Link</a>';

        $this->assertEquals($expected, $subject->fetchDocumentView());
    }
}
