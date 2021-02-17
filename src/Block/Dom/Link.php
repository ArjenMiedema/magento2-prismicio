<?php

/**
 * Copyright - elgentos ecommerce solutions (https://elgentos.nl)
 */

declare(strict_types=1);

namespace Elgentos\PrismicIO\Block\Dom;

use Elgentos\PrismicIO\Block\AbstractBlock;
use Elgentos\PrismicIO\Exception\ContextNotFoundException;
use Elgentos\PrismicIO\Exception\DocumentNotFoundException;
use Prismic\Dom\Link as PrismicLink;

class Link extends AbstractBlock
{
    /**
     * Fetch the document view as an escaped URL and solve relative URLs.
     *
     * @return string
     */
    public function fetchDocumentView(): string
    {
        $context = $this->getContext();
        if (!isset($context->link_type)) {
            $context->link_type = 'Document';
        }

        $url = PrismicLink::asUrl($context, $this->getLinkResolver() ?? '');

        if (!$url) {
            return '';
        }

        return $this->_escaper->escapeUrl($this->replaceRelativeUrl($url));
    }
}
