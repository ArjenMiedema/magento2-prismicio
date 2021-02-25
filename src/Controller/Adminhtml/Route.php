<?php

/**
 * Copyright - elgentos ecommerce solutions (https://elgentos.nl)
 */

declare(strict_types=1);

namespace Elgentos\PrismicIO\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Registry;

abstract class Route extends Action
{
    public const ADMIN_RESOURCE = 'Elgentos_PrismicIO::routes';

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @param Context  $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry
    ) {
        $this->registry = $registry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     *
     * @return Page
     */
    public function initPage($resultPage): Page
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Elgentos'), __('Elgentos'))
            ->addBreadcrumb(__('Route'), __('Route'));

        return $resultPage;
    }
}
