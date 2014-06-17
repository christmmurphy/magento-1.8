<?php
/**
 * @category   MagePsycho
 * @package    MagePsycho_Loginredirectpro
 * @author     magepsycho@gmail.com
 * @website    http://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagePsycho_Loginredirectpro_Block_System_Config_Notes extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $helper = Mage::helper('magepsycho_loginredirectpro');
		$notes = '<div style="border: 1px solid #D6D6D6;padding:0px 4px 4px 4px;margin:0px 4px 4px 4px;background-color:white"><div style="padding:5px"><p><h4> ' . $helper->__('Notes On Custom Redirection Url') . '</h4></p> ' . $helper->__("You can use either an internal or external url as custom redirection url. Also you can use some custom variables like 'referer', 'redirect_to' etc. as redirection url.<br />Please find the valid examples & notes below:") . '<br /><br /><b>' . $helper->__('Valid Examples:') . '</b><br />- {{base_url}}<br />- {{base_url}}welcome<br />- {{base_url}}customer/address <br />- {{referer}}<br />- {{redirect_to}}<br />- http://my-another-store.com/welcome <br />- http://mystore.com/read-me-first <br /><br /><b>' . $helper->__('Notes:') . ' </b><br /> 1. ' . $helper->__("{{base_url}} denotes the base url of current store (without store code & ending with /), used for internal url redirection.") . '<br /> 2. ' . $helper->__("{{referer}} is used when you want to redirect back to previous page.") . ' <br /> 3. ' . $helper->__("{{redirect_to}} is used when you want to redirect to the url mentioned in the query string(redirect to param)") . ' <br /> 4. ' . $helper->__("You have to use full url path for external url redirection. Example:") . ' http://my-another-store.com/welcome <br />5. ' . $helper->__("Other available variables are: {{ip}} - IP Address, {{country_code}} - Country Code, {{user_name}} - User Full Name, {{user_email}} - User Email Address, {{user_id}} - User Id, {{user_group_id}} - User Group Id") . '<br />6. ' . $helper->__("If Customer Group Wise Redirection Url is not defined (see below) then above Default Redirection Url will be used.") . '</div></div>';
        return sprintf('<tr class="system-fieldset-sub-head" id="row_%s"><td colspan="5">%s</td></tr>',
            $element->getHtmlId(), $notes
        );
    }
}