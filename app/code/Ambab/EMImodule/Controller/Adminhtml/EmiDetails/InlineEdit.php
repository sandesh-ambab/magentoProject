<?php
namespace Ambab\EMImodule\Controller\Adminhtml\Emidetails;

use Magento\Backend\App\Action\Context;
use Ambab\EMImodule\Api\EmidetailsRepositoryInterface as EmidetailsRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Ambab\EMImodule\Api\Data\EmidetailsInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    protected $emidetailsRepository;

    protected $jsonFactory;

    public function __construct(
        Context $context,
        EmidetailsRepository $emidetailsRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->emidetailsRepository = $emidetailsRepository;
        $this->jsonFactory = $jsonFactory;
    }
	
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Ambab_EMImodule::save');
	}

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $bankId) {
            $bank = $this->emidetailsRepository->getById($bankId);
            try {
                $bankData = $postItems[$bankId];
                $extendedBankData = $bank->getData();
                $this->setBankData($bank, $extendedBankData, $bankData);
                $this->emidetailsRepository->save($bank);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithBankId($bank, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithBankId($bank, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithBankId(
                    $bank,
                    __('Something went wrong while saving the bank details.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function getErrorWithBankId(EmidetailsInterface $bank, $errorText)
    {
        return '[Bank ID: ' . $bank->getId() . '] ' . $errorText;
    }

    public function setBankData(\Ambab\EMImodule\Model\Emidetails $bank, array $extendedBankData, array $bankData)
    {
        $bank->setData(array_merge($bank->getData(), $extendedBankData, $bankData));
        return $this;
    }
}