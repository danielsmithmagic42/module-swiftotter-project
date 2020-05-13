<?php

namespace SwiftOtter\OrderExport\Api;

use Magento\Sales\Api\Data\OrderInterface;
use SwiftOtter\OrderExport\Model\HeaderData;

/**
 * Interface DataCollectorInterface
 * - Interface for collector classes
 *
 * @package SwiftOtter\OrderExport\Api
 */
interface DataCollectorInterface
{
    public function collect(OrderInterface $order, HeaderData $headerData);
}
