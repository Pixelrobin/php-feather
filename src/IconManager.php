<?php

namespace Feather;

use Feather\Exception\AliasDefinedException;
use Feather\Exception\IconNotFoundException;

class IconManager
{
    use SvgAttributesTrait;

    private $icons;

    private $aliases = [];

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
        $name = $this->normalizeIconName($name);

        if (!isset($this->icons[$name])) {
            throw new IconNotFoundException(\sprintf('Icon `%s` not found', $name));
        }

        return new Icon($name, \array_merge($this->attributes, $attributes), $this->icons[$name]);
    }

    public function addAlias(string $alias, string $iconName): self
    {
        if (isset($this->aliases[$alias])) {
            throw new AliasDefinedException(\sprintf('Alias `%s` already defined', $alias));
        }

        if (!isset($this->icons[$iconName])) {
            throw new IconNotFoundException(\sprintf('Icon `%s` not found', $iconName));
        }

        $this->aliases[$alias] = $iconName;

        return $this;
    }

    public function getIconAliases(): array
    {
        return $this->aliases;
    }

    private function normalizeIconName(string $name): string
    {
        return $this->aliases[$name] ?? $name;
    }
}
