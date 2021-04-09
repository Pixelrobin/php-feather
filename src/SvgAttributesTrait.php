<?php

namespace Feather;

trait SvgAttributesTrait
{
    private $attributes;

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
}
