<?php

namespace SwiftOtter\OrderExport\Api\Data;

interface OrderExportDetailsInterface
{
    /**
     * @return int
     */
    public function getOrderId();

    /**
     * @param int $orderId
     * @return void
     */
    public function setOrderId($orderId);
    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getShipOn();

    /**
     * @param \DateTime $shipOn
     * @return void
     */
    public function setShipOn($shipOn);

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getExportedAt();

    /**
     * @param \DateTime $exportedAt
     * @return void
     */
    public function setExportedAt($exportedAt);
    /**
     * @return bool
     */
    public function hasBeenExported();

    /**
     * @return string
     */
    public function getMerchantNotes();

    /**
     * @param string $merchantNotes
     * @return void
     */
    public function setMerchantNotes($merchantNotes);
}