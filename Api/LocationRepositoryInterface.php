<?php
namespace Fastgento\Storelocator\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface LocationRepositoryInterface
{
    /**
     * Save location.
     *
     * @param \Fastgento\Storelocator\Api\Data\LocationInterface $location
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\LocationInterface $location);

    /**
     * Retrieve location.
     *
     * @param int $locationId
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($locationId);

    /**
     * Retrieve locations matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Fastgento\Storelocator\Api\Data\LocationSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete block.
     *
     * @param \Fastgento\Storelocator\Api\Data\LocationInterface $location
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\LocationInterface $location);

    /**
     * Delete location by ID.
     *
     * @param int $locationId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($locationId);

    /**
     * Get nearest locations.
     *
     * @api
     * @param float $lat
     * @param float $lng
     * @param float $dst
     * @return mixed
     */
    public function getNearestLocations($lat, $lng, $dst);
}