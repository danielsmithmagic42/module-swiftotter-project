<?php

namespace SwiftOtter\OrderExport\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface OrderExportDetailsSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get order export details list.
     *
     * @return \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface[]
     */
    public function getItems();

    /**
     * Set order export details list.
     *
     * @param \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
