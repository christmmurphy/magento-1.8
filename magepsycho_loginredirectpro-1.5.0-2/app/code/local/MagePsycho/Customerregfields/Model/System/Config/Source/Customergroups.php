<?php
/**
 * @category   MagePsycho
 * @package    MagePsycho_Customerregfields
 * @author     magepsycho@gmail.com
 * @website    http://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagePsycho_Customerregfields_Model_System_Config_Source_Customergroups
{

    public function toOptionArray()
	{
		$options = array();
		$options[] = array(
			'label' => Mage::helper('magepsycho_customerregfields')->__('All Customer Groups'),
			'value' => -1
		);

		$options[] = array(
			'label' => Mage::helper('magepsycho_customerregfields')->__('Customer Group'),
			'value' => array()
		);

        $nonEscapableNbspChar = html_entity_decode('&#160;', ENT_NOQUOTES, 'UTF-8');

		$customerGroups = Mage::getResourceModel('customer/group_collection')
                ->setRealGroupsFilter()
                ->loadData()
                ->toOptionArray();

        foreach ($customerGroups as $_customerGroup) {
			$options[] = array(
				'label' => str_repeat($nonEscapableNbspChar, 4) . $_customerGroup['label'],
				'value' => $_customerGroup['value']
			);
        }
        return $options;
    }
}