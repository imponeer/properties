<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Internal\Helper;

use Imponeer\Properties\Internal\Helper\HtmlSanitizerHelper;
use PHPUnit\Framework\TestCase;

class HtmlSanitizerHelperTest extends TestCase
{
    public function testPrepareForHtmlReplacesEntities(): void
    {
        $input = 'Fish & chips &nbsp; "quote"';

        $result = HtmlSanitizerHelper::prepareForHtml($input);

        $this->assertSame('Fish & chips &amp;nbsp; &quot;quote&quot;', $result);
    }

    public function testPrepareForHtmlHandlesNull(): void
    {
        $this->assertSame('', HtmlSanitizerHelper::prepareForHtml(null));
    }
}
