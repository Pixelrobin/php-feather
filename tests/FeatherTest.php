<?php

use Feather\Exception\IconNotFoundException;
use Feather\IconManager;
use PHPUnit\Framework\TestCase;

class FeatherTest extends TestCase
{
    private $icons;

    /**
     * @var array
     */
    private $XMLTestData;

    /**
     * @var array
     */
    private $AttributeTestData;

    protected function setUp(): void
    {
        $this->icons = new IconManager();

        // Data from JS

        $this->XMLTestData = json_decode(
            file_get_contents(__DIR__ . '/XMLTestData.json'),
            true
        );

        $this->AttributeTestData = json_decode(
            file_get_contents(__DIR__ . '/AttributeTestData.json'),
            true
        );
    }

    public function testIconsHasDefaultAttributes(): void
    {
        $attributes = require implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), '..', 'resources', 'attributes.php']);

        $this->assertEquals($attributes, $this->icons->getAttributes());
    }

    public function testIconDefaultXML(): void
    {
        foreach ($this->XMLTestData as $test_data) {
            $this->assertXMLStringEqualsXMLString(
                $test_data['xml'],
                $this->icons->get($test_data['name'], []),
                'Icon fail: ' . $test_data['name']
            );
        }
    }

    public function testIconXMLWithAttributes(): void
    {
        $test_data = $this->AttributeTestData;

        $icon = $this->icons->get($test_data['name'], $test_data['attributes']);

        $this->assertXMLStringEqualsXMLString(
            $test_data['xml'],
            $icon,
            'XML custom attribute fail'
        );
    }

    public function testIconXMLWithAttributesFromClass(): void
    {
        $attributes = require implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), '..', 'resources', 'attributes.php']);

        $test_data = $this->AttributeTestData;

        $this->icons->setattributes($test_data['attributes']);
        $icon = $this->icons->get($test_data['name'], []);

        $this->assertXMLStringEqualsXMLString(
            $test_data['xml'],
            $icon,
            'XML custom attribute on class fail'
        );

        $this->icons->setAttributes($attributes);
    }

    public function testIconNotFound(): void
    {
        $this->expectException(IconNotFoundException::class);

        $this->icons->get('icon-that-should-not-be-found');
    }
}
