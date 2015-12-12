<?php
namespace Fastgento\Storelocator\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LocationSearchResultsInterface extends  SearchResultsInterface
{
    /**
     * Get locations list.
     *
     * @return \Fastgento\Storelocator\Api\Data\LocationInterface[]
     */
    public function getItems();

    /**
     * Set locations list.
     *
     * @param \Fastgento\Storelocator\Api\Data\LocationInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}