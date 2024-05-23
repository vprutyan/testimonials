<?php
/**
 * @package   Overdose_Testimonials
 * @author    Vladimir Prutian <vladimir.prutian@gmail.com>
 * @copyright Copyright (c) 2020
 */

namespace Overdose\Testimonials\Model\ResourceModel\Testimonials;

/**
 * Testimonials collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Overdose\Testimonials\Model\Testimonials', 'Overdose\Testimonials\Model\ResourceModel\Testimonials');
    }

}
