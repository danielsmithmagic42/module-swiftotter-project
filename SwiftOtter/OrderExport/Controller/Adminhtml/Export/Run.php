<?php

namespace SwiftOtter\OrderExport\Controller\Adminhtml\Export;

use Magento\Backend\App\Action as BackendAction;
use Magento\Framework\App\Action\HttpPostActionInterface;
use SwiftOtter\OrderExport\Model\HeaderDataFactory;

/**
 * Class Run
 * - Controller entry point for when an order export is set to be created
 *
 * @package SwiftOtter\OrderExport\Controller\Adminhtml\Export
 */
class Run extends BackendAction implements HttpPostActionInterface
{
    protected $jsonFactory;
    protected $headerDataFactory;
    protected $orchestrator;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \SwiftOtter\OrderExport\Model\HeaderDataFactory $headerDataFactory,
        \SwiftOtter\OrderExport\Orchestrator $orchestrator
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->headerDataFactory = $headerDataFactory;
        $this->orchestrator = $orchestrator;

        return parent::__construct($context);
    }

    public function execute()
    {
        // Create header data model object
        $headerData = $this->headerDataFactory->create();
        $headerData->setShipDate(new \DateTime($this->getRequest()->getParam('ship_date') ?? ''));
        $headerData->setMerchantNotes((string)$this->getRequest()->getParam('merchant_notes'));

        // Run the orchestrator on the header data
        $results = $this->orchestrator->run(
            (int)$this->getRequest()->getParam('order_id'),
            $headerData
        );

        $response = $this->jsonFactory->create();
        $response->setData($results);

        return $response;
    }
}
