<?php

/**
 * Copyright - elgentos ecommerce solutions (https://elgentos.nl)
 */

declare(strict_types=1);

namespace Elgentos\PrismicIO\Controller\Adminhtml\Route;

use Elgentos\PrismicIO\Model\ResourceModel\Route\Store\Collection as RouteStoreCollection;
use Elgentos\PrismicIO\Model\Route;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Elgentos\PrismicIO\Model\Route\StoreFactory as RouteStoreFactory;

class Save extends Action
{
    /** @var RouteStoreFactory */
    public $routeStoryFactory;

    /** @var RouteStoreCollection */
    public $routeStoreCollection;

    /** @var DataPersistorInterface */
    protected $dataPersistor;

    /**
     * @param Context                $context
     * @param DataPersistorInterface $dataPersistor
     * @param RouteStoreCollection   $routeStoreCollection
     * @param RouteStoreFactory      $routeStoreFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        RouteStoreCollection $routeStoreCollection,
        RouteStoreFactory $routeStoreFactory
    ) {
        $this->dataPersistor        = $dataPersistor;
        $this->routeStoryFactory    = $routeStoreFactory;
        $this->routeStoreCollection = $routeStoreCollection;

        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data           = $this->getRequest()->getPostValue();

        if ($data) {
            $id    = $this->getRequest()->getParam('route_id');
            $model = $this->_objectManager->create(Route::class)->load($id);

            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Route no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();

                $this->routeStoreCollection
                    ->addFieldToFilter('route_id', $model->getId())
                    ->each(
                        function ($routeStore) {
                            $routeStore->delete();
                        }
                    );

                foreach ($model->getData('store_id') as $storeId) {
                    $this->routeStoryFactory->create()
                        ->setData(
                            [
                                'route_id' => $model->getId(),
                                'store_id' => $storeId
                            ]
                        )
                        ->save();
                }

                $this->messageManager->addSuccessMessage(__('You saved the Route.'));
                $this->dataPersistor->clear('prismicio_route');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['route_id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the Route.')
                );
            }

            $this->dataPersistor->set('prismicio_route', $data);

            return $resultRedirect->setPath(
                '*/*/edit',
                ['route_id' => $this->getRequest()->getParam('route_id')]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }
}
