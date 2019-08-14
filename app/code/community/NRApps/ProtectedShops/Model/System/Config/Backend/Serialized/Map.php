<?php
/**
 * @category   NRApps
 * @package    NRApps_ProtectedShops
 * @copyright  Copyright (c) 2014 integer_net GmbH (http://www.integer-net.de/)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 * @author     nr-apps.com (http://www.nr-apps.com/) powered by integer_net GmbH
 * @author     Viktor Franz <vf@integer-net.de>
 */


/**
 * Class NRApps_ProtectedShops_Model_System_Config_Backend_Serialized_Map
 */
class NRApps_ProtectedShops_Model_System_Config_Backend_Serialized_Map extends Mage_Adminhtml_Model_System_Config_Backend_Serialized
{


    /**
     *
     */
    protected function _beforeSave()
    {
        $value = $this->getValue();
        $valueSorted = array();

        if (is_array($value)) {

            foreach (array_keys(Mage::helper('nrapps_protectedshops')->getDocumentOptions()) as $legalText) {

                foreach ($value as $key => $row) {

                    if (is_array($row) && array_key_exists('document', $row) && $row['document'] == $legalText) {
                        $valueSorted[$key] = $row;
                    }
                }
            }
        }

        $this->setValue($valueSorted);

        parent::_beforeSave();
    }
}
