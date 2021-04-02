<?php

namespace Feather;

use Feather\Exception\IconNotFoundException;

require __DIR__ . '/defaultAttributes.php';

class Icons
{
    private $attributes = DEFAULT_ATTRIBUTES;

    public function get(string $name, array $attributes = []): string
    {
        $filepath = __DIR__ . '/../icons/' . $name . '.svg';

        if (file_exists($filepath)) {
            $contents   = file_get_contents($filepath);
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

            return $icon;
        }

        throw new IconNotFoundException(\sprintf('Icon `%s` not found', $name));
    }

    public function setAttributes(array $attributes, bool $merge = true): self
    {
        if ($merge) {
            $this->attributes = array_merge($this->attributes, $attributes);
        } else {
            $this->attributes = $attributes;
        }

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
