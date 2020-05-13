<?php

namespace SwiftOtter\OrderExport\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\Data\OrderExtensionInterfaceFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use SwiftOtter\OrderExport\Model\OrderExportDetailsRepository;
use SwiftOtter\OrderExport\Model\OrderExportDetailsFactory;

class LoadExportDetailsIntoOrder
{
    /**
     * @var OrderExtensionInterfaceFactory
     */
    private $extensionFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var OrderExportDetailsRepository
     */
    private $orderExportDetailsRepository;

    /**
     * @var OrderExportDetailsFactory
     */
    private $detailsFactory;

    public function __construct(
        OrderExtensionInterfaceFactory $extension,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        OrderExportDetailsRepository $orderExportDetailsRepository,
        OrderExportDetailsFactory $detailsFactory
    ) {
        $this->extensionFactory = $extension;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->orderExportDetailsRepository = $orderExportDetailsRepository;
        $this->detailsFactory = $detailsFactory;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {
        $this->setExtensionAttributes($order);

        return $order;
    }

    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult)
    {
        foreach ($searchResult->getItems() as $order) {
            $this->setExtensionAttributes($order);
        }

        return $searchResult;
    }

    private function setExtensionAttributes(OrderInterface $order)
    {
        $extensionAttributes = $order->getExtensionAttributes() ?? $this->extensionFactory->create();

        $details = $this->orderExportDetailsRepository->getList(
            $this->searchCriteriaBuilder
                ->addFilter('order_id', $order->getEntityId())
                ->create()
        )->getItems();

        if (count($details)) {
            $extensionAttributes->setExportDetails(reset($details));
        } else {
            $extensionAttributes->setExportDetails($this->detailsFactory->create());
        }

        $order->setExtensionAttributes($extensionAttributes);
    }
}
