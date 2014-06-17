<?php
/**
 * @category   MagePsycho
 * @package    MagePsycho_Loginredirectpro
 * @author     magepsycho@gmail.com
 * @website    http://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
require_once 'Mage/Newsletter/controllers/SubscriberController.php';
class MagePsycho_Loginredirectpro_Newsletter_SubscriberController extends Mage_Newsletter_SubscriberController
{

	protected function _redirectReferer($defaultUrl = null)
    {
		$helper							 = Mage::helper('magepsycho_loginredirectpro');
		if($helper->isActive() && $helper->isValid()){
			$redirectUrl = $helper->getRedirectionUrl('newsletter');
			$this->getResponse()->setRedirect($redirectUrl);
			return $this;
		}else{
			return parent::_redirectReferer($defaultUrl);
		}
    }

    protected function _redirectUrl($url)
    {
		$helper							 = Mage::helper('magepsycho_loginredirectpro');
		if($helper->isActive() && $helper->isValid()){
			$redirectUrl = $helper->getRedirectionUrl('newsletter');
			$this->getResponse()->setRedirect($redirectUrl);
			return $this;
		}else{
			return parent::_redirectUrl($url);
		}
    }
}