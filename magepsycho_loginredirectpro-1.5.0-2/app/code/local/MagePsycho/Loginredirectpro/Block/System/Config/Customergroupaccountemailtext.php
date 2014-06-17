<?php
/**
 * @category   MagePsycho
 * @package    MagePsycho_Loginredirectpro
 * @author     magepsycho@gmail.com
 * @website    http://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagePsycho_Loginredirectpro_Block_System_Config_Customergroupaccountemailtext extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setValue('newAccountEmailTemplate');
        return $html = '<strong>[ ' . Mage::helper('magepsycho_loginredirectpro')->__('New Account Email Template') . ' ]</strong>';
    }
}