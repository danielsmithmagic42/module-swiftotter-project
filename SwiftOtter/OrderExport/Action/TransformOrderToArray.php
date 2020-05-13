<?php

namespace SwiftOtter\OrderExport\Action;

use Magento\Sales\Api\OrderRepositoryInterface;
use SwiftOtter\OrderExport\Model\HeaderData;

/**
 * Class TransformOrderToArray
 * - Acts as an iterator action class, iterates through the child collector classes
 * - Collector classes associated through etc/di.xml
 *
 * @package SwiftOtter\OrderExport\Action
 */
class TransformOrderToArray
{
    private $collectors;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    public function __construct(
        array $collectors,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->collectors = $collectors;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param $orderId
     * @param HeaderData $headerData
     * @return array
     */
    public function execute(
        $orderId,
        HeaderData $headerData
    ) {
        // Iterates through
        $order = $this->orderRepository->get($orderId);
        $output = [];

        foreach ($this->collectors as $collector) {
            $output = array_merge($output, $collector->collect($order, $headerData));
        }

        return $output;
    }
}
