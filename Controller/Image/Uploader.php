<?php
/**
 * @package   Overdose_Testimonials
 * @author    Vladimir Prutian <vladimir.prutian@gmail.com>
 * @copyright Copyright (c) 2020
 */
namespace Overdose\Testimonials\Controller\Image;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Overdose\Testimonials\Model\Upload\ImageFileUploader;

class Uploader extends Action
{
    /**
     * @var ImageFileUploader
     */
    private $imageFileUploader;

    /**
     * @param Context $context
     * @param ImageFileUploader $imageFileUploader
     */
    public function __construct(
        Context $context,
        ImageFileUploader $imageFileUploader

    ) {
        $this->imageFileUploader = $imageFileUploader;
        parent::__construct($context);

    }

    /**
     * Image upload action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $imageUploadId = $this->getRequest()->getParam('param_name', 'testimonials_image');
        $result = $this->imageFileUploader->saveImageToMediaFolder($imageUploadId);
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
