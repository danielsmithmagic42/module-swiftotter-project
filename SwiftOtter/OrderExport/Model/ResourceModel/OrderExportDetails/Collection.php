<?php

namespace SwiftOtter\OrderExport\Model\ResourceModel\OrderExportDetails;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \SwiftOtter\OrderExport\Model\OrderExportDetails::class,
            \SwiftOtter\OrderExport\Model\ResourceModel\OrderExportDetails::class
        );
    }
}
