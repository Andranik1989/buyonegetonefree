<?php

namespace AndMage\BuyOneGetOne\Block\Adminhtml\PromotedProducts\Edit;
use  Magento\Backend\Block\Widget\Form\Generic;

/**
 * Class Form
 * @package AndMage\BuyOneGetOne\Block\Adminhtml\PromotedProducts\Edit
 */
class Form extends Generic
{
    /**
     * @return Form
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {

        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
