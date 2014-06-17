<?php
class MagePsycho_Loginredirectpro_Block_Adminhtml_System_Config_Form_Fieldset_Customer_Loginredirect extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    protected $_dummyElement;
    protected $_fieldRenderer;
    protected $_values;

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $helper         = Mage::helper('magepsycho_loginredirectpro');
        $html = $this->_getHeaderHtml($element);
        $html .= $this->_getCustomHeaderHtml($element, '<strong>[ ' . $helper->__('Customer Group') . ' ]</strong>');

        $customerGroups = $helper->getCustomerGroups();
        $sortOrder      = 0;
        $noOfGroups     = count($customerGroups);
        foreach($customerGroups as  $customerGroups) {
            ++$sortOrder;
            $comment = '';
            if($sortOrder == $noOfGroups){
                $comment = $helper->__("Fill up the customer group wise Login Redirection Url.<br />If left empty then value from 'General Settings' > 'Default Login Redirection Url' (from above) will be used.");
            }
            $html .= $this->_getFieldHtml($element, $customerGroups, $comment);
        }

        $html .= $this->_getFooterHtml($element);

        return $html;
    }

    protected function _getDummyElement()
    {
        if (empty($this->_dummyElement)) {
            $this->_dummyElement = new Varien_Object(array('show_in_default'=>1, 'show_in_website'=>1));
        }
        return $this->_dummyElement;
    }

    protected function _getFieldRenderer()
    {
        if (empty($this->_fieldRenderer)) {
            $this->_fieldRenderer = Mage::getBlockSingleton('adminhtml/system_config_form_field');
        }
        return $this->_fieldRenderer;
    }

    protected function _getCustomFieldRenderer()
    {
        if (empty($this->_customFieldRenderer)) {
            $this->_customFieldRenderer = Mage::getBlockSingleton('magepsycho_loginredirectpro/system_config_customergrouplogintext');
        }
        return $this->_customFieldRenderer;
    }

    protected function _getCustomHeaderHtml($fieldset, $header)
    {
        $field = $fieldset->addField('customergrouplogintext', 'label',
            array(
                'name'          => 'groups[login_redirect][fields][customergrouplogintext][value]',
                'label'         => $header,
                'value'         => array(),
            ))->setRenderer($this->_getCustomFieldRenderer());

        return $field->toHtml();
    }

    protected function _getFieldHtml($fieldset, $customerGroup, $comment)
    {
        $configData = $this->getConfigData();
        $path = 'magepsycho_loginredirectpro/login_redirect/url_login_'.$customerGroup['value'];
        if (isset($configData[$path])) {
            $data = $configData[$path];
            $inherit = false;
        } else {
            $data = (string)$this->getForm()->getConfigRoot()->descend($path);
            $inherit = true;
        }

        $e = $this->_getDummyElement();

        $field = $fieldset->addField('url_login_' . $customerGroup['value'], 'text',
            array(
                'name'          => 'groups[login_redirect][fields][url_login_'.$customerGroup['value'].'][value]',
                'label'         => $customerGroup['label'],
                'value'         => $data,
                'inherit'       => $inherit,
                'comment'       => $comment,
                'can_use_default_value' => $this->getForm()->canUseDefaultValue($e),
                'can_use_website_value' => $this->getForm()->canUseWebsiteValue($e),
            ))->setRenderer($this->_getFieldRenderer());

        return $field->toHtml();
    }
}