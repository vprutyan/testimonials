<?php
/**
 * @package   Overdose_Testimonials
 * @author    Vladimir Prutian <vladimir.prutian@gmail.com>
 * @copyright Copyright (c) 2020
 */
namespace Overdose\Testimonials\Api\Data;

/**
 * Interface for testimonials search results.
 */
interface TestimonialsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get list of testimonials.
     *
     * @return TestimonialsInterface[]
     */
    public function getItems();

    /**
     * Set testimonials list.
     *
     * @param TestimonialsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
