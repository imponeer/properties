<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Imponeer\Properties\AbstractType;
use Imponeer\Properties\Exceptions\FileTooBigException;
use Imponeer\Properties\Exceptions\ImageHeightTooBigException;
use Imponeer\Properties\Exceptions\ImageWidthTooBigException;
use Imponeer\Properties\Exceptions\MimeTypeIsNotAllowedException;
use Imponeer\Properties\Internal\Facades\Request;
use Imponeer\Properties\Internal\Helper\HtmlSanitizerHelper;
use Imponeer\Properties\PropertiesSettings;
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

	public function __construct(
		object $parent,
		string $name,
		mixed $defaultValue = null,
		bool $required = false,
		?array $otherCfg = null
	)
	{
		if (!isset($otherCfg['prefix'])) {
			$parts = explode('//', str_replace(['icms_ipf_', 'mod_'], '', get_class($parent)));
			$otherCfg['prefix'] = $parts[count($parts) - 1];
			unset($parts);
		}
		if (!isset($otherCfg['path']) && defined('ICMS_UPLOAD_PATH')) {
			$otherCfg['path'] = ICMS_UPLOAD_PATH;
		}

		parent::__construct($parent, $name, $defaultValue, $required, $otherCfg);
    }

    /**
     * @inheritDoc
     */
    public function isDefined(): bool
	{
        return (isset($this->value['filename']) && !empty($this->value['filename']));
    }

    /**
     * @inheritDoc
     */
    public function getForDisplay(): string
	{
        return HtmlSanitizerHelper::prepareForHtml(
			$this->isDefined() ? $this->value['filename'] : null
		);
    }

    /**
     * @inheritDoc
     */
    public function getForEdit(): string
	{
		return $this->getForDisplay();
    }

    /**
     * @inheritDoc
     */
    public function getForForm(): string
	{
        return HtmlSanitizerHelper::prepareForHtml($this->value);
    }

	/**
	 * @inheritDoc
	 */
    public function setFromRequest(string|array $key): void
    {
		$files = Request::getUploadedFiles();

		if (is_array($key)) {
			$value = $this->resolveArrayPath($files, $key);
		} else {
			$value = $files[$key] ?? null;
		}

		$this->set($value);
    }

	/**
	 * @inheritDoc
	 *
	 * @throws FileTooBigException
	 * @throws GuzzleException
	 * @throws ImageHeightTooBigException
	 * @throws ImageWidthTooBigException
	 * @throws MimeTypeIsNotAllowedException
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
        }

        if (isset($value['filename'], $value['mimetype'])) {
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
    protected function getFileMimeType(string $filename): string
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
    protected function isDataURI(string $url): bool
    {
        return str_starts_with($url, 'data:');
    }

	/**
	 * Upload from data URI
	 *
	 * @param string $url data:// url from where to upload content
	 * @return array
	 *
	 * @throws FileTooBigException
	 * @throws ImageHeightTooBigException
	 * @throws ImageWidthTooBigException
	 * @throws MimeTypeIsNotAllowedException
	 */
    protected function uploadFromDataURI(string $url)
    {
        $fp = fopen($url, 'rb');
        $meta = stream_get_meta_data($fp);
        $content = stream_get_contents($fp);
        fclose($fp);

        if (!empty($this->allowedMimeTypes) && !in_array($meta['mediatype'], $this->allowedMimeTypes, true)) {
            throw new MimeTypeIsNotAllowedException($meta['mediatype'], $this->allowedMimeTypes);
        }

        $this->checkFileSize($url, strlen($content));

        $new_tmp_file = tempnam(sys_get_temp_dir(), 'data') . '.' . explode('/', $meta['mediatype'])[1];
        file_put_contents($new_tmp_file, $content, FILE_BINARY);

        if (str_starts_with($meta['mediatype'], 'image/')) {
            $this->checkImageSize($new_tmp_file);
        }

        $target_filename = $this->generateTargetFileName(basename($new_tmp_file), $meta['mediatype']);
        rename($new_tmp_file, $target_filename);

        return ['filename' => $target_filename, 'mimetype' => $meta['mediatype']];
    }

    /**
     * Validates file size (if too big trows exception)
     *
     * @throws FileTooBigException
     */
    private function checkFileSize(string $url, int $current_size): void
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
    private function checkImageSize(string $file): void
    {
        if ($this->maxWidth < 1 && $this->maxHeight < 1) {
            return;
        }
        $intervention = new ImageManager(
            extension_loaded('imagick') ? 'imagick' : 'gd'
        );
        $image = $intervention->read($file);
        if ($this->maxWidth < $image->width()) {
            throw new ImageWidthTooBigException();
        }
        if ($this->maxHeight < $image->height()) {
            throw new ImageHeightTooBigException();
        }
    }

    /**
     * Generates target filename
     */
    private function generateTargetFileName(string $filename, string $mimetype): string
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
        }

		return $gen_filename;
	}

	/**
	 * Upload file from URL
	 *
	 * @param string $url Uploads file from URL
	 * @return mixed|string
	 *
	 * @throws MimeTypeIsNotAllowedException
	 * @throws ImageWidthTooBigException
	 * @throws FileTooBigException
	 * @throws GuzzleException
	 * @throws ImageHeightTooBigException
	 */
    protected function uploadFileFromUrl(string $url)
    {
        $tmp_file = tempnam(sys_get_temp_dir(), 'uploaded');
        $fp = fopen($tmp_file, 'wb');
        $client = new Client();
        $content_is_ok = false;
        $mimetype = 'unknown/unknown';
        $response = $client->get(
            $url,
            $this->fetching_options +
            [
                'save_to' => $fp,
                'on_headers' => function (ResponseInterface $response) use ($url, &$content_is_ok, &$mimetype) {
                    $this->checkFileSize($url, (int) $response->getHeaderLine('Content-Length'));
                    if (!empty($this->allowedMimeTypes)) {
                        $content_type = $response->getHeader('Content-Type');
                        if (isset($content_type[0]) && in_array($content_type[0], $this->allowedMimeTypes, true)) {
                            $content_is_ok = true;
                            $mimetype = strtolower($content_type[0]);
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
            if (!in_array($mimetype, $this->allowedMimeTypes, true)) {
                throw new MimeTypeIsNotAllowedException($mimetype, $this->allowedMimeTypes);
            }
        }

        if (str_starts_with($mimetype, 'image/')) {
            $this->checkImageSize($new_tmp_file);
        }

        $target_filename = $this->generateTargetFileName($real_filename, $mimetype);
        rename($new_tmp_file, $target_filename);

        return ['filename' => $target_filename, 'mimetype' => $mimetype];
    }

    /**
     * Detects filename from response or least from URL
     *
     * @param ResponseInterface $response Response
     * @param string $url URL
     *
     * @return mixed
     */
    private function detectFileName(ResponseInterface $response, string $url)
    {
        $content_disposition = $response->getHeader('Content-Disposition');
        if (isset($content_disposition['filename'])) {
            return $content_disposition['filename'];
        }
        $parts = explode('/', parse_url($url, PHP_URL_PATH));
        return end($parts);
    }
}
