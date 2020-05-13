<?php

namespace SwiftOtter\OrderExport\Action;

use Psr\Log\LoggerInterface;

/**
 * Class PushDetailsToWebService
 * - Push the order details to a web service
 *
 * @package SwiftOtter\OrderExport\Action
 */
class PushDetailsToWebService
{
    /** @var LoggerInterface $logger */
    private $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @param $orderId
     * @param $orderDetails
     * @return bool
     */
    public function execute(
        $orderId,
        $orderDetails
    ) {
        // Here it would be pushed to a web service

        return true;
    }
}
