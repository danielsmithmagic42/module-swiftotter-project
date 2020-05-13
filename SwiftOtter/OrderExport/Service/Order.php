<?php

namespace SwiftOtter\OrderExport\Service;

use Magento\Framework\App\RequestInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class Order
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var RequestInterface */
    private $request;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        RequestInterface $request
    ) {
        $this->orderRepository = $orderRepository;
        $this->request = $request;
    }

    /**
     * @return OrderInterface
     */
    public function get()
    {
        return $this->orderRepository->get(
            (int)$this->request->getParam('order_id')
        );
    }
}
