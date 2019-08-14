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
 * Class NRApps_ProtectedShops_Adminhtml_Nrappsprotectedshops_ConfigController
 */
class NRApps_ProtectedShops_Adminhtml_Nrappsprotectedshops_ConfigController extends Mage_Adminhtml_Controller_Action
{


    /**
     * Insert legislative texts
     *
     * @return void
     */
    public function importAction()
    {
        try {
            $errors = Mage::getModel('nrapps_protectedshops/api')->import();

            if ($errors) {

                foreach ($errors as $error) {
                    Mage::getSingleton('adminhtml/session')->addError($error);
                }
            } else {

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('nrapps_protectedshops')->__('Import legal text success'));
            }
        } catch (Exception $e) {

            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('nrapps_protectedshops')->__(Mage::helper('nrapps_protectedshops')->__($e->getMessage())));
        }

        $this->_redirect('adminhtml/system_config/edit', array('section' => 'nrapps_protectedshops'));
    }


    /**
     * Insert legislative texts
     *
     * @return void
     */
    public function infoAction()
    {
        try {
            $info = Mage::getModel('nrapps_protectedshops/api')->info();

            if ($info['error']) {

                foreach ($info['error'] as $error) {
                    Mage::getSingleton('adminhtml/session')->addError($error);
                }
            } else {

                foreach ($info['info'] as $info) {
                    Mage::getSingleton('adminhtml/session')->addNotice($info);
                }
            }
        } catch (Exception $e) {

            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('nrapps_protectedshops')->__($e->getMessage()));
        }

        $this->_redirect('adminhtml/system_config/edit', array('section' => 'nrapps_protectedshops'));
    }
}
