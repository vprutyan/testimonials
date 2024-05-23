<?php
/**
 * @package   Overdose_Testimonials
 * @author    Vladimir Prutian <vladimir.prutian@gmail.com>
 * @copyright Copyright (c) 2020
 */
namespace Overdose\Testimonials\Ui\Component\Testimonials;

use Overdose\Testimonials\Model\ResourceModel\Testimonials\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    // @codingStandardsIgnoreStart
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $testimonialsCollectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $testimonialsCollectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    // @codingStandardsIgnoreEnd

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $testimonial) {

            $testimonialData = $testimonial->getData();
            if (isset($testimonialData['image'])) {
                $testimonialData['image'] = [
                    [
                        'name' => $testimonialData['image'],
                        'url' => $this->storeManager->getStore()
                                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) .
                                'testimonials/image' . '/' . $testimonialData['image'],
                    ],
                ];
            } else {
                $testimonialData['image'] = null;
            }

            $this->loadedData[$testimonial->getEntityId()] = $testimonialData;

        }
        return $this->loadedData;
    }
}
