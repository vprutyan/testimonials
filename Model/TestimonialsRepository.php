<?php
/**
 * @package   Overdose_Testimonials
 * @author    Vladimir Prutian <vladimir.prutian@gmail.com>
 * @copyright Copyright (c) 2020
 */
namespace Overdose\Testimonials\Model;

use Overdose\Testimonials\Api\Data;
use Overdose\Testimonials\Api\TestimonialsRepositoryInterface;
use Overdose\Testimonials\Api\Data\TestimonialsInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Overdose\Testimonials\Api\Data\TestimonialsSearchResultsInterface;
use Overdose\Testimonials\Model\ResourceModel\Testimonials as ResourceTestimonials;
use Overdose\Testimonials\Model\ResourceModel\Testimonials\CollectionFactory as TestimonialsCollectionFactory;

/**
 * Class TestimonialsRepositoryInterface
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class TestimonialsRepository implements TestimonialsRepositoryInterface
{
    /**
     * @var ResourceTestimonials
     */
    protected $resource;

    /**
     * @var TestimonialsFactory
     */
    protected $testimonialFactory;

    /**
     * @var TestimonialsCollectionFactory
     */
    protected $testimonialCollectionFactory;

    /**
     * @var Data\TestimonialsSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Overdose\Testimonials\Api\Data\TestimonialsInterfaceFactory
     */
    protected $dataTestimonialsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceTestimonials $resource
     * @param TestimonialsFactory $testimonialFactory
     * @param Data\TestimonialsInterfaceFactory $dataTestimonialsFactory
     * @param TestimonialsCollectionFactory $testimonialCollectionFactory
     * @param Data\TestimonialsSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param CollectionProcessorInterface $collectionProcessor
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        ResourceTestimonials $resource,
        TestimonialsFactory $testimonialFactory,
        Data\TestimonialsInterfaceFactory $dataTestimonialFactory,
        TestimonialsCollectionFactory $testimonialCollectionFactory,
        Data\TestimonialsSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->testimonialFactory = $testimonialFactory;
        $this->testimonialCollectionFactory = $testimonialCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataTestimonialFactory = $dataTestimonialFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * Save testimonial data
     *
     * @param TestimonialsInterface $testimonial
     * @return TestimonialsInterface
     * @throws CouldNotSaveException
     */
    public function save(TestimonialsInterface $testimonial)
    {
        try {
            $this->resource->save($testimonial);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the testimonials: %1', $exception->getMessage()),
                $exception
            );
        }
        return $testimonial;
    }

    /**
     * Load Testimonial data by given Testimonial Identity
     *
     * @param int $testimonialId
     * @return TestimonialsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($testimonialId)
    {
        $testimonial = $this->testimonialFactory->create();
        $testimonial->load($testimonialId);
        if (!$testimonial->getId()) {
            throw new NoSuchEntityException(__('The Testimonial with the "%1" ID doesn\'t exist.', $testimonialId));
        }

        return $testimonial;
    }

    /**
     * Load testimonial data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return TestimonialsSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Overdose\Testimonials\Model\ResourceModel\Testimonials\Collection $collection */
        $collection = $this->testimonialCollectionFactory->create();

        //$this->collectionProcessor->process($criteria, $collection);

        /** @var Data\TestimonialsSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete Testimonial
     *
     * @param TestimonialsInterface $testimonial
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(TestimonialsInterface $testimonial)
    {
        try {
            $this->resource->delete($testimonial);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the testimonial: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Delete Testimonial by given Testimonial Identity
     *
     * @param int $testimonialId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($testimonialId)
    {
        return $this->delete($this->getById($testimonialId));
    }
}
