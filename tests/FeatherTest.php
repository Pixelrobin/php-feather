<?php

use PHPUnit\Framework\TestCase;

class FeatherTest extends TestCase {
	protected function setUp() {
		$this->icons = new Feather\Icons;

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

	public function testIconsHasDefaultAttributes() {
		$this->assertEquals(Feather\DEFAULT_ATTRIBUTES, $this->icons->getAttributes());
	}

	public function testIconDefaultXML() {
		foreach ($this->XMLTestData as $test_data) {
			$this->assertXMLStringEqualsXMLString(
				$test_data['xml'],
				$this->icons->get($test_data['name'], array(), false),
				'Icon fail: ' . $test_data['name']
			);
		}
	}

	public function testIconXMLWithAttributes() {
		$test_data = $this->AttributeTestData;

		$icon = $this->icons->get($test_data['name'], $test_data['attributes'], false);

		$this->assertXMLStringEqualsXMLString(
			$test_data['xml'],
			$icon,
			'XML custom attribute fail'
		);
	}

	public function testIconXMLWithAttributesFromClass() {
		$test_data = $this->AttributeTestData;

		$this->icons->setattributes($test_data['attributes']);
		$icon = $this->icons->get($test_data['name'], array(), false);

		$this->assertXMLStringEqualsXMLString(
			$test_data['xml'],
			$icon,
			'XML custom attribute on class fail'
		);

		$this->icons->setAttributes(Feather\DEFAULT_ATTRIBUTES);
	}
}
