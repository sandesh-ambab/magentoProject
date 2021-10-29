<?php

namespace Ambab\EMImodule\Model;

use Ambab\EMImodule\Api\Data;
use Ambab\EMImodule\Api\EmidetailsRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Ambab\EMImodule\Model\ResourceModel\Emidetails as ResourceEmidetails;
use Rsgitech\News\Model\ResourceModel\Allnews\CollectionFactory as AllnewsCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class AllnewsRepository implements AllnewsRepositoryInterface
{
    protected $resource;

    protected $emidetailsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataEmidetailsFactory;

    private $storeManager;

    public function __construct(
        ResourceEmidetails $resource,
        EmidetailsFactory $emidetailsFactory,
        Data\EmidetailsInterfaceFactory $dataEmidetailsFactory,
        DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
		$this->emidetailsFactory = $emidetailsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataEmidetailsFactory = $dataEmidetailsFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }
    
    public function save(\Ambab\EMImodule\Api\Data\EmidetailsInterface $bank)
    {
        if ($bank->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $bank->setStoreId($storeId);
        }
        try {
            $this->resource->save($bank);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the news: %1', $exception->getMessage()),
                $exception
            );
        }
        return $bank;
    }

    public function getById($bankId)
    {
		$bank = $this->allnewsFactory->create();
        $bank->load($bankId);
        if (!$bank->getId()) {
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $bankId));
        }
        return $bank;
    }
	
    public function delete(\Rsgitech\News\Api\Data\AllnewsInterface $bank)
    {
        try {
            $this->resource->delete($bank);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the news: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($bankId)
    {
        return $this->delete($this->getById($bankId));
    }
}
?>
