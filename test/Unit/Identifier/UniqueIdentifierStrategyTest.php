<?php

namespace MediasServiceTest\Unit\Identifier;

use MediasService\Identifier\IdentifierStrategy;
use MediasService\Identifier\UniqueIdentifierStrategy;
use PHPUnit\Framework\TestCase;
use TypeError;

class UniqueIdentifierStrategyTest extends TestCase
{
    /**
     * @var IdentifierStrategy
     */
    private $strategy;

    public function testGenerate(): void
    {
        $identifiers = array();

        // Verify 50 random identifiers
        for ($i = 0; $i < 50; $i++) {
            $identifier = $this->strategy->generate();

            array_push($identifiers, $identifier);
            $this->assertTrue($this->isUuid($identifier));
        }

        // All of them have to be unique
        $this->assertCount(50, array_unique($identifiers));
    }

    private function isUuid($identifier): bool
    {
        return is_string($identifier) && preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $identifier) === 1;
    }

    public function testValidate(): void
    {
        // Check a generated identifier
        $identifier = $this->strategy->generate();
        $this->assertTrue($this->strategy->validate($identifier));

        // Check null
        try {
            $this->strategy->validate(null);
            $this->fail('Should throw a type error with null');
        } catch (TypeError $ignored) {
        }

        // Check wrong type
        $this->assertFalse($this->strategy->validate(40));
        $this->assertFalse($this->strategy->validate(4.2));

        // Check wrong type
        $this->assertFalse($this->strategy->validate("fake-uuid"));
    }

    protected function setUp(): void
    {
        $this->strategy = new UniqueIdentifierStrategy();
    }

}
