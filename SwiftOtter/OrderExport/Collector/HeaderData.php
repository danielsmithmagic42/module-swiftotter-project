<?php

namespace SwiftOtter\OrderExport\Collector;

use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderAddressRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use SwiftOtter\OrderExport\Api\DataCollectorInterface;

/**
 * Class HeaderData
 * - Collect the shipping data for the order
 *
 * @package SwiftOtter\OrderExport\Collector
 */
class HeaderData implements DataCollectorInterface
{
    private $scopeConfig;
    private $addressRepository;
    private $criteriaBuilderFactory;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SearchCriteriaBuilderFactory $criteriaBuilderFactory,
        OrderAddressRepositoryInterface $addressRepository
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->criteriaBuilderFactory = $criteriaBuilderFactory;
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param OrderInterface $order
     * @param \SwiftOtter\OrderExport\Model\HeaderData $headerData
     * @return array
     */
    public function collect(OrderInterface $order, \SwiftOtter\OrderExport\Model\HeaderData $headerData)
    {
        /** @var OrderAddressInterface $shippingAddress */
        $shippingAddress = $this->getShippingAddressFor($order);

        $output = [
            'password' => $this->scopeConfig->getValue(
                'sales/order_export/password',
                ScopeInterface::SCOPE_STORES,
                $order->getStoreId()
            ),
            'id' => $order->getIncrementId(),
            'currency' => $order->getBaseCurrencyCode(),
            'customer_notes' => $order->getExtensionAttributes()->getBoldOrderComment(),
            'merchant_notes' => $headerData->getMerchantNotes(),
            'discount' => $order->getBaseDiscountAmount(),
            'total' => $order->getBaseGrandTotal(),
        ];

        if ($shippingAddress) {
            $output['shipping'] = [
                'name' => $shippingAddress->getFirstname() . ' ' . $shippingAddress->getLastname(),
                'address' => $shippingAddress->getStreet() ? implode(', ', $shippingAddress->getStreet()) : '',
                'city' => $shippingAddress->getCity(),
                'state' => $shippingAddress->getRegionCode(),
                'postcode' => $shippingAddress->getPostcode(),
                'country' => $shippingAddress->getCountryId(),
                'amount' => $order->getBaseShippingAmount(),
                'method' => $order->getShippingDescription(),
                'ship_on' => $headerData->getShipDate()->format('d/m/Y'),
            ];
        }

        return $output;
    }

    /**
     * @param OrderInterface $order
     * @return OrderAddressInterface
     */
    private function getShippingAddressFor(OrderInterface $order)
    {
        $searchCriteriaBuilder = $this->criteriaBuilderFactory->create();
        $searchCriteria = $searchCriteriaBuilder
            ->addFilter('parent_id', $order->getEntityId())
            ->addFilter('address_type', 'shipping')
            ->create();

        $addresses =  $this->addressRepository->getList(
            $searchCriteria
        );

        if (!count($addresses->getItems())) {
            return null;
        }

        $items = $addresses->getItems();
        return reset($items);
    }
}
