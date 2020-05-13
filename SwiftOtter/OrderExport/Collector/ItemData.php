<?php

namespace SwiftOtter\OrderExport\Collector;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use SwiftOtter\OrderExport\Api\DataCollectorInterface;

/**
 * Class ItemData
 * - Collects the order item data to be returned as an array
 *
 * @package SwiftOtter\OrderExport\Collector
 */
class ItemData implements DataCollectorInterface
{
    private $allowedTypes;

    public function __construct(
        $allowedTypes
    ) {
        $this->allowedTypes = $allowedTypes;
    }

    /**
     * @param OrderInterface $order
     * @param \SwiftOtter\OrderExport\Model\HeaderData $headerData
     * @return array
     */
    public function collect(OrderInterface $order, \SwiftOtter\OrderExport\Model\HeaderData $headerData)
    {
        /** @var OrderItemInterface[] $items */
        $items = [];

        foreach ($order->getItems() as $item) {
            if (!in_array($item->getProductType(), $this->allowedTypes)) {
                continue;
            }

            $items[] = $this->transformItem($item);
        }

        return [
            'items' => $items
        ];
    }

    /**
     * @param OrderItemInterface $item
     * @return array
     */
    private function transformItem(OrderItemInterface $item)
    {
        return [
            'sku' => $item->getSku(),
            'qty' => $item->getQtyOrdered(),
            'item_price' => $item->getBasePrice(),
            'item_cost' => $item->getBaseCost(),
            'total' => $item->getRowTotal()
        ];
    }
}
