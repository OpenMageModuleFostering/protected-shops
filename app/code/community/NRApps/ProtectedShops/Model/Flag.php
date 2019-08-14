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
 * Class NRApps_ProtectedShops_Model_Flag
 */
class NRApps_ProtectedShops_Model_Flag
{


    /**
     * @var Mage_Core_Model_Flag
     */
    protected $_flag;

    /**
     * @var array
     */
    protected $_flagData;


    /**
     *
     */
    public function __construct()
    {
        $this->_flag = Mage::getModel('core/flag', array('flag_code' => 'nrapps_protectedshops'));
        $this->_flag->loadSelf();

        $this->_flagData = (array)$this->_flag->getFlagData();
    }


    /**
     *
     */
    public function __destruct()
    {
        $this->_flag->setFlagData($this->_flagData);
        $this->_flag->save();
    }


    /**
     * @param string $key
     * @param mixed $value
     */
    public function setFlag($key, $value)
    {
        $this->_flagData[(string)$key] = $value;
    }


    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getFlag($key)
    {
        if (array_key_exists((string)$key, $this->_flagData)) {
            return $this->_flagData[(string)$key];
        }

        return null;
    }


    /**
     * @param array $documents
     *
     * @return $this
     */
    public function setDocuments(array $documents)
    {
        $this->setFlag('documents', $documents);

        return $this;
    }


    /**
     * @return array
     */
    public function getDocuments()
    {
        return (array)$this->getFlag('documents');
    }


    /**
     * @return int
     */
    public function getErrorCount()
    {
        return $this->getFlag('error_count') ? (int)$this->getFlag('error_count') : 0;
    }


    /**
     * @return $this
     */
    public function incrementErrorCount()
    {
        $this->setFlag('error_count', $this->getErrorCount() + 1);

        return $this;
    }


    /**
     * @return $this
     */
    public function unsetErrorCount()
    {
        $this->setFlag('error_count', 0);

        return $this;
    }


    /**
     * @param $time
     *
     * @return $this
     */
    public function setScheduleTime($time)
    {
        $this->setFlag('schedule_time', (int)$time);

        return $this;
    }


    /**
     * @return int
     */
    public function getScheduleTime()
    {
        return $this->getFlag('schedule_time') ? (int)$this->getFlag('schedule_time') : 0;
    }
}
