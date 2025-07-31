<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use GuzzleHttp\Client;
use Imponeer\Properties\AbstractType;
use Imponeer\Properties\Exceptions\BadStatusCode;
use Imponeer\Properties\Exceptions\FileTooBigException;
use Imponeer\Properties\Exceptions\ImageWidthTooBigException;
use Imponeer\Properties\Exceptions\MimeTypeIsNotAllowedException;
use Intervention\Image\ImageManager;
use Psr\Http\Message\ResponseInterface;

/**
 * Defines File type
 *
 * @package Imponeer\Properties\Types
 */
class FileType extends AbstractType
{
    /**
     * File save path
     *
     * @var string|null
     */
    public ?string $path = null;

    /**
     * Allowed mime types
     *
     * @var array
     */
    public array $allowedMimeTypes = [];

    /**
     * Max file size
     *
     * @var float|null
     */
    public ?float $maxFileSize = 1000000;

    /**
     * Max image width
     *
     * @var int|null
     */
    public ?int $maxWidth = 500;

    /**
     * Max image height
     *
     * @var int|null
     */
    public ?int $maxHeight = 500;

    /**
     * Filename generator function
     *
     * @var null|callable
     */
    public $filenameGenerator = null;

    /**
     * Prefix for filename
     *
     * @var string|null
     */
    public ?string $prefix = null;

    /**
     * Sets some GuzzleHttp options for fetching files
     *
     * @var array
     */
    public array $fetching_options = [
        'allow_redirects' => true,
        'connect_timeout' => 1,
        'debug' => false,
        'http_errors' => true
    ];

    /**
     * @inheritDoc
     */
    public function __construct(&$parent, $defaultValue, $required, $otherCfg)
    {
        if (!isset($otherCfg['prefix'])) {
            $parts = explode('//', str_replace(['icms_ipf_', 'mod_'], '', get_class($parent)));
            $otherCfg['prefix'] = $parts[count($parts) - 1];
            unset($parts);
        }
        if (!isset($otherCfg['path']) && defined('ICMS_UPLOAD_PATH')) {
            $otherCfg['path'] = ICMS_UPLOAD_PATH;
        }
        parent::__construct($parent, $defaultValue, $required, $otherCfg);
    }

    /**
     * @inheritDoc
     */
    public function isDefined()
    {
        return (isset($this->value['filename']) && !empty($this->value['filename']));
    }

    /**
     * @inheritDoc
     */
    public function getForDisplay()
    {
        return str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));
    }

    /**
     * @inheritDoc
     */
    public function getForEdit()
    {
        return str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));
    }

    /**
     * @inheritDoc
     */
    public function getForForm()
    {
        return str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));
    }

    /**
     * Set var from request
     *
     * @param mixed $key Key to read
     *
     * @throws PropertyIsLockedException
     * @throws ValueIsNotInPossibleValuesListException
     */
    public function setFromRequest($key)
    {
        if (is_array($key)) {
            $value = &$_FILES;
            foreach ($key as $k) {
                $value = &$value[$k];
            }
            $this->set($value);
        } else {
            $this->set($_FILES[$key]);
        }
    }

    /**
     * @inheritDoc
     */
    protected function clean($value)
    {
        if (is_string($value)) {
            if (file_exists($value)) {
                return [
                    'filename' => $value,
                    'mimetype' => $this->getFileMimeType($value),
                ];
            }
            return $this->isDataURI($value) ?
                $this->uploadFromDataURI($value) :
                $this->uploadFileFromUrl($value);
        } elseif (isset($value['filename']) && isset($value['mimetype'])) {
            return $value;
        }
        return null;
    }

    /**
     * Gets mimetype from filename
     *
     * @param string $filename Filename
     *
     * @return string
     */
    protected function getFileMimeType($filename)
    {
        return mime_content_type($filename);
    }

    /**
     * Is this data uri?
     *
     * @param string $url URL to check
     *
     * @return bool
     */
    protected function isDataURI($url)
    {
        return substr($url, 0, 5) === 'data:';
    }

    /**
     * Upload from data URI
     *
     * @param string $url data:// url from where to upload content
     * @return array
     *
     * @throws MimeTypeIsNotAllowedException
     */
    protected function uploadFromDataURI($url)
    {
        $fp = fopen($url, 'r');
        $meta = stream_get_meta_data($fp);
        $content = stream_get_contents($fp);
        fclose($fp);

        if (!empty($this->allowedMimeTypes) && !in_array($meta['mediatype'], $this->allowedMimeTypes)) {
            throw new MimeTypeIsNotAllowedException($meta['mediatype'], $this->allowedMimeTypes);
        }

        $this->checkFileSize($url, strlen($content));

        $new_tmp_file = tempnam(sys_get_temp_dir(), 'data') . '.' . explode('/', $meta['mediatype'])[1];
        file_put_contents($new_tmp_file, $content, FILE_BINARY);

        if (substr($meta['mediatype'], 0, 6) === 'image/') {
            $this->checkImageSize($new_tmp_file);
        }

        $target_filename = $this->generateTargetFileName(basename($new_tmp_file), $meta['mediatype']);
        rename($new_tmp_file, $target_filename);

        return ['filename' => $target_filename, 'mimetype' => $meta['mediatype']];
    }

    /**
     * Validates file size (if too big trows exception)
     *
     * @param string $url
     * @param $current_size
     * @throws FileTooBigException
     */
    private function checkFileSize($url, $current_size)
    {
        if ($this->maxFileSize > 0 && $current_size > $this->maxFileSize) {
            throw new FileTooBigException($url, $this->maxFileSize, $current_size);
        }
    }

    /**
     * Validates image size
     *
     * @param string $file File to check
     *
     * @throws ImageWidthTooBigException
     * @throws ImageHeightTooBigException
     */
    private function checkImageSize($file)
    {
        if ($this->maxWidth < 1 && $this->maxHeight < 1) {
            return;
        }
        $intervention = new ImageManager([
            'driver' => extension_loaded('imagick') ? 'imagick' : 'gd'
        ]);
        $image = $intervention->make($file);
        if ($this->maxWidth > $image->getWidth()) {
            throw new ImageWidthTooBigException();
        }
        if ($this->maxHeight > $image->getHeight()) {
            throw new ImageHeightTooBigException();
        }
    }

    /**
     * Generates target filename
     *
     * @param $filename
     * @param $mimetype
     *
     * @return string
     */
    private function generateTargetFileName($filename, $mimetype)
    {
        if (isset($this->filenameGenerator)) {
            $gen_filename = call_user_func(
                $this->filenameGenerator,
                'post',
                $mimetype,
                $filename
            );
        } else {
            $gen_filename = $filename;
        }
        if (!empty($this->prefix)) {
            $gen_filename = $this->prefix . $gen_filename;
        }
        if ($this->path) {
            return $this->path . DIRECTORY_SEPARATOR . $gen_filename;
        } else {
            return $gen_filename;
        }
    }

    /**
     * Upload file from URL
     *
     * @param string $url Uploads file from URL
     * @return mixed|string
     *
     * @throws MimeTypeIsNotAllowedException
     */
    protected function uploadFileFromUrl($url)
    {
        $tmp_file = tempnam(sys_get_temp_dir(), 'uploaded');
        $fp = fopen($tmp_file, 'w');
        $client = new Client();
        $content_is_ok = false;
        $mimetype = 'unknown/unknown';
        $response = $client->get(
            $url,
            $this->fetching_options +
            [
                'save_to' => $fp,
                'on_headers' => function (ResponseInterface $response) use ($url, &$content_is_ok, &$mimetype) {
                    $this->checkFileSize($url, $response->getHeaderLine('Content-Length'));
                    if (!empty($this->allowedMimeTypes)) {
                        $content_type = $response->getHeader('Content-Type');
                        if (isset($content_type[0]) && in_array($content_type[0], $this->allowedMimeTypes)) {
                            $content_is_ok = true;
                            $mimetype = strtolower($content_type);
                        }
                    }
                }
            ]
        );
        fclose($fp);

        $this->checkFileSize($url, filesize($tmp_file));

        $real_filename = $this->detectFileName($response, $url);
        $new_tmp_file = $tmp_file . '_' . $real_filename;
        rename($tmp_file, $new_tmp_file);

        if (!$content_is_ok && !empty($this->allowedMimeTypes)) {
            $mimetype = $this->getFileMimeType($new_tmp_file);
            if (!in_array($mimetype, $this->allowedMimeTypes)) {
                throw new MimeTypeIsNotAllowedException($mimetype, $this->allowedMimeTypes);
            }
        }

        if (substr($mimetype, 0, 6) === 'image/') {
            $this->checkImageSize($new_tmp_file);
        }

        $target_filename = $this->generateTargetFileName($real_filename, $mimetype);
        rename($new_tmp_file, $target_filename);

        return ['filename' => $target_filename, 'mimetype' => $mimetype];
    }

    /**
     * Detects filename from response or atleast from URL
     *
     * @param ResponseInterface $response Response
     * @param string $url URL
     *
     * @return mixed
     */
    private function detectFileName(ResponseInterface &$response, $url)
    {
        $content_disposition = $response->getHeader('Content-Disposition');
        if (isset($content_disposition['filename'])) {
            return $content_disposition['filename'];
        }
        $parts = explode('/', parse_url($url, PHP_URL_PATH));
        return end($parts);
    }
}
