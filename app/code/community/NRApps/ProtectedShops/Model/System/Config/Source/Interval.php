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
 * Class NRApps_ProtectedShops_Model_System_Config_Source_Interval
 */
class NRApps_ProtectedShops_Model_System_Config_Source_Interval
{


    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 6, 'label' => Mage::helper('nrapps_protectedshops')->__('6 Hours')),
            array('value' => 12, 'label' => Mage::helper('nrapps_protectedshops')->__('12 Hours')),
            array('value' => 24, 'label' => Mage::helper('nrapps_protectedshops')->__('24 Hours')),
        );
    }


    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            6 => Mage::helper('nrapps_protectedshops')->__('6 Hours'),
            12 => Mage::helper('nrapps_protectedshops')->__('12 Hours'),
            24 => Mage::helper('nrapps_protectedshops')->__('24 Hours'),
        );
    }
}
