<?php
namespace Ambab\EMImodule\Model\Emidetails;

use Ambab\EMImodule\Model\ResourceModel\Emidetails\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Ambab\EMImodule\Model\ResourceModel\Emidetails\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $emidetailsCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $emidetailsCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        
        foreach ($items as $bank) {
            $this->loadedData[$bank->getId()] = $bank->getData();
        }

        $data = $this->dataPersistor->get('emicalc_emidetails');
        if (!empty($data)) {
            $bank = $this->collection->getNewEmptyItem();
            $bank->setData($data);
            $this->loadedData[$bank->getId()] = $bank->getData();
            $this->dataPersistor->clear('emicalc_emidetails');
        }

        return $this->loadedData;
    }
}