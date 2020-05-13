<?php

namespace SwiftOtter\OrderExport\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SwiftOtter\OrderExport\Api\Data;
use SwiftOtter\OrderExport\Model\ResourceModel\OrderExportDetails as OrderExportDetailsModel;
use SwiftOtter\OrderExport\Model\ResourceModel\OrderExportDetails\CollectionFactory as OrderExportDetailsCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class OrderExportDetailsRepository implements \SwiftOtter\OrderExport\Api\OrderExportDetailsRepositoryInterface
{
    private $resource;
    private $orderExportDetailsFactory;
    private $orderExportDetailsCollectionFactory;
    private $searchResultsFactory;
    private $collectionProcessor;

    public function __construct(
        OrderExportDetailsModel $resource,
        OrderExportDetailsFactory $orderExportDetailsFactory,
        OrderExportDetailsCollectionFactory $orderExportDetailsCollectionFactory,
        Data\OrderExportDetailsSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->orderExportDetailsFactory = $orderExportDetailsFactory;
        $this->orderExportDetailsCollectionFactory = $orderExportDetailsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * Save order export details.
     *
     * @param \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface $details
     * @return \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\OrderExportDetailsInterface $details)
    {
        try {
            $this->resource->save($details);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $details;
    }

    /**
     * Retrieve order export details.
     *
     * @param int $id
     * @return \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id)
    {
        $details = $this->orderExportDetailsFactory->create();
        $this->resource->load($details, $id);
        if (!$details->getId()) {
            throw new NoSuchEntityException(__('The order export details with the "%1" ID doesn\'t exist', $id));
        }

        return $details;
    }

    /**
     * Retrieve order export details matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \SwiftOtter\OrderExport\Model\ResourceModel\OrderExportDetails\Collection $collection */
        $collection = $this->orderExportDetailsCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var Data\OrderExportDetailsSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete order export details.
     *
     * @param \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface $details
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\OrderExportDetailsInterface $details)
    {
        try {
            $this->resource->delete($details);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete order export details by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    /**
     * Retrieve collection processor
     *
     * @return CollectionProcessorInterface
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'SwiftOtter\OrderExport\Model\Api\SearchCriteria\BlockCollectionProcessor'
            );
        }

        return $this->collectionProcessor;
    }
}
