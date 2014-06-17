<?php
/**
 * @category   MagePsycho
 * @package    MagePsycho_Customerregfields
 * @author     magepsycho@gmail.com
 * @website    http://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagePsycho_Customerregfields_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getConfig($field, $section = 'option', $default = null)
	{
        $value = Mage::getStoreConfig('magepsycho_customerregfields/' .$section .  '/' . $field);
        if(!isset($value) or trim($value) == ''){
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
        Mage::log($separator, null, 'magepsycho_customerregfields.log', true);
        Mage::log($data, null, 'magepsycho_customerregfields.log', true);
    }

	public function checkVersion($version, $operator = '>=')
	{
		return version_compare(Mage::getVersion(), $version, $operator);
	}

    public function getExtensionVersion()
    {
        $moduleCode = 'MagePsycho_Customerregfields';
        return (string) $currentVer = Mage::getConfig()->getModuleConfig($moduleCode)->version;
    }

	public function getCustomerGroups()
	{
        $customer_groups = Mage::getResourceModel('customer/group_collection')
                ->setRealGroupsFilter()
                ->loadData()
                ->toOptionArray();
        return $customer_groups;
    }

	public function getCustomerGroupSelectHtml($name, $selectedValue = '', $class = '')
	{
		$allowedCustomerGroup = $this->getConfig('allowed_customer_groups');
		if($allowedCustomerGroup == -1){
			$groupOptions	= $this->getCustomerGroups();
		}else{
			$dbGroups		= explode(',', $allowedCustomerGroup);
			$groupOptions	= array();
			foreach($dbGroups as $_groupId) {
				$data  = Mage::getModel('customer/group')->load($_groupId);
				$label = $data['customer_group_code'];
				$groupOptions[] = array(
					'value'   => $_groupId,
					'label'   => $label,
				);
			}
		}

		array_unshift($groupOptions, array('label' => '', 'value' => ''));
		$this->sortArray($groupOptions, 'label');

        $select			=  Mage::app()->getLayout()->createBlock('core/html_select');
        return  $select ->setAttribute('name', $name)
                ->setId($name)
                ->setClass($class)
                ->setOptions($groupOptions)
                ->setValue($selectedValue)
                //->setExtraParams($extraParams)
                ->toHtml();
    }

	function sortArray(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}

		array_multisort($sort_col, $dir, $arr);
	}
}