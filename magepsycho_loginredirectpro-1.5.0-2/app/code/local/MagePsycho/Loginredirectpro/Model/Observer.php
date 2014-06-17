<?php
/**
 * @category   MagePsycho
 * @package    MagePsycho_Loginredirectpro
 * @author     magepsycho@gmail.com
 * @website    http://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagePsycho_Loginredirectpro_Model_Observer
{
	public function controllerActionPredispatch(Varien_Event_Observer $observer)
	{
		$helper				= Mage::helper('magepsycho_loginredirectpro');
		$isValid			= $helper->isValid();
		$isActive			= $helper->isActive();
		$request			= Mage::app()->getRequest();
		$coreSession		= Mage::getSingleton('core/session');
		$customerSession	= Mage::getSingleton('customer/session');

		if (($isActive && !$isValid) || !$isActive) {
			return;
		}

		$moduleName		= $request->getModuleName();
		$controllerName	= $request->getControllerName();
		$actionName		= $request->getActionName();
		if ($moduleName != 'customer' && $controllerName != 'account') {
			if (!in_array($observer->getControllerAction()->getFullActionName(), array('cms_index_noRoute', 'cms_index_defaultNoRoute')) && !$request->isXmlHttpRequest()) {
				$currentUrl = Mage::helper("core/url")->getCurrentUrl();
				$customerSession->setBeforeAuthUrlClrp($currentUrl);
				$helper->log('setBeforeAuthUrlClrp::'.$currentUrl);
			}
		} else {
            $redirectToParam   = $helper->getRedirectToParam();
            $redirectToUrl     = $request->getParam($redirectToParam);
            if(!empty($redirectToUrl)){
                $customerSession->setRedirectToUrlClrp($redirectToUrl);
                $helper->log('setRedirectToUrlClrp::'.$redirectToUrl);
            }
        }
        return $this;
	}

    public function adminhtmlPreDispatchCheck(Varien_Event_Observer $observer)
    {
        $helper				= Mage::helper('magepsycho_loginredirectpro');
        $isValid			= $helper->isValid();
        $isActive			= $helper->isActive();
        $adminhtmlSession	= Mage::getSingleton('adminhtml/session');
        $fullActionName		= $observer->getEvent()->getControllerAction()->getFullActionName();
        if ($isActive && !$isValid && 'adminhtml_system_config_edit' == $fullActionName) {
            $adminhtmlSession->getMessages(true);
            $adminhtmlSession->addError($helper->getMessage());
            return;
        }
        return $this;
    }

}

