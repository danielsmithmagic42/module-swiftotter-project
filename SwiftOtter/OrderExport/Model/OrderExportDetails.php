<?php

namespace SwiftOtter\OrderExport\Model;

use SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface;

/**
 * Model for the "sales_order_export" table
 *
 * Class OrderExportDetails
 * @package SwiftOtter\OrderExport\Model
 */
class OrderExportDetails extends \Magento\Framework\Model\AbstractModel implements OrderExportDetailsInterface
{
    protected function _construct()
    {
        $this->_init(\SwiftOtter\OrderExport\Model\ResourceModel\OrderExportDetails::class);
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return (int)$this->getData('order_id');
    }

    /**
     * @param int $orderId
     * @return void
     */
    public function setOrderId($orderId)
    {
        $this->setData('order_id', $orderId);
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getShipOn()
    {
        return new \DateTime($this->getData('ship_on'));
    }

    /**
     * @param \DateTime $shipOn
     * @return void
     */
    public function setShipOn($shipOn)
    {
        $this->setData('ship_on', $shipOn);
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getExportedAt()
    {
        return new \DateTime($this->getData('exported_at'));
    }

    /**
     * @param \DateTime $exportedAt
     * @return void
     */
    public function setExportedAt($exportedAt)
    {
        $this->setData('exported_at', $exportedAt);
    }

    /**
     * @return bool
     */
    public function hasBeenExported()
    {
        return (bool)$this->getData('exported_at');
    }

    /**
     * @return string
     */
    public function getMerchantNotes()
    {
        return (string)$this->getData('merchant_notes');
    }

    /**
     * @param string $merchantNotes
     * @return void
     */
    public function setMerchantNotes($merchantNotes)
    {
        $this->setData('merchant_notes', $merchantNotes);
    }
}
