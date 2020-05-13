<?php

namespace SwiftOtter\OrderExport\Model\ResourceModel;

class OrderExportDetails extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sales_order_export', 'id');
    }
}
