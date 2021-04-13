<?php

namespace Feather;

use Feather\Exception\IconNotFoundException;

class IconManager
{
    use SvgAttributesTrait;

    private $icons;

    public function __construct()
    {
        $this->attributes = require \implode(DIRECTORY_SEPARATOR, [\dirname(__FILE__), '..', 'resources', 'attributes.php']);
        $this->icons      = require \implode(DIRECTORY_SEPARATOR, [\dirname(__FILE__), '..', 'resources', 'icons.php']);
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
