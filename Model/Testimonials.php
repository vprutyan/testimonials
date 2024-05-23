<?php
/**
 * @package   Overdose_Testimonials
 * @author    Vladimir Prutian <vladimir.prutian@gmail.com>
 * @copyright Copyright (c) 2020
 */
namespace Overdose\Testimonials\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Overdose\Testimonials\Api\Data\TestimonialsInterface;

/**
 * Testimonials model class
 */
class Testimonials extends \Magento\Framework\Model\AbstractModel implements TestimonialsInterface, IdentityInterface
{
    /**
     * Testimonials cache tag
     */
    protected const CACHE_TAG = 'customer_testimonials';

    /**
     * @var string
     */
    protected $_cacheTag = 'customer_testimonials';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'customer_testimonials';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Overdose\Testimonials\Model\ResourceModel\Testimonials');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getEntityId()];
    }


    /**
     * Get ID
     *
     * @return int|null
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set ID
     *
     * @param int $entityId
     * @return TestimonialsInterface
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Set image
     *
     * @param string $image
     * @return TestimonialsInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return TestimonialsInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set message
     *
     * @param string $message
     * @return TestimonialsInterface
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * Get message
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }
}
