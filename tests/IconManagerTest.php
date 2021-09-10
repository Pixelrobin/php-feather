<?php

use Feather\Exception\AliasDefinedException;
use Feather\Exception\IconNotFoundException;
use Feather\Icon;
use Feather\IconManager;
use PHPUnit\Framework\TestCase;

class IconManagerTest extends TestCase
{
    /**
     * @var string
     */
    private $iconName = 'test';

    /**
     * @var IconManager
     */
    private $iconManager;

    protected function setUp(): void
    {
        $iconManager = $this->getMockBuilder(IconManager::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['__construct'])
            ->getMock();

        $reflector = new ReflectionClass(IconManager::class);

        $property = $reflector->getProperty('icons');
        $property->setAccessible(true);
        $property->setValue($iconManager, [$this->iconName => '']);

        $property = $reflector->getProperty('attributes');
        $property->setAccessible(true);
        $property->setValue($iconManager, []);

        $this->iconManager = $iconManager;
    }

    public function testIconRetrieval(): void
    {
        $icon = $this->iconManager->getIcon($this->iconName, [], '');

        $this->assertInstanceOf(Icon::class, $icon);
    }

    public function testIconNotFound(): void
    {
        $this->expectException(IconNotFoundException::class);

        $this->iconManager->getIcon('icon-that-should-not-be-found');
    }

    public function testIconAlias(): void
    {
        $this->iconManager->addAlias('test-alias', $this->iconName);

        $icon = $this->iconManager->getIcon('test-alias');

        $this->assertInstanceOf(Icon::class, $icon);
        $this->assertEquals($this->iconName, $icon->getName());
    }

    public function testDuplicateIconAlias(): void
    {
        $this->expectException(AliasDefinedException::class);

        $this->iconManager->addAlias('test-alias', $this->iconName);
        $this->iconManager->addAlias('test-alias', $this->iconName);
    }

    public function testInvalidIconAlias(): void
    {
        $this->expectException(IconNotFoundException::class);

        $this->iconManager->addAlias('test-alias', 'icon-that-should-not-be-found');
    }

    public function testMissingIconAlias(): void
    {
        $this->expectException(IconNotFoundException::class);

        $this->iconManager->getIcon('test-alias');
    }

    public function testAttributePassing(): void
    {
        $attributes = [
            'width' => 24,
            'height' => 24,
            'color' => '#000',
            'data-custom-attribute' => 'custom-value',
        ];

        $this->iconManager->setAttributes($attributes);

        $icon = $this->iconManager->getIcon($this->iconName);

        $this->assertEquals($attributes, $icon->getAttributes());
    }

    public function testAttributeOverwritting(): void
    {
        $attributes = [
            'data-custom-attribute' => 'custom-value',
        ];

        $this->iconManager->setAttributes($attributes);

        $icon = $this->iconManager->getIcon($this->iconName, ['data-custom-attribute' => 'another-value']);

        $this->assertEquals('another-value', $icon->getAttribute('data-custom-attribute'));
    }
}
