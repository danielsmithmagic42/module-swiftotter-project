<?php

namespace SwiftOtter\OrderExport\Api;

interface OrderExportDetailsRepositoryInterface
{
    /**
     * Save order export details.
     *
     * @param \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface $details
     * @return \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\OrderExportDetailsInterface $details);

    /**
     * Retrieve order export details.
     *
     * @param int $id
     * @return \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve order export details matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete order export details.
     *
     * @param \SwiftOtter\OrderExport\Api\Data\OrderExportDetailsInterface $details
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\OrderExportDetailsInterface $details);

    /**
     * Delete order export details by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}
