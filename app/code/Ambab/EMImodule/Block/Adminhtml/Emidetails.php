<?php
namespace Ambab\EMImodule\Block\Adminhtml;

class Emidetails extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function __construct()
    {
        $this->_controller = 'adminhtml_emidetails';
        $this->_blockGroup = 'Ambab_EMImodule';
        $this->_headerText = __('Manage Bank Details');

        parent::_construct();

        if ($this->_isAllowedAction('Ambab_EMImodule::save')) {
            $this->buttonList->update('add', 'label', __('Add Bank'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
