<?php

namespace Feather;

require __DIR__ . '/defaultAttributes.php';

use Feather\DEFAULT_ATTRIBUTES;

class Icons {
	private $attributes = DEFAULT_ATTRIBUTES;

	public function get($name, $attributes = array(), $echo = true) {
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
					$attribute_value = $attributes[$current];
					
					if (is_bool($attribute_value))
						$attribute_value = $attribute_value ? 'true' : 'false';
					
					return $final . $current . '="' . (string)$attribute_value . '" ';
				}, ''
			);

			$icon = '<svg ' . $dom_attributes . '>' . $contents . '</svg>';

			if ($echo) echo $icon;
			else return $icon;
		}

		return false;
	}

	public function setAttributes($attributes, $merge = true) {
		if ($merge) $this->attributes = array_merge(DEFAULT_ATTRIBUTES, $attributes);
		else $this->attributes = $attributes;
	}

	public function getAttributes() {
		return $this->attributes;
	}
}
