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
 * Class NRApps_ProtectedShops_Helper_Config
 */
class NRApps_ProtectedShops_Helper_Config extends Mage_Core_Helper_Abstract
{


    /**
     * @param null $store
     *
     * @return string
     */
    public function getApiUrl($store = null)
    {
        return trim(Mage::getStoreConfig('nrapps_protectedshops/setting/api_uri', $store));
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getShopId($store = null)
    {
        return trim(Mage::getStoreConfig('nrapps_protectedshops/setting/shop_id', $store));
    }


    /**
     * @param null $store
     *
     * @return array
     */
    public function getMap($store = null)
    {
        $mapping = trim(Mage::getStoreConfig('nrapps_protectedshops/setting/map', $store));
        $mapping = @unserialize($mapping);

        return (array)$mapping;
    }


    /**
     * @param null $store
     *
     * @return bool
     */
    public function isHashValidate($store = null)
    {
        return (bool)Mage::getStoreConfig('nrapps_protectedshops/setting/hash_validate', $store);
    }


    /**
     * @param null $store
     *
     * @return bool
     */
    public function isAutoUpdateIsActive($store = null)
    {
        return (bool)Mage::getStoreConfig('nrapps_protectedshops/auto_update/is_active', $store);
    }


    /**
     * @param null $store
     *
     * @return int
     */
    public function getAutoUpdateInterval($store = null)
    {
        return (int)Mage::getStoreConfig('nrapps_protectedshops/auto_update/interval', $store);
    }


    /**
     * @param null $store
     *
     * @return int
     */
    public function getAutoUpdateErrorEmailThreshold($store = null)
    {
        return (int)Mage::getStoreConfig('nrapps_protectedshops/auto_update/error_email_threshold', $store);
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getAutoUpdateErrorEmailSenderIdentity($store = null)
    {
        return trim(Mage::getStoreConfig('nrapps_protectedshops/auto_update/error_email_sender_identity', $store));
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getAutoUpdateErrorEmailRecipientProtectedShops($store = null)
    {
        return trim(Mage::getStoreConfig('nrapps_protectedshops/auto_update/error_email_recipient_protectedshops', $store));
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getAutoUpdateErrorEmailRecipient($store = null)
    {
        return trim(Mage::getStoreConfig('nrapps_protectedshops/auto_update/error_email_recipient', $store));
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getAutoUpdateErrorEmailTemplate($store = null)
    {
        return trim(Mage::getStoreConfig('nrapps_protectedshops/auto_update/error_email_template', $store));
    }
}
