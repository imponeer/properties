<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Exceptions;

use Imponeer\Properties\Exceptions;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ExceptionsTest extends TestCase
{
    #[DataProvider('exceptionProvider')]
    public function testExceptionMessages(
        string $class,
        array $arguments,
        string $expectedMessage,
        ?callable $propertyAssertions
    ): void {
        $exception = new $class(...$arguments);

        $this->assertSame($expectedMessage, $exception->getMessage());

        if ($propertyAssertions !== null) {
            $propertyAssertions($exception);
        }
    }

    public static function exceptionProvider(): iterable
    {
        yield [
            Exceptions\CommonDataTypeNotFoundException::class,
            ['custom'],
            'Class for data type "custom" not found!',
            static fn ($exception) => self::assertSame('custom', $exception->varType)
        ];

        yield [
            Exceptions\PropertyIsLockedException::class,
            ['name'],
            'Property name is locked!',
            static fn ($exception) => self::assertSame('name', $exception->property)
        ];

        yield [
            Exceptions\SpecifiedDataTypeNotFoundException::class,
            [5],
            'Class for data type #5 not found!',
            static fn ($exception) => self::assertSame(5, $exception->dataType)
        ];

        yield [
            Exceptions\ValueIsNotInPossibleValuesListException::class,
            ['color'],
            'Value is not in possible values list for property color!',
            static fn ($exception) => self::assertSame('color', $exception->property)
        ];

        yield [
            Exceptions\FileTooBigException::class,
            ['src.txt', 10.0, 25.0],
            'File too big!',
            static function ($exception): void {
                self::assertSame('src.txt', $exception->src);
                self::assertSame(10.0, $exception->maxSize);
                self::assertSame(25.0, $exception->currentSize);
            }
        ];

        yield [
            Exceptions\MimeTypeIsNotAllowedException::class,
            ['image/bmp', ['image/png']],
            'Mimetype is not allowed',
            static function ($exception): void {
                self::assertSame('image/bmp', $exception->mimetype);
                self::assertSame(['image/png'], $exception->allowedMimetypes);
            }
        ];

        yield [
            Exceptions\ImageHeightTooBigException::class,
            [],
            '',
            null
        ];

        yield [
            Exceptions\ImageWidthTooBigException::class,
            [],
            '',
            null
        ];

        yield [
            Exceptions\NoContainerSetException::class,
            [],
            'No container has been set. Call Properties::setContainer() first.',
            null
        ];

        yield [
            Exceptions\RequestNotSetException::class,
            [],
            'No PSR-7 request has been set. Call setRequest() or ensure a '
            . 'ServerRequestInterface is available in the container.',
            null
        ];

        yield [
            Exceptions\ServiceNotFoundException::class,
            ['service.id'],
            "Service or class 'service.id' not found",
            null
        ];

        yield [
            Exceptions\UndefinedVariableException::class,
            ['SOME_CONST'],
            'SOME_CONST is undefined!',
            null
        ];

        yield [
            Exceptions\ValidationRuleNotPassedException::class,
            ['invalid'],
            'Validation rule not passed',
            static fn ($exception) => self::assertSame('invalid', $exception->value)
        ];
    }
}
