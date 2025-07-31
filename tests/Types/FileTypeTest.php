<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Types;

use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\Tests\TestTypeAbstract;

class FileTypeTest extends TestTypeAbstract
{
    public function testIfInitialWasNull(): void
    {
        $this->assertNull($this->mock->v, 'DTYPE_FILE must have null unconverted');
    }

    public function testUploadingFromDataUri(): void
    {
        $this->mock->v = 'data:image/gif;base64,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';
        $this->assertIsArray($this->mock->v, 'DTYPE_FILE must be returned as array un success');
        $this->assertArrayHasKey('filename', $this->mock->v, 'Filename key on FILE type isn\'t returned');
        $this->assertArrayHasKey('mimetype', $this->mock->v, 'Mimetype key on FILE type isn\'t returned');
    }

    public function testUploadingFromUrl(): void
    {
        $this->mock->v = 'https://upload.wikimedia.org/wikipedia/en/8/80/Wikipedia-logo-v2.svg';
        $this->assertIsArray($this->mock->v, 'DTYPE_FILE must be returned as array un success');
        $this->assertArrayHasKey('filename', $this->mock->v, 'Filename key on FILE type isn\'t returned');
        $this->assertArrayHasKey('mimetype', $this->mock->v, 'Mimetype key on FILE type isn\'t returned');
    }

    protected function getDataType(): int
    {
        return PropertiesInterface::DTYPE_FILE;
    }

    protected function getOtherConfig(): array
    {
        return [
            'path' => sys_get_temp_dir(),
            'prefix' => crc32(microtime(true))
        ];
    }
}
