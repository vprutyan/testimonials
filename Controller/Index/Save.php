<?php
/**
 * @package   Overdose_Testimonials
 * @author    Vladimir Prutian <vladimir.prutian@gmail.com>
 * @copyright Copyright (c) 2020
 */
namespace Overdose\Testimonials\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Overdose\Testimonials\Model\TestimonialsFactory;
use Overdose\Testimonials\Api\TestimonialsRepositoryInterface;

class Save extends Action
{
    /**
     * @var TestimonialsFactory
     */
    protected $testimonialsFactory;

    /**
     * @var TestimonialsRepositoryInterface
     */
    protected $testimonialsRepository;

    /**
     * @param Context $context
     * @param TestimonialsFactory $testimonialsFactory
     * @param TestimonialsRepositoryInterface $testimonialsRepository
     */
    public function __construct(
        Context $context,
        TestimonialsFactory $testimonialsFactory,
        TestimonialsRepositoryInterface $testimonialsRepository

    ) {
        $this->testimonialsFactory = $testimonialsFactory;
        $this->testimonialsRepository = $testimonialsRepository;
        parent::__construct($context);

    }

    /**
     * Save testimonial action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $result = [];
        if ($data) {
            $testimonialId = $this->getRequest()->getParam('entity_id');
            try {
                if ($testimonialId) {
                    $testimonial = $this->testimonialsRepository->getById($testimonialId);
                } else {
                    $testimonial = $this->testimonialsFactory->create();
                }
                $testimonial->setTitle($data['testimonials_title']);
                $testimonial->setMessage($data['testimonials_message']);
                if (isset($data['testimonials_image'][0]['file'])) {
                    $testimonial->setImage($data['testimonials_image'][0]['file']);
                }
                $this->testimonialsRepository->save($testimonial);
                $result = ['error' => false];

            } catch (\Exception $e) {
                $result = ['errorMessage' => $e->getMessage(), 'error' => true];
            }
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
