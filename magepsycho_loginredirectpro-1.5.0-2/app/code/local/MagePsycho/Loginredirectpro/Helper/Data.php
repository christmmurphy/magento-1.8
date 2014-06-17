<?php
/**
 * @category   MagePsycho
 * @package    MagePsycho_Loginredirectpro
 * @author     magepsycho@gmail.com
 * @website    http://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagePsycho_Loginredirectpro_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getConfig($field, $section = 'option', $default = null)
	{
        $value = Mage::getStoreConfig('magepsycho_loginredirectpro/' . $section . '/'.$field);
        if(!isset($value) || !strlen(trim($value))){
            return $default;
        }else{
            return $value;
        }
	}

    public function log($data)
	{
		if(!$this->getConfig('enable_log')){
			return;
		}
        $separator = "===================================================================";
        Mage::log($separator, null, 'magepsycho_loginredirectpro.log', true);
        Mage::log($data, null, 'magepsycho_loginredirectpro.log', true);
	}

    public function getCustomerGroups()
	{
        $customerGroups = Mage::getResourceModel('customer/group_collection')
                 ->setRealGroupsFilter()
                ->loadData()
                ->toOptionArray();
        return $customerGroups;
    }

	public function getCurrentCustomerGroup()
	{
		$customer						= $this->getCustomerSession()->getCustomer();
		$customerGroup					= $customer->getGroupId();
		return $customerGroup;
	}

	public function getRedirectionUrl($for)
	{
		$session						 = Mage::getSingleton('customer/session');
		$customerGroup                  = $this->getCurrentCustomerGroup();

		switch($for){
			case 'login':
				$defaultUrl		= Mage::helper('customer')->getAccountUrl();
				$redirectionUrl = trim($this->getConfig('url_login_' . $customerGroup, 'login_redirect'));
				if(empty($redirectionUrl)){
					$redirectionUrl   = trim($this->getConfig('url_login'));
				}
				break;
			case 'logout':
				$defaultUrl		= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
				$redirectionUrl = trim($this->getConfig('url_logout_' . $customerGroup, 'logout_redirect'));
				if(empty($redirectionUrl)){
					$redirectionUrl   = trim($this->getConfig('url_logout'));
				}
				break;
			case 'account':
				$defaultUrl		= Mage::helper('customer')->getAccountUrl();
				$redirectionUrl = trim($this->getConfig('url_account_' . $customerGroup, 'account_redirect'));
				if(empty($redirectionUrl)){
					$redirectionUrl   = trim($this->getConfig('url_account'));
				}
				break;
			case 'newsletter':
				$defaultUrl		= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
				$redirectionUrl = trim($this->getConfig('url_newsletter'));
				break;
			default:
				$defaultUrl		= '';
				$redirectionUrl = '';
				break;
		}

		$this->log('$customerGroup::' . $customerGroup . ', $redirectionUrl::'.$redirectionUrl.', $defaultUrl::'.$defaultUrl.', $for::'.$for);

		if(!empty($redirectionUrl)){
			if(strpos($redirectionUrl, '{{base_url}}') !== false){ //Internal
				$redirectionUrl              = trim( str_replace('{{base_url}}', rtrim(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB, true), '/'), $redirectionUrl), '/');
			}
			if (strpos($redirectionUrl, '{{referer}}') !== false){ //Referer
				$redirectionUrl				 =  trim( str_replace('{{referer}}', $session->getBeforeAuthUrlClrp(), $redirectionUrl), '/');
			}
            if (strpos($redirectionUrl, '{{redirect_to}}') !== false){ //Redirect to using query param
				$redirectionUrl				 =  trim( str_replace('{{redirect_to}}', $session->getRedirectToUrlClrp(), $redirectionUrl), '/');
			}
            if (strpos($redirectionUrl, '{{ip}}') !== false){ //Ip Address
                $redirectionUrl				 =  trim( str_replace('{{ip}}', $this->getIpAddress(), $redirectionUrl), '/');
            }
            if (strpos($redirectionUrl, '{{country_code}}') !== false){ //Ip Address
                $redirectionUrl				 =  trim( str_replace('{{country_code}}', $this->getCurrencyCode(), $redirectionUrl), '/');
            }

            if ($this->getCustomerSession()->isLoggedIn()) {
                $customer    = $this->getCustomerSession()->getCustomer();
                $userName    = $customer->getName();
                $userEmail   = $customer->getEmail();
                $userId      = $customer->getId();
                $userGroupId = $customer->getGroupId();
                if (strpos($redirectionUrl, '{{user_name}}') !== false){ //User Full Name
                    $redirectionUrl				 =  trim( str_replace('{{user_name}}', $userName, $redirectionUrl), '/');
                }
                if (strpos($redirectionUrl, '{{user_email}}') !== false){ //User Email
                    $redirectionUrl				 =  trim( str_replace('{{user_email}}', $userEmail, $redirectionUrl), '/');
                }
                if (strpos($redirectionUrl, '{{user_id}}') !== false){ //User Id
                    $redirectionUrl				 =  trim( str_replace('{{user_id}}', $userId, $redirectionUrl), '/');
                }
                if (strpos($redirectionUrl, '{{user_group_id}}') !== false){ //User Group Id
                    $redirectionUrl				 =  trim( str_replace('{{user_group_id}}', $userGroupId, $redirectionUrl), '/');
                }
            }

			$redirectionUrl                  = trim($redirectionUrl, '/');

		}else{
			$redirectionUrl = $defaultUrl; //redirect to default url
		}
		$this->log('$redirectionUrl(parsed)::'.$redirectionUrl);
		return $redirectionUrl;
	}

	function __construct()
	{
        $field	= base64_decode('ZG9tYWluX3R5cGU=');
        if($this->getConfig($field) == 1){
            $key		= base64_decode('cHJvZF9saWNlbnNl');
            $this->mode	= base64_decode('cHJvZHVjdGlvbg==');
        }else{
            $key		= base64_decode('ZGV2X2xpY2Vuc2U=');
            $this->mode	= base64_decode('ZGV2ZWxvcG1lbnQ=');
        }
        $this->temp = $this->getConfig($key);
    }

	public function getMessage()
	{
		$message = base64_decode('WW91IGFyZSB1c2luZyB1bmxpY2Vuc2VkIHZlcnNpb24gb2YgJ0N1c3RvbSBMb2dpbiBSZWRpcmVjdCBQcm8nIEV4dGVuc2lvbiBmb3IgZG9tYWluOiB7e0RPTUFJTn19LiBQbGVhc2UgZW50ZXIgYSB2YWxpZCBMaWNlbnNlIEtleSBmcm9tIFN5c3RlbSAmcmFxdW87IENvbmZpZ3VyYXRpb24gJnJhcXVvOyBNYWdlUHN5Y2hvIEV4dGVuc2lvbnMgJnJhcXVvOyBDdXN0b20gTG9naW4gUmVkaXJlY3QgUHJvICZyYXF1bzsgR2VuZXJhbCBTZXR0aW5ncyAmcmFxdW87IExpY2Vuc2UgS2V5LiBJZiB5b3UgZG9uJ3QgaGF2ZSBvbmUsIHBsZWFzZSBwdXJjaGFzZSBhIHZhbGlkIGxpY2Vuc2UgZnJvbSA8YSBocmVmPSJodHRwOi8vd3d3Lm1hZ2Vwc3ljaG8uY29tIiB0YXJnZXQ9Il9ibGFuayI+d3d3Lm1hZ2Vwc3ljaG8uY29tPC9hPiBvciB5b3UgY2FuIGRpcmVjdGx5IGVtYWlsIHRvIDxhIGhyZWY9Im1haWx0bzppbmZvQG1hZ2Vwc3ljaG8uY29tIj5pbmZvQG1hZ2Vwc3ljaG8uY29tPC9hPg==');
		$message = str_replace('{{DOMAIN}}', $this->getDomain(), $message);
		return $message;
	}

	public function getDomain()
	{
        $domain		= Mage::getBaseUrl();
        $baseDomain = Mage::helper('magepsycho_loginredirectpro/url')->getBaseDomain($domain);

		return $baseDomain;
    }

    public function checkEntry($domain, $serial)
	{
        $salt = sha1(base64_decode('bG9naW5yZWRpcmVjdHBybw=='));
        if(sha1($salt . $domain . $this->mode) == $serial) {
            return true;
        }

        return false;
    }

    public function isValid()
	{
        $temp = $this->temp;
        if(!$this->checkEntry($this->getDomain(), $temp)) {
            return false;
        }

        return true;
    }

	public function isActive()
	{
		return (bool) $this->getConfig('active');
	}

    public function getNewAccountEmailTemplate()
    {
        $customerGroupId        = $this->getCurrentCustomerGroup();
        $emailTemplateId		= (int) $this->getConfig('email_account_' . $customerGroupId, 'account_email_template');
        $this->log('$customerGroupId::' . $customerGroupId . ', $emailTemplateId::'.$emailTemplateId);
        return $emailTemplateId;
    }

    public function getNewAccountSuccessMessage()
    {
        $customerGroupId        = $this->getCurrentCustomerGroup();
        $defaultSuccessMessage  = $this->getConfig('success_message_account', 'option', Mage::helper('customer')->__('Thank you for registering with %s.'));
        $successMessage		    =  $this->getConfig('success_message_' . $customerGroupId, 'account_success_message');
        if(empty($successMessage)){
            $successMessage = $defaultSuccessMessage;
        }
        $this->log('$customerGroupId::' . $customerGroupId . ', $successMessage::'.$successMessage);
        return $successMessage;
    }

    public function checkVersion($version, $operator = '>=')
    {
        return version_compare(Mage::getVersion(), $version, $operator);
    }

    public function getExtensionVersion()
    {
        $moduleCode = 'MagePsycho_Loginredirectpro';
        return (string) $currentVer = Mage::getConfig()->getModuleConfig($moduleCode)->version;
    }

    public function loadGeoIp()
    {
        //REF: http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz
        include_once(Mage::getModuleDir('', 'MagePsycho_Loginredirectpro') . DS . 'Model' . DS . 'Api' . DS . 'GeoIP' . DS . 'GeoIP.inc');

        // Open Geo IP binary data file
        $geoIp = geoip_open(Mage::getModuleDir('', 'MagePsycho_Loginredirectpro') . DS . 'Model' . DS . 'Api' . DS . 'GeoIP' . DS . 'GeoIP.dat', GEOIP_STANDARD);

        return $geoIp;
    }

    public function getIpAddress()
    {
        $ip	 = Mage::helper('core/http')->getRemoteAddr();
        return $ip;
    }

    public function getCurrencyCode()
    {
        $geoIp     = $this->loadGeoIp();
        $ipAddress = $this->getIpAddress();

        // get country code from ip address
        $countryCode = geoip_country_code_by_addr($geoIp, $ipAddress);
        return $countryCode;
    }

    public function getCustomerSession()
    {
        return Mage::getSingleton('customer/session');
    }

    public function getRedirectToParam()
    {
        return $this->getConfig('redirect_to_param');
    }
}