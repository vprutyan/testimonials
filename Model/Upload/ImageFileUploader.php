<?php
/**
 * @package   Overdose_Testimonials
 * @author    Vladimir Prutian <vladimir.prutian@gmail.com>
 * @copyright Copyright (c) 2020
 */
namespace  Overdose\Testimonials\Model\Upload;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Image File Upload class
 */
class ImageFileUploader
{
    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var array
     */
    private $allowedExtensions = ['jpeg', 'gif', 'png'];

    /**
     * @var array
     */
    private $maxFileSize = '1024';

    /**
     * @var string
     */
    const FILE_DIR = 'testimonials/images';

    /**
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager
    ) {
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
    }

    /**
     * Save file to temp media directory
     *
     * @param string $fileId
     * @return array
     * @throws LocalizedException
     */
    public function saveImageToMediaFolder($fileId)
    {
        try {
            $result = ['file' => '', 'size' => ''];
            /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
            $mediaDirectory = $this->filesystem
                ->getDirectoryRead(DirectoryList::MEDIA)
                ->getAbsolutePath(self::FILE_DIR);
            /** @var \Magento\MediaStorage\Model\File\Uploader $uploader */
            $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);
            $uploader->setAllowedExtensions($this->allowedExtensions);
            $uploader->addValidateCallback('size', $this, 'validateMaxSize');
            $result = array_intersect_key($uploader->save($mediaDirectory), $result);

            $result['url'] = $this->getMediaUrl($result['file']);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $result;
    }

    /**
     * Validation callback for checking max file size
     *
     * @param  string $filePath Path to temporary uploaded file
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validateMaxSize($filePath)
    {
        $directory = $this->filesystem->getDirectoryRead(DirectoryList::SYS_TMP);
        if ($directory->stat($directory->getRelativePath($filePath))['size'] > $this->maxFileSize * 1024) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The file you\'re uploading exceeds the server size limit of %1 kilobytes.', $this->maxFileSize)
            );
        }
    }

    /**
     * Get file url
     *
     * @param string $file
     * @return string
     */
    public function getMediaUrl($file)
    {
        $file = ltrim(str_replace('\\', '/', $file), '/');
        return $this->storeManager
                ->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . self::FILE_DIR . '/' . $file;
    }
}
