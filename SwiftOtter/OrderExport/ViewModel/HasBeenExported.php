<?php

namespace SwiftOtter\OrderExport\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use SwiftOtter\OrderExport\Service\Order as OrderService;

class HasBeenExported implements ArgumentInterface
{
    /** @var OrderService */
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function hasBeenExported()
    {
        return $this->orderService->get()
            ->getExtensionAttributes()
            ->getExportDetails()
            ->hasBeenExported();
    }
}
