<?php
namespace Ambab\EMImodule\Block\Adminhtml\Emidetails\Edit;

use Magento\Backend\Block\Widget\Context;
use Ambab\EMImodule\Api\EmidetailsRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $allemiRepository;
    
    public function __construct(
        Context $context,
        EmidetailsRepositoryInterface $allemiRepository
    ) {
        $this->context = $context;
        $this->allemiRepository = $allemiRepository;
    }

    public function getBankId()
    {
        try {
            return $this->allemiRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
?>
