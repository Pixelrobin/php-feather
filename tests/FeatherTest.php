<?php

use Feather\Exception\IconNotFoundException;
use Feather\Icon;
use Feather\IconManager;
use PHPUnit\Framework\TestCase;

class FeatherTest extends TestCase
{
    private $icons;

    /**
     * @var array
     */
    private $xmlTestData;

    /**
     * @var array
     */
    private $attributeTestData;

    protected function setUp(): void
    {
        $this->icons = new IconManager();

        $this->xmlTestData = \json_decode(
            \file_get_contents(\implode(DIRECTORY_SEPARATOR, [\dirname(__FILE__), 'XMLTestData.json'])),
            true
        );

        $this->attributeTestData = \json_decode(
            \file_get_contents(\implode(DIRECTORY_SEPARATOR, [\dirname(__FILE__), 'AttributeTestData.json'])),
            true
        );
    }

    public function testIconsHasDefaultAttributes(): void
    {
        $attributes = require \implode(DIRECTORY_SEPARATOR, [\dirname(__FILE__), '..', 'resources', 'attributes.php']);

        $this->assertEquals($attributes, $this->icons->getAttributes());
    }

    public function testIconIsObject(): void
    {
        foreach ($this->xmlTestData as $testData) {
            $this->assertInstanceOf(Icon::class, $this->icons->getIcon($testData['name']));
        }
    }

    public function testIconDefaultXML(): void
    {
        foreach ($this->xmlTestData as $testData) {
            $this->assertXMLStringEqualsXMLString(
                $testData['xml'],
                (string)$this->icons->getIcon($testData['name']),
                'Icon fail: ' . $testData['name']
            );
        }
    }

    public function testIconXMLWithAttributes(): void
    {
        $testData = $this->attributeTestData;

        $this->assertXMLStringEqualsXMLString(
            $testData['xml'],
            (string)$this->icons->getIcon($testData['name'], $testData['attributes']),
            'XML custom attribute fail'
        );
    }

    public function testIconXMLWithAttributesFromClass(): void
    {
        $attributes = require \implode(DIRECTORY_SEPARATOR, [\dirname(__FILE__), '..', 'resources', 'attributes.php']);

        $testData = $this->attributeTestData;

        $this->icons->setattributes($testData['attributes']);

        $this->assertXMLStringEqualsXMLString(
            $testData['xml'],
            (string)$this->icons->getIcon($testData['name']),
            'XML custom attribute on class fail'
        );

        $this->icons->setAttributes($attributes);
    }

    public function testIconNotFound(): void
    {
        $this->expectException(IconNotFoundException::class);

        $this->icons->getIcon('icon-that-should-not-be-found');
    }
}
