<?php

namespace Feather;

include __DIR__ . './defaultAttributes.php';

use \Feather\DEFAULT_ATTRS;

function Icon($name, $attrs = array(), $echo = true) {
	$filepath = __DIR__ . '/../icons/' . $name . '.svg';

	if (file_exists($filepath)) {
		$contents = file_get_contents($filepath);
		$attrs = array_merge(DEFAULT_ATTRS, $attrs);

		if (isset($attrs['class'])) $class_end = ' ' . $attrs['class'];
		else $class_end = '';

		$attrs['class'] = 'feather feather-' . $name . $class_end;

		$dom_attrs = array_reduce(array_keys($attrs), function($final, $current) use ($attrs) {
			return $final . $current . '="' . $attrs[$current] . '" ';
		}, '');

		$icon = '<svg ' . $dom_attrs . '>' . $contents . '</svg>';

		if ($echo) echo $icon;
		else return $icon;
	}
}