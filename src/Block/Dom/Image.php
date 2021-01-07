<?php

/**
 * Copyright - elgentos ecommerce solutions (https://elgentos.nl)
 */

declare(strict_types=1);

namespace Elgentos\PrismicIO\Block\Dom;

use Elgentos\PrismicIO\Exception\ContextNotFoundException;
use Elgentos\PrismicIO\Exception\DocumentNotFoundException;

class Image extends Raw
{
    /**
     * Get the document view as an image tag.
     *
     * @return string
     * @throws ContextNotFoundException
     * @throws DocumentNotFoundException
     */
    public function fetchDocumentView(): string
    {
        return '<img src="' . $this->_escaper->escapeHtml(parent::fetchDocumentView()) . '"
            alt="' . $this->getData('alt_text') . '" />';
    }
}
