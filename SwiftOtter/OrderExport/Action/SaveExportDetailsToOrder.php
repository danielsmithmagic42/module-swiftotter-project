<?php

namespace SwiftOtter\OrderExport\Action;

use Magento\Sales\Api\OrderRepositoryInterface;
use SwiftOtter\OrderExport\Model\HeaderData;
use SwiftOtter\OrderExport\Model\OrderExportDetailsRepository;

/**
 * Class SaveExportDetailsToOrder
 * - Saves the export details into the order extension attributes
 *
 * @package SwiftOtter\OrderExport\Action
 */
class SaveExportDetailsToOrder
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var OrderExportDetailsRepository */
    private $orderExportDetailsRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderExportDetailsRepository $orderExportDetailsRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderExportDetailsRepository = $orderExportDetailsRepository;
    }

    /**
     * @param $orderId
     * @param HeaderData $headerData
     * @param array $results
     * @throws \Exception
     */
    public function execute(
        $orderId,
        HeaderData $headerData,
        $results
    ) {
        $order = $this->orderRepository->get($orderId);
        $details = $order->getExtensionAttributes()->getExportDetails();

        if (isset($results['success']) && $results['success'] === true) {
            $details->setExportedAt((new \DateTime())->setTimezone(new \DateTimeZone('UTC')));
        }

        $details->setOrderId($orderId);
        $details->setMerchantNotes($headerData->getMerchantNotes());
        $details->setShipOn($headerData->getShipDate());

        $this->orderExportDetailsRepository->save($details);
    }
}
