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
 * Class NRApps_ProtectedShops_Block_Adminhtml_System_Config_Form_Renderer_SelectGroup
 */
class NRApps_ProtectedShops_Block_Adminhtml_System_Config_Form_Renderer_SelectGroup extends Mage_Core_Block_Abstract
{


    /**
     * @return string
     */
    protected function _toHtml()
    {
        $column = $this->getColumn();
        $options = '';

        foreach ($this->getOptions() as $value) {
            if (is_array($value) && array_key_exists('label', $value) && array_key_exists('value', $value)) {

                if (is_array($value['value'])) {
                    $options .= '<optgroup label="' . $value['label'] . '">';
                    foreach ($value['value'] as $subValue) {
                        $options .= '<option #{' . $this->getColumnName() . '_' . $subValue['value'] . '} value="' . $subValue['value'] . '">' . $subValue['label'] . '</option>';
                    }
                    $options .= '</optgroup>';
                } else {
                    $options .= '<option #{' . $this->getColumnName() . '_' . $value['value'] . '} value="' . $value['value'] . '">' . $value['label'] . '</option>';
                }
            }
        }

        return '<select class="select" name="' . $this->getInputName() . '"' . (isset($column['style']) ? ' style="' . $column['style'] . '"' : '') . '>' . $options . '</select>';
    }
}
