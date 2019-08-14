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
 * Class NRApps_ProtectedShops_Block_Adminhtml_System_Config_Form_Field_Map
 */
class NRApps_ProtectedShops_Block_Adminhtml_System_Config_Form_Field_Map extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{


    /**
     *
     */
    public function __construct()
    {
        /** @var $helper NRApps_ProtectedShops_Helper_Data */
        $helper = Mage::helper('nrapps_protectedshops');

        $this->addColumn('document', array(
            'label' => Mage::helper('nrapps_protectedshops')->__('Document'),
            'style' => 'width:250px',
            'renderer' => Mage::app()->getLayout()->createBlock('nrapps_protectedshops/adminhtml_system_config_form_renderer_select')->setOptions($helper->getDocumentOptions()),
        ));

        $this->addColumn('destination', array(
            'label' => Mage::helper('nrapps_protectedshops')->__('Destination'),
            'style' => 'width:250px',
            'renderer' => Mage::app()->getLayout()->createBlock('nrapps_protectedshops/adminhtml_system_config_form_renderer_selectGroup')->setOptions($helper->getDestinationOptions()),
        ));

        $this->addColumn('format', array(
            'label' => Mage::helper('nrapps_protectedshops')->__('Format'),
            'style' => 'width:150px',
            'renderer' => Mage::app()->getLayout()->createBlock('nrapps_protectedshops/adminhtml_system_config_form_renderer_select')->setOptions($helper->getFormatOptions()),
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('nrapps_protectedshops')->__('Add Row');

        parent::__construct();
    }


    /**
     * @return array
     */
    public function getArrayRows()
    {
        if (null !== $this->_arrayRowsCache) {
            return $this->_arrayRowsCache;
        }

        $result = array();

        /** @var Varien_Data_Form_Element_Abstract */
        $element = $this->getElement();

        if ($element->getValue() && is_array($element->getValue())) {

            foreach ($element->getValue() as $rowId => $row) {

                foreach ($row as $key => $value) {

                    if ($key == 'document') {
                        $row['document_' . $value] = 'selected="selected"';
                    } else if ($key == 'destination') {
                        $row['destination_' . $value] = 'selected="selected"';
                    } elseif ($key == 'format') {
                        $row['format_' . $value] = 'selected="selected"';
                    }
                }

                $row['_id'] = $rowId;
                $result[$rowId] = new Varien_Object($row);
            }
        }

        $this->_arrayRowsCache = $result;

        return $this->_arrayRowsCache;
    }
}
