<?php

namespace Feather;

use Feather\Exception\IconNotFoundException;

class IconManager
{
    private $attributes;

    private $icons;

    public function __construct()
    {
        $this->attributes = require \implode(DIRECTORY_SEPARATOR, [\dirname(__FILE__), '..', 'resources', 'attributes.php']);
        $this->icons      = require \implode(DIRECTORY_SEPARATOR, [\dirname(__FILE__), '..', 'resources', 'icons.php']);
    }

    public function setAttributes(array $attributes): self
    {
        $this->attributes = \array_merge($this->attributes, $attributes);

        return $this;
    }

    public function setAttribute(string $key, $value): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function removeAttribute(string $key): self
    {
        unset($this->attributes[$key]);

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getIconNames(): array
    {
        return \array_keys($this->icons);
    }

    public function getIcon(string $name, array $attributes = []): Icon
    {
        if (!isset($this->icons[$name])) {
            throw new IconNotFoundException(\sprintf('Icon `%s` not found', $name));
        }

        return new Icon($name, \array_merge($this->attributes, $attributes), $this->icons[$name]);
    }
}
