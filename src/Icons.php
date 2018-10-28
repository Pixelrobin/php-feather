<?php

namespace Feather;

require __DIR__ . './defaultAttributes.php';

use \Feather\DEFAULT_ATTRIBUTES;

class Icons {
	public $attributes = DEFAULT_ATTRIBUTES;

	public function get($name, $echo = true, $attributes = array()) {
		$filepath = __DIR__ . '/../icons/' . $name . '.svg';

		if (file_exists($filepath)) {
			$contents = file_get_contents($filepath);
			$attributes = array_merge($this->attributes, $attributes);

			if (isset($attributes['class'])) $class_end = ' ' . $attributes['class'];
			else $class_end = '';

			$attributes['class'] = 'feather feather-' . $name . $class_end;

			$dom_attributes = array_reduce(
				array_keys($attributes),
				function($final, $current) use ($attributes) {
					return $final . $current . '="' . $attributes[$current] . '" ';
				}, ''
			);

			$icon = '<svg ' . $dom_attributes . '>' . $contents . '</svg>';

			if ($echo) echo $icon;
			else return $icon;
		}
	}

	static function get_default_attributes() {
		return DEFAULT_ATTRIBUTES;
	}
}