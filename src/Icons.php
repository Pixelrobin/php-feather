<?php

namespace Feather;

require __DIR__ . '/defaultAttributes.php';

class Icons
{
    private $attributes = DEFAULT_ATTRIBUTES;

    private $icons;

    public function __construct()
    {
        $this->icons = require implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), '..', 'resources', 'icons.php']);
    }

    public function get($name, $attributes = [], $echo = true)
    {
        if (isset($this->icons[$name])) {
            $contents   = $this->icons[$name];
            $attributes = array_merge($this->attributes, $attributes);

            if (isset($attributes['class'])) {
                $class_end = ' ' . $attributes['class'];
            } else {
                $class_end = '';
            }

            $attributes['class'] = 'feather feather-' . $name . $class_end;

            $dom_attributes = array_reduce(
                array_keys($attributes),
                function ($final, $current) use ($attributes) {
                    $attribute_value = $attributes[$current];

                    if (is_bool($attribute_value)) {
                        $attribute_value = $attribute_value ? 'true' : 'false';
                    }

                    return $final . $current . '="' . (string)$attribute_value . '" ';
                },
                ''
            );

            $icon = '<svg ' . $dom_attributes . '>' . $contents . '</svg>';

            if ($echo) {
                echo $icon;
            } else {
                return $icon;
            }
        }

        return false;
    }

    public function setAttributes($attributes, $merge = true)
    {
        if ($merge) {
            $this->attributes = array_merge($this->attributes, $attributes);
        } else {
            $this->attributes = $attributes;
        }
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}
