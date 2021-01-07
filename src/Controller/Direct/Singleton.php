<?php

/**
 * Copyright - elgentos ecommerce solutions (https://elgentos.nl)
 */

declare(strict_types=1);

namespace Elgentos\PrismicIO\Controller\Direct;

use Elgentos\PrismicIO\Renderer\Page as PageRenderer;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultInterface;

class Singleton extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    /** @var PageRenderer */
    public $page;

    /**
     * Constructor.
     *
     * @param Context      $context
     * @param PageRenderer $page
     */
    public function __construct(
        Context $context,
        PageRenderer $page
    ) {
        parent::__construct($context);
        $this->page = $page;
    }

    /**
     * View CMS page action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $contentType = $this->getRequest()
            ->getParam('type');

        return $this->page->renderPageBySingleton($contentType);
    }
}
