<?php

namespace Ambab\EMImodule\Controller\Adminhtml\Emidetails;

use Magento\Backend\App\Action;
use Ambab\EMImodule\Model\Emidetails;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    
    protected $dataPersistor;

    private $emidetailsFactory;

    private $emidetailsRepository;

    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \Ambab\EMImodule\Model\EmidetailsFactory $emidetailsFactory = null,
        \Ambab\EMImodule\Api\EmidetailsRepositoryInterface $emidetailsRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->emidetailsFactory = $emidetailsFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Ambab\EMImodule\Model\EmidetailsFactory::class);
        $this->emidetailsRepository = $emidetailsRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Ambab\EMImodule\Api\EmidetailsRepositoryInterface::class);
        parent::__construct($context);
    }
	
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Amabab_EMImodule::save');
	}

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Emidetails::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            $model = $this->emidetailsFactory->create();

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->emidetailsRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This bank no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'emicalc_emidetails_prepare_save',
                ['emidetails' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->emidetailsRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the bank.'));
                $this->dataPersistor->clear('emicalc_emidetails');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the bank details.'));
            }

            $this->dataPersistor->set('emicalc_emidetails', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
?>
