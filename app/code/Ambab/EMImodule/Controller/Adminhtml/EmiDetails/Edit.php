<?php

namespace Ambab\EMImodule\Controller\Adminhtml\Emidetails;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry;

    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }
	
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Ambab_EMImodule::save');
	}

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Allnews $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ambab_EMImodule::emicalc_emidetails')
            ->addBreadcrumb(__('Bank'), __('Bank'))
            ->addBreadcrumb(__('Manage All Bank'), __('Manage All Bank'));
        return $resultPage;
    }

    //Edit
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create(\Ambab\EMImodule\Model\Emidetails::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This bank no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('emicalc_emidetails', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Allnews $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Bank') : __('Add Bank'),
            $id ? __('Edit Bank') : __('Add Bank')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Emidetails'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Add Bank'));

        return $resultPage;
    }
}