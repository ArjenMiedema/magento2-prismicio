<?php

/**
 * Copyright - elgentos ecommerce solutions (https://elgentos.nl)
 */

declare(strict_types=1);

namespace Elgentos\PrismicIO\Controller\Adminhtml\Route;

use Elgentos\PrismicIO\Controller\Adminhtml\Route as RouteController;
use Elgentos\PrismicIO\Model\Route;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends RouteController
{
    /** @var DataPersistorInterface */
    public $dataPersistor;

    /** @var PageFactory */
    protected $resultPageFactory;

    /**
     * @param Context                $context
     * @param Registry               $coreRegistry
     * @param PageFactory            $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor     = $dataPersistor;

        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id    = $this->getRequest()->getParam('route_id');
        $model = $this->_objectManager->create(Route::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Route no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $model->setData('store_id', implode(',', $model->getStoreIds()));
        $this->dataPersistor->set('prismicio_route', $model->getData());

        // 3. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Route') : __('New Route'),
            $id ? __('Edit Route') : __('New Route')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Routes'));
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId()
                ? __('Edit Route %1', $model->getTitle())
                : __('New Route')
        );

        return $resultPage;
    }
}
