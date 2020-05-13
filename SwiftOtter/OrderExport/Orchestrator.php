<?php

namespace SwiftOtter\OrderExport;

use SwiftOtter\OrderExport\Action\PushDetailsToWebService;
use SwiftOtter\OrderExport\Action\SaveExportDetailsToOrder;
use SwiftOtter\OrderExport\Action\TransformOrderToArray;
use SwiftOtter\OrderExport\Model\HeaderData;

/**
 * Class Orchestrator
 * - Orchestrates the collection of order information for an order export
 *
 * @package SwiftOtter\OrderExport
 */
class Orchestrator
{
    /** @var TransformOrderToArray $transformOrderToArray */
    private $transformOrderToArray;

    /** @var PushDetailsToWebService $pushDetailsToWebService */
    private $pushDetailsToWebService;

    /** @var SaveExportDetailsToOrder $saveExportDetailsToOrder */
    private $saveExportDetailsToOrder;

    public function __construct(
        TransformOrderToArray $transformOrderToArray,
        PushDetailsToWebService $pushDetailsToWebService,
        SaveExportDetailsToOrder $saveExportDetailsToOrder
    ) {
        $this->transformOrderToArray = $transformOrderToArray;
        $this->pushDetailsToWebService = $pushDetailsToWebService;
        $this->saveExportDetailsToOrder = $saveExportDetailsToOrder;
    }

    /**
     * - Generate order details as array
     * - Push to external web service
     * - Update applicable entries in the database
     * - Return some type of result
     *
     * @param $orderId
     * @param HeaderData $headerData
     * @return array
     */
    public function run($orderId, HeaderData $headerData)
    {
        $results = ['success' => false, 'error' => null];

        $orderDetails = $this->transformOrderToArray->execute($orderId, $headerData);

        try {
            $results['success'] = $this->pushDetailsToWebService->execute($orderId, $orderDetails);
        } catch (\Exception $ex) {
            $results['error'] = $ex->getMessage();
        }

        $this->saveExportDetailsToOrder->execute($orderId, $headerData, $results);

        return $results;
    }
}
