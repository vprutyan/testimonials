<?php
/**
 * @package   Overdose_Testimonials
 * @author    Vladimir Prutian <vladimir.prutian@gmail.com>
 * @copyright Copyright (c) 2020
 */
namespace Overdose\Testimonials\Api\Data;

/**
 * Testimonials interface.
 */
interface TestimonialsInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    public const ENTITY_ID = 'entity_id';
    public const IMAGE = 'image';
    public const MESSAGE = 'message';
    public const TITLE = 'title';

    /**
     * Get testimonial id
     *
     * @return int|null
     */
    public function getEntityId();

    /**
     * Set testimonial id
     *
     * @param int $id
     * @return $this
     */
    public function setEntityId($id);

    /**
     * Get testimonial image
     *
     * @return string|null
     */
    public function getImage();

    /**
     * Set testimonial image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * Get testimonial title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Set testimonial title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * Get testimonial message
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Set testimonial message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message);
}
