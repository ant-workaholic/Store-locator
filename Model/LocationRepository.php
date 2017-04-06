<?php
namespace Fastgento\Storelocator\Model;

use Fastgento\Storelocator\Api\Data;
use Fastgento\Storelocator\Api\LocationRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Fastgento\Storelocator\Model\ResourceModel\Location as ResourceLocation;
use Fastgento\Storelocator\Model\ResourceModel\Location\CollectionFactory as LocationCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class LocationRepository
 * @package Fastgento\Storelocator\Model
 */
class LocationRepository implements LocationRepositoryInterface
{

    protected $resource;
    protected $locationFactory;
    protected $blockCollectionFactory;
    protected $searchResultsFactory;
    protected $dataObjectHelper;
    protected $dataLocationFactory;
    protected $dataObjectProcessor;
    protected $storeManager;


    /**
     * @param ResourceLocation $resource
     * @param LocationFactory $locationFactory
     * @param Data\LocationInterfaceFactory $dataLocationFactory
     * @param LocationCollectionFactory $locationCollectionFactory
     * @param Data\LocationSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceLocation $resource,
        LocationFactory $locationFactory,
        \Fastgento\Storelocator\Api\Data\LocationInterfaceFactory $dataLocationFactory,
        LocationCollectionFactory $locationCollectionFactory,
        Data\LocationSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->locationFactory = $locationFactory;
        $this->blockCollectionFactory = $locationCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataLocationFactory = $dataLocationFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }


    /**
     * Delete block.
     *
     * @param \Fastgento\Storelocator\Api\Data\LocationInterface $location
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\LocationInterface $location)
    {
        try {
            $this->resource->delete($location);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete location by ID.
     *
     * @param int $locationId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($locationId)
    {
        return $this->delete($this->getById($locationId));
    }

    /**
     * Retrieve location.
     *
     * @param int $locationId
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($locationId)
    {
        $location = $this->locationFactory->create();
        $this->resource->load($location, $locationId);
        if (!$location->getId()) {
            throw new NoSuchEntityException(__('CMS Block with id "%1" does not exist.', $locationId));
        }
        return $location;
    }

    /**
     * Retrieve locations matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Fastgento\Storelocator\Api\Data\LocationSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $collection = $this->blockCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $blocks = [];
        /** @var Location $locationModel */
        foreach ($collection as $locationModel) {
            $locationData = $this->dataLocationFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $locationData,
                $locationModel->getData(),
                'Magento\Cms\Api\Data\BlockInterface'
            );
            $blocks[] = $this->dataObjectProcessor->buildOutputDataArray(
                $locationData,
                'Fastgento\Storelocator\Api\Data\LocationInterface'
            );
        }
        $searchResults->setItems($blocks);
        return $searchResults;
    }

    /**
     * Save location.
     *
     * @param \Fastgento\Storelocator\Api\Data\LocationInterface $location
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\LocationInterface $location)
    {
        try {
            $this->resource->save($location);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $location;
    }

}