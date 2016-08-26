<?php
namespace Fastgento\Storelocator\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Fastgento\Storelocator\Api\LocationRepositoryInterface as LocationRepository;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Fastgento\Storelocator\Api\Data\LocationInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    /** @var LocationRepository  */
    protected $locationRepository;

    /** @var JsonFactory  */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param LocationRepository $locationRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        LocationRepository $locationRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->locationRepository = $locationRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $locationId) {
                    /** @var \Magento\Cms\Model\Block $block */
                    $location = $this->locationRepository->getById($locationId);
                    try {
                        $location->setData(array_merge($location->getData(), $postItems[$locationId]));
                        $this->locationRepository->save($location);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithBlockId(
                            $location,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}