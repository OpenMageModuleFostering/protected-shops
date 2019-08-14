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
 * Class NRApps_ProtectedShops_Block_Adminhtml_System_Config_Import
 */
class NRApps_ProtectedShops_Block_Adminhtml_System_Config_Import extends Mage_Adminhtml_Block_System_Config_Form_Field
{


    /**
     * Set template to itself
     *
     * @return Mage_Adminhtml_Block_Customer_System_Config_Validatevat
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('nrapps_protectedshops/import.phtml');
        }

        return $this;
    }


    /**
     * Unset some non-related element parameters
     *
     * @param Varien_Data_Form_Element_Abstract $element
     *
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();

        return parent::render($element);
    }


    /**
     * Get the button and scripts contents
     *
     * @param Varien_Data_Form_Element_Abstract $element
     *
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->addData(array(
            'button_label' => Mage::helper('nrapps_protectedshops')->__('Import Documents'),
            'html_id' => $element->getHtmlId(),
            'ajax_url' => Mage::getSingleton('adminhtml/url')->getUrl('*/nrappsprotectedshops_config/import')
        ));

        return $this->_toHtml();
    }
}
