<?php
namespace SwiftOtter\OrderExport\ViewModel;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class OrderDetails implements ArgumentInterface
{
    private $formKey;
    private $urlBuilder;
    private $authorization;
    private $request;


    public function __construct(
        FormKey $formKey,
        UrlInterface $urlBuilder,
        AuthorizationInterface $authorization,
        RequestInterface $request
    ) {
        $this->formKey = $formKey;
        $this->urlBuilder = $urlBuilder;
        $this->authorization = $authorization;
        $this->request = $request;
    }

    public function isAllowed()
    {
        return $this->authorization->isAllowed('SwiftOtter_OrderExport::OrderExport');
    }

    public function getButtonMessage()
    {
        return (string)__('Send Order to Fulfillment');
    }

    public function getConfig()
    {
        $upload_url = $this->urlBuilder->getUrl("order_export/export/run",
            [
                'order_id' => (int)$this->request->getParam('order_id')
            ]
        );

        return [
            'sending_message' => __('Sending...'),
            'original_message' => $this->getButtonMessage(),
            'form_key' => $this->formKey->getFormKey(),
            'upload_url' => $upload_url
        ];
    }
}
