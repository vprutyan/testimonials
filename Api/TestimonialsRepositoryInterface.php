<?php
/**
 * @package   Overdose_Testimonials
 * @author    Vladimir Prutian <vladimir.prutian@gmail.com>
 * @copyright Copyright (c) 2020
 */
namespace Overdose\Testimonials\Api;

use Overdose\Testimonials\Api\Data\TestimonialsInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\State\InputMismatchException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Overdose\Testimonials\Api\Data\TestimonialsSearchResultsInterface;

/**
 * Testimonials CRUD interface.
 */
interface TestimonialsRepositoryInterface
{
    /**
     * Create or update a testimonial.
     *
     * @param TestimonialsInterface $testimonial
     * @return TestimonialsInterface
     * @throws InputException
     * @throws InputMismatchException
     * @throws LocalizedException
     */
    public function save(TestimonialsInterface $testimonial);

    /**
     * Get testimonial by testimonial ID.
     *
     * @param int $testimonialId
     * @return TestimonialsInterface
     * @throws NoSuchEntityException If customer with the specified ID does not exist.
     * @throws LocalizedException
     */
    public function getById($testimonialId);

    /**
     * Retrieve testimonials which match a specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return TestimonialsSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete testimonial.
     *
     * @param TestimonialsInterface $testimonial
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(TestimonialsInterface $testimonial);

    /**
     * Delete testimonial by testimonial ID.
     *
     * @param int $testimonialId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($testimonialId);
}
