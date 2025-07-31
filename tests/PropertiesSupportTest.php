<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests;

use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\PropertiesSupport;
use PHPUnit\Framework\TestCase;

/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class PropertiesSupportTest extends TestCase
{
    protected PropertiesSupport $mock;

    protected function setUp(): void
    {
        $this->mock = $this->getMockBuilder(PropertiesSupport::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();
        parent::setUp();
    }

    public function testNeededPublicMethods(): void
    {
        foreach ([
            'getVar' => null,
            'setVar' => null,
            'assignVar' => null,
            'assignVars' => null,
            'getChangedVars' => 'array',
            'getDefaultVars' => 'array',
            'getProblematicVars' => 'array',
            'getValues' => 'array',
            'getVarForDisplay' => null,
            'getVarForEdit' => null,
            'getVarForForm' => null,
            'getVarInfo' => null,
            'getVarNames' => null,
            'getVars' => 'array',
            'isChanged' => 'bool',
            'setVarInfo' => null,
            'toArray' => 'array',
        ] as $method => $retType) {
            $this->assertTrue(method_exists($this->mock, $method), 'No public ' . $method . ' method');
            if ($retType !== null) {
                $result = $this->mock->$method();
                match ($retType) {
                    'array' => $this->assertIsArray($result, "$method returns wrong data type"),
                    'bool' => $this->assertIsBool($result, "$method returns wrong data type"),
                    default => null
                };
            }
        }
    }

    public function testInitVars(): void
    {
        $reflection_method = new \ReflectionMethod($this->mock, 'initVar');
        $this->assertInstanceOf(\ReflectionMethod::class, $reflection_method, 'initVar method doesn\'t exist');
        $this->assertTrue($reflection_method->isProtected(), 'initVar method isn\'t protected');

        $reflection_method->setAccessible(true);

        $this->assertCount(0, $this->mock->getVars(), 'Properties creates object with existing vars. This must not be possible for new objects.');

        $reflection_method->invoke($this->mock, 'var_array', PropertiesInterface::DTYPE_ARRAY, [], false);

        $vars = $this->mock->getVars();
        $this->assertCount(1, $vars, 'Couldn\'t init var');
        $this->assertArrayHasKey('var_array', $vars, 'Couldn\'t init var');

        $this->assertTrue(isset($this->mock->var_array), 'Can\'t use fast property access (without calling function)');

        $this->assertIsArray($this->mock->getVar('var_array'), 'When tried to read just created var wrong data returned');
        $this->assertIsArray($this->mock->var_array, 'When tried to read just created var wrong data returned');
    }
}