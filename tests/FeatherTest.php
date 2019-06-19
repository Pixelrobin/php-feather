<?php

use PHPUnit\Framework\TestCase;

class FeatherTest extends TestCase {

	public function setUp() {

		$this->icons = new Feather\Icons;

		$this->sourceJSON = json_decode(
			file_get_contents(__DIR__ . '/../vendor/npm-asset/feather-icons/dist/icons.json'),
			true
		);

		$this->AttributeTestData = json_decode(
			file_get_contents(__DIR__ . '/AttributeTestData.json'),
			true
		);
	}

	/**
	 * Get contents from icon file  as that contains the SVG attributes to test against.
	 * These aren't available as part of the icons.json combined file.
	 *
	 * @param  $name Name of icon file to load
	 * @return string XML of <svg> element with icon contents
	 *
	 */
	private function getIconFile($name) {
		return file_get_contents(__DIR__ . '/../vendor/npm-asset/feather-icons/dist/icons/' . $name . '.svg');
	}


	public function testIconDefaultXML() {
		foreach ($this->sourceJSON as $name => $xml) {
			$contents = $this->getIconFile($name);
			$this->assertXMLStringEqualsXMLString(
				$contents,
				$this->icons->get($name, array(), false),
				'Icon fail: ' . $name
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

		$this->icons->setAttributes($test_data['attributes']);
		$icon = $this->icons->get($test_data['name'], array(), false);

		$this->assertXMLStringEqualsXMLString(
			$test_data['xml'],
			$icon,
			'XML custom attribute on class fail'
		);

		$this->icons->setAttributes(Feather\Icons::DEFAULT_ATTRIBUTES);
	}

}