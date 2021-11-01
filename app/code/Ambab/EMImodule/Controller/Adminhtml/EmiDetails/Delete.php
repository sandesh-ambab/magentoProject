<?php

namespace Ambab\EMImodule\Controller\Adminhtml\Emidetails;

class Delete extends \Magento\Backend\App\Action
{
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Ambab_EMImodule::emicalc_delete');
	}
	
	/**
     * Delete action
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $bankName = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Ambab\EMImodule\Model\Emidetails::class);
                $model->load($id);
                $bankName = $model->getBankName();
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('The bank has been deleted.'));
                // go to grid
                $this->_eventManager->dispatch(
                    'adminhtml_bank_on_delete',
                    ['bank_name' => $bankName, 'status' => 'success']
                );
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_bank_on_delete',
                    ['bank_name' => $bank_name, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a bank to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}