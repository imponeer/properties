<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Enum;

use Imponeer\Properties\Enum\ValidationRule;
use PHPUnit\Framework\TestCase;

class ValidationRuleTest extends TestCase
{
    public function testEmailRuleMatchesValidEmail(): void
    {
        $this->assertSame(
            1,
            preg_match(ValidationRule::EMAIL->value, 'user.name@example.com')
        );
    }

    public function testEmailRuleRejectsInvalidEmail(): void
    {
        $this->assertSame(
            0,
            preg_match(ValidationRule::EMAIL->value, 'not-an-email')
        );
    }

    public function testLinksRuleMatchesHttpUrl(): void
    {
        $this->assertSame(
            1,
            preg_match(ValidationRule::LINKS->value, 'https://example.com/page')
        );
    }

    public function testLinksRuleRejectsInvalidUrl(): void
    {
        $this->assertSame(
            0,
            preg_match(ValidationRule::LINKS->value, 'ftp://example.com')
        );
    }
}
