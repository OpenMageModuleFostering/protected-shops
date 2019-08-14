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
 * Class NRApps_ProtectedShops_Model_Api
 */
class NRApps_ProtectedShops_Model_Api
{


    /**
     * @var NRApps_ProtectedShops_Helper_Data
     */
    protected $_helper;

    /**
     * @var NRApps_ProtectedShops_Helper_Config
     */
    protected $_config;

    /**
     * @var NRApps_ProtectedShops_Model_Flag
     */
    protected $_flag;


    /**
     *
     */
    public function __construct()
    {
        $this->_helper = Mage::helper('nrapps_protectedshops/data');
        $this->_config = Mage::helper('nrapps_protectedshops/config');
        $this->_flag = Mage::getModel('nrapps_protectedshops/flag');
    }


    /**
     * @return array
     */
    public function info()
    {
        $documentInfoShop = array(
            'error' => array(),
            'info' => array(),
        );

        try {
            foreach ($this->_getDocumentInfoMap() as $shopId) {

                $documentInfoShop['info'][] = $this->_helper->__('Document Info for Shop Id: %s', $shopId);

                try {

                    foreach ($this->_getDocumentInfo($shopId) as $documentType => $documentDate) {

                        $documentInfoShop['info'][] = $this->_helper->__('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%s: %s', $documentType, $documentDate);
                    }


                } catch (Exception $e) {
                    $documentInfoShop['error'][$e->getMessage()] = $e->getMessage();
                }
            }

        } catch (Exception $e) {
            $documentInfoShop['error'][$e->getMessage()] = $e->getMessage();
        }

        return $documentInfoShop;
    }


    /**
     * @return array
     */
    public function import()
    {
        $error = array();

        try {
            foreach ($this->_getDocumentMap() as $map) {

                try {
                    $document = $this->_getDocument($map['shop_id'], $map['document'], $map['format']);

                    foreach ($map['destination'] as $destination) {

                        try {
                            $this->_updateDestination($destination, $document);
                        } catch (Exception $e) {
                            $error[$e->getMessage()] = $e->getMessage();
                        }
                    }

                } catch (Exception $e) {
                    $error[$e->getMessage()] = $e->getMessage();
                }
            }

        } catch (Exception $e) {
            $error[$e->getMessage()] = $e->getMessage();
        }

        return $error;
    }


    /**
     * @return array
     */
    private function _getDocumentMap()
    {
        $mapList = array();

        foreach (Mage::app()->getStores() as $store) {

            $shopId = $this->_config->getShopId($store);

            if ($shopId) {
                foreach ($this->_config->getMap($store) as $mapLine) {

                    $map = array(
                        'shop_id' => $shopId,
                        'document' => $mapLine['document'],
                        'format' => $mapLine['format']
                    );

                    $mapKey = implode('|', $map);

                    if (!array_key_exists($mapKey, $mapList)) {
                        $mapList[$mapKey] = $map;
                    }

                    $mapList[$mapKey]['destination'][$mapLine['destination']] = $mapLine['destination'];
                }
            }
        }

        if (!$mapList) {
            Mage::throwException($this->_helper->__('Configuration not completed.'));
        }

        return $mapList;
    }


    /**
     * @return array
     */
    private function _getDocumentInfoMap()
    {
        $mapList = array();

        foreach (Mage::app()->getStores() as $store) {

            if ($shopId = $this->_config->getShopId($store)) {
                $mapList[$shopId] = $shopId;
            }
        }

        if (!$mapList) {
            Mage::throwException($this->_helper->__('Configuration not completed.'));
        }

        return $mapList;
    }


    /**
     * @param string $shopId
     * @param string $document
     * @param string $format
     *
     * @return string
     * @throws Exception
     */
    protected function _getDocument($shopId, $document, $format)
    {
        $apiUrl = sprintf('%s?Request=GetDocument&ShopId=%s&Document=%s&Format=%s', $this->_config->getApiUrl(), $shopId, $document, $format);
        $client = new Zend_Http_Client($apiUrl);
        $response = $client->request();

        if ($response->getStatus() != 200) {
            Mage::throwException($this->_helper->__('API Response Status Error'));
        }

        if ($response->getHeader('Content-type') != 'text/xml') {
            Mage::throwException($this->_helper->__('API Response Content Type Error'));
        }

        $documentData = simplexml_load_string($response->getBody());

        if ($documentData->error) {
            Mage::throwException((string)$documentData->error->msg);
        }

        if ($this->_config->isHashValidate() && md5((string)$documentData->Document) != (string)$documentData->MD5) {
            Mage::throwException($this->_helper->__('API Response Document Hash Error %s - %s.', (string)$documentData->MD5, md5((string)$documentData->Document)));
        }

        return (string)$documentData->Document;
    }


    /**
     * @param $shopId
     *
     * @return string
     */
    protected function _getDocumentInfo($shopId)
    {
        $apiUrl = sprintf('%s?Request=GetDocumentInfo&ShopId=%s&', $this->_config->getApiUrl(), $shopId);
        $client = new Zend_Http_Client($apiUrl);
        $response = $client->request();

        if ($response->getStatus() != 200) {
            Mage::throwException($this->_helper->__('API Response Status Error'));
        }

        if ($response->getHeader('Content-type') != 'text/xml') {
            Mage::throwException($this->_helper->__('API Response Content Type Error'));
        }

        $documentData = simplexml_load_string($response->getBody());

        if ($documentData->error) {
            Mage::throwException((string)$documentData->error->msg);
        }

        $this->_flag->setDocuments(array_keys((array)$documentData->DocumentDate));

        return (array)$documentData->DocumentDate;
    }


    /**
     * @param string $destination
     * @param string $content
     *
     * @return $this
     */
    protected function _updateDestination($destination, $content)
    {
        $destination = explode('#', $destination);
        $modelClass = array_shift($destination);
        $entityId = array_shift($destination);

        $model = Mage::getModel($modelClass);
        $model->load($entityId);

        if ($model->getId()) {
            if ($modelClass == 'cms/page') {
                $model->setData('content', $content);
                $model->setData('stores', $model->getData('store_id'));
                $model->save();
            } elseif ($modelClass == 'cms/block') {
                $model->setData('content', $content);
                $model->save();
            } elseif ($modelClass == 'checkout/agreement') {
                $model->setData('content', $content);
                $model->save();
            } else {
                Mage::throwException($this->_helper->__('Unknown model: "%s"', $model));
            }
        } else {
            Mage::throwException($this->_helper->__('Unknown model entity: "%s" (%s)', $entityId, $model));
        }

        return $this;
    }
}
