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
 * Class NRApps_ProtectedShops_Model_Cron
 */
class NRApps_ProtectedShops_Model_Cron extends NRApps_ProtectedShops_Model_Api
{


    /**
     *
     */
    const FUZZY_TIME = 300;


    /**
     * @param Mage_Cron_Model_Schedule $cron
     *
     * @return $this
     */
    public function scheduling(Mage_Cron_Model_Schedule $cron)
    {
        if ($this->_config->isAutoUpdateIsActive()) {

            if ($this->_flag->getErrorCount() || time() > $this->_getScheduleTime()) {

                $this->_flag->setScheduleTime(time());

                if ($error = $this->import()) {

                    $cron->setMessages(implode("\n", $error));

                    $this->_flag->incrementErrorCount();

                    if ($this->_flag->getErrorCount() >= $this->_config->getAutoUpdateErrorEmailThreshold()) {

                        $this->_sendErrorMessage($error);
                    }

                } else {
                    $this->_flag->unsetErrorCount();
                }
            }
        }

        return $this;
    }


    /**
     * @return int
     */
    protected function _getScheduleTime()
    {
        return $this->_config->getAutoUpdateInterval() * 60 * 60 + $this->_flag->getScheduleTime() - self::FUZZY_TIME;
    }


    /**
     * @param $error
     */
    protected function _sendErrorMessage($error)
    {
        $emailTo = array(
            $this->_config->getAutoUpdateErrorEmailRecipientProtectedShops(),
            $this->_config->getAutoUpdateErrorEmailRecipient(),
        );

        $templateId = $this->_config->getAutoUpdateErrorEmailTemplate();
        $sender = $this->_config->getAutoUpdateErrorEmailSenderIdentity();

        /** @var $emailTemplate Mage_Core_Model_Email_Template */
        $emailTemplate = Mage::getModel('core/email_template');

        foreach ($emailTo as $email) {

            if ($email) {

                $emailTemplate->setDesignConfig(array('area' => 'adminhtml', 'store' => Mage_Core_Model_App::ADMIN_STORE_ID));
                $emailTemplate->sendTransactional(
                    $templateId,
                    $sender,
                    $email,
                    null,
                    array('error' => implode("\n", (array)$error)),
                    Mage_Core_Model_App::ADMIN_STORE_ID
                );
            }
        }
    }
}
