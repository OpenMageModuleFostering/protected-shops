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
 * Class NRApps_ProtectedShops_Helper_Data
 */
class NRApps_ProtectedShops_Helper_Data extends Mage_Core_Helper_Abstract
{


    /**
     * @return array
     */
    public function getDocumentOptions()
    {

        $documents = Mage::getModel('nrapps_protectedshops/flag')->getDocuments();

        if ($documents) {
            return array_combine($documents, $documents);
        }

        return $documents;
    }


    /**
     * @return array
     */
    public function getFormatOptions()
    {
        return array(
            'Html' => $this->__('HTML'),
            'HtmlLite' => $this->__('HTML-Lite'),
            'Text' => $this->__('Text'),
            //'Pdf' => $this->__('PDF'),
        );
    }


    /**
     * @return array
     */
    public function getDestinationOptions()
    {
        $options = array();

        $options['cms_page'] = array('label' => $this->__('CMS Pages'));

        foreach (Mage::getResourceModel('cms/page_collection')->setOrder('page_id', 'ASC') as $item) {
            $options['cms_page']['value'][] = array(
                'label' => sprintf('%s | %s', $item->getId(), $item->getTitle()),
                'value' => sprintf('cms/page#%s', $item->getId()),
            );
        }

        $options['cms_block'] = array('label' => $this->__('CMS Blocks'));

        foreach (Mage::getResourceModel('cms/block_collection')->setOrder('block_id', 'ASC') as $item) {
            $options['cms_block']['value'][] = array(
                'label' => sprintf('%s | %s', $item->getId(), $item->getTitle()),
                'value' => sprintf('cms/block#%s', $item->getId()),
            );
        }

        $options['agreement'] = array('label' => $this->__('Agreements'));

        foreach (Mage::getResourceModel('checkout/agreement_collection')->setOrder('agreement_id', 'ASC') as $item) {
            $options['agreement']['value'][] = array(
                'label' => sprintf('%s | %s', $item->getId(), $item->getName()),
                'value' => sprintf('checkout/agreement#%s', $item->getId()),
            );
        }

        return $options;
    }
}
