<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Internal\Facades;

use Imponeer\Properties\Internal\Facades\Translator;
use Imponeer\Properties\Service\ServiceLocator;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class TranslatorTest extends TestCase
{
    public function testTransUsesTranslatorFromContainer(): void
    {
        $translator = new class implements TranslatorInterface {
            public array $calls = [];
            private string $locale = 'en';

            public function trans(
                string $id,
                array $parameters = [],
                string $domain = null,
                string $locale = null
            ): string {
                $this->calls[] = compact('id', 'parameters', 'domain', 'locale');

                return sprintf('[%s]%s', $domain ?? 'messages', $id);
            }

            public function getLocale(): string
            {
                return $this->locale;
            }

            public function setLocale(string $locale): void
            {
                $this->locale = $locale;
            }
        };

        ServiceLocator::setContainer(
            new class ($translator) implements ContainerInterface {
                public function __construct(private TranslatorInterface $translator)
                {
                }

                public function get(string $id): mixed
                {
                    return $this->translator;
                }

                public function has(string $id): bool
                {
                    return $id === TranslatorInterface::class;
                }
            }
        );

        $result = Translator::trans('key', ['%name%' => 'John'], 'domain', 'lt');

        $this->assertSame('[domain]key', $result);
        $this->assertSame(
            [
                [
                    'id' => 'key',
                    'parameters' => ['%name%' => 'John'],
                    'domain' => 'domain',
                    'locale' => 'lt'
                ]
            ],
            $translator->calls
        );
    }
}
