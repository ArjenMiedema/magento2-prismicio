<?php

/**
 * Copyright - elgentos ecommerce solutions (https://elgentos.nl)
 */

declare(strict_types=1);

namespace Elgentos\PrismicIO\Controller\Adminhtml\Route;

use Elgentos\PrismicIO\Controller\Adminhtml\Route;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;

class NewAction extends Route
{
    /** @var ForwardFactory */
    protected $resultForwardFactory;

    /**
     * @param Context        $context
     * @param Registry       $coreRegistry
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * New action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();

        return $resultForward->forward('edit');
    }
}