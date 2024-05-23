<?php
/**
 * @package   Overdose_Testimonials
 * @author    Vladimir Prutian <vladimir.prutian@gmail.com>
 * @copyright Copyright (c) 2020
 */
namespace Overdose\Testimonials\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Exception\LocalizedException;

/**
 * Testimonials mysql resource
 */
class Testimonials extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('overdose_testimonials', 'entity_id');
    }

    /**
     * Process testimonials data before saving
     *
     * @param AbstractModel $testimonial
     * @return $this
     * @throws LocalizedException
     */
    protected function _beforeSave(AbstractModel $testimonial)
    {

        if (!$this->isValidTestimonialMessage($testimonial)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The Testimonial message is empty or contains disallowed symbols.')
            );
        }

        return parent::_beforeSave($testimonial);
    }

    /**
     *  Check whether testimonial message is alphanumeric
     *
     * @param AbstractModel $testimonial
     * @return bool
     */
    protected function isValidTestimonialMessage(AbstractModel $testimonial)
    {
        $message = $testimonial->getMessage();
        return ctype_alnum($message) && !empty($message);
    }
}
