<?php
/**
 * @category   MagePsycho
 * @package    MagePsycho_Loginredirectpro
 * @author     magepsycho@gmail.com
 * @website    http://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
require_once 'Mage/Customer/controllers/AccountController.php';
class MagePsycho_Loginredirectpro_Customer_AccountController extends Mage_Customer_AccountController
{

   /**
     * Overriding defaults redirect URL
     * Define target URL and redirect customer after logging in
     */
    protected function _loginPostRedirect()
    {
        $session                         = $this->_getSession();
		$helper							 = Mage::helper('magepsycho_loginredirectpro');

        if( $helper->isActive() && $helper->isValid() && strpos($this->_getRefererUrl(), '/checkout/onepage') === false) {
            if($session->isLoggedIn()){
                $redirectionUrl = $helper->getRedirectionUrl('login');
                $session->setBeforeAuthUrl($redirectionUrl);
            }else{
                $session->setBeforeAuthUrl(Mage::helper('customer')->getLoginUrl());
            }
            $logoutRedirectionUrl			 = $helper->getRedirectionUrl('logout');
            $session->setAfterLogoutUrlClrp($logoutRedirectionUrl);

        }else{
            if (!$session->getBeforeAuthUrl() || $session->getBeforeAuthUrl() == Mage::getBaseUrl() ) {

                // Set default URL to redirect customer to
                $session->setBeforeAuthUrl(Mage::helper('customer')->getAccountUrl());

                // Redirect customer to the last page visited after logging in
                if ($session->isLoggedIn())
                {
                    if (!Mage::getStoreConfigFlag('customer/startup/redirect_dashboard')) {
                        if ($referer = $this->getRequest()->getParam(Mage_Customer_Helper_Data::REFERER_QUERY_PARAM_NAME)) {
                            $referer = Mage::helper('core')->urlDecode($referer);
                            if ($this->_isUrlInternal($referer)) {
                                $session->setBeforeAuthUrl($referer);
                            }
                        }
                    }
                } else {
                    $session->setBeforeAuthUrl(Mage::helper('customer')->getLoginUrl());
                }
            }
        }

        $this->_redirectUrl($session->getBeforeAuthUrl(true));
    }

	protected function _welcomeCustomer(Mage_Customer_Model_Customer $customer, $isJustConfirmed = false)
    {
        $helper         = Mage::helper('magepsycho_loginredirectpro');
        $moduleName     = $this->getRequest()->getModuleName();
        $controllerName = $this->getRequest()->getControllerName();
        $actionName     = $this->getRequest()->getActionName();
		if($helper->isActive() && $helper->isValid() && $moduleName == 'customer' && $controllerName == 'account' && in_array($actionName, array('createpost'))){
			$coreSession		= Mage::getSingleton('core/session');
			$customerSession	= Mage::getSingleton('customer/session');
			$coreSession->getMessages(true);
			$customerSession->getMessages(true);

            //custom success message
            $successMessage = $helper->getNewAccountSuccessMessage();
			$coreSession->addSuccess(
				$this->__($successMessage, Mage::app()->getStore()->getFrontendName())
			);

			$customer->sendNewAccountEmail($isJustConfirmed ? 'confirmed' : 'registered');

			$successUrl = $helper->getRedirectionUrl('account');
			return $successUrl;

		}else{
			return parent::_welcomeCustomer($customer, $isJustConfirmed);
		}
    }

	protected function _redirectSuccess($defaultUrl)
    {
		$helper				= Mage::helper('magepsycho_loginredirectpro');
        $moduleName		= $this->getRequest()->getModuleName();
		$controllerName	= $this->getRequest()->getControllerName();
		$actionName		= $this->getRequest()->getActionName();
		if($helper->isActive() && $helper->isValid() && $moduleName == 'customer' && $controllerName == 'account' && in_array($actionName, array('createpost'))){
			$successUrl = $helper->getRedirectionUrl('account');
			$this->getResponse()->setRedirect($successUrl);
			return $this;
		}else{
			return parent::_redirectSuccess($defaultUrl);
		}
    }

}
