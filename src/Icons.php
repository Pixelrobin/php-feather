<?php

namespace Feather;

class Icons {


	const DEFAULT_ATTRIBUTES = array(
		'xmlns' => 'http://www.w3.org/2000/svg',
		'width' => '24',
		'height' => '24',
		'viewBox' => '0 0 24 24',
		'fill' => 'none',
		'stroke' => 'currentColor',
		'stroke-width' => '2',
		'stroke-linecap' => 'round',
		'stroke-linejoin' => 'round',
	);

	private $attributes = array();

	private $icons = array();


	public function __construct() {
		$this->attributes = self::DEFAULT_ATTRIBUTES;
	}


	public function get($name, $attributes = array(), $echo = true) {

		$this->loadIcons();

		if ( ! isset($this->icons[$name])) {
			return false;
		}


		$contents = $this->icons[$name];
		$attributes = array_merge($this->attributes, $attributes);

		if (isset($attributes['class'])) {
			$class_end = ' ' . $attributes['class'];
		} else {
			$class_end = '';
		}

		$attributes['class'] = 'feather feather-' . $name . $class_end;

		$dom_attributes = array_reduce(
			array_keys($attributes),
			function($final, $current) use ($attributes) {
				$attribute_value = $attributes[$current];

				if (is_bool($attribute_value)) {
					$attribute_value = $attribute_value ? 'true' : 'false';
				}

				return $final . $current . '="' . (string) $attribute_value . '" ';
			}, ''
		);

		$icon = '<svg ' . $dom_attributes . '>' . $contents . '</svg>';

		if ($echo) {
			echo $icon;
		} else {
			return $icon;
		}
	}


	public function setAttributes($attributes, $merge = true) {
		if ($merge) $this->attributes = array_merge(self::DEFAULT_ATTRIBUTES, $attributes);
		else $this->attributes = $attributes;
	}


	public function getAttributes() {
		return $this->attributes;
	}


	/**
	 * Find the Feather icons json file and parse it.
	 *
	 */
	private function loadIcons() {

		if ( ! empty($this->icons)) {
			// Already loaded
			return;
		}

		$paths = array(
			__DIR__ . '/../../npm-asset/feather-icons/dist/icons.json',
			__DIR__ . '/../vendor/npm-asset/feather-icons/dist/icons.json',
		);

		foreach ($paths as $path) {

			$path = realpath($path);

			if (is_file($path)) {
				$decoded = json_decode( (string) file_get_contents($path), true);
				$error = json_last_error();
				if ($error === JSON_ERROR_NONE) {
					$this->icons = $decoded;
					return;
				}
			}
		}
	}


}
