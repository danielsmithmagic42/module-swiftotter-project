<?php
namespace SwiftOtter\OrderExport\Model;

class HeaderData
{
    /** @var \DateTime */
    private $shipDate;

    /** @var string */
    private $merchantNotes;

    /**
     * @return \DateTime
     */
    public function getShipDate()
    {
        return $this->shipDate;
    }

    /**
     * @param \DateTime $shipDate
     */
    public function setShipDate(\DateTime $shipDate)
    {
        $this->shipDate = $shipDate;
    }

    /**
     * @return string
     */
    public function getMerchantNotes()
    {
        return (string)$this->merchantNotes;
    }

    /**
     * @param string $merchantNotes
     */
    public function setMerchantNotes($merchantNotes)
    {
        $this->merchantNotes = $merchantNotes;
    }
}
