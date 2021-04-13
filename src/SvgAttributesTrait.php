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

    /**
     * @return mixed
     */
    public function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function setSize(float $width, ?float $height = null): self
    {
        $this->setAttribute('width', $width)
             ->setAttribute('height', $height ?? $width);

        return $this;
    }

    public function getSize(): array
    {
        return ['width' => $this->getAttribute('width'), 'height' => $this->getAttribute('height')];
    }

    public function getWidth(): float
    {
        return (float)$this->getAttribute('width');
    }

    public function getHeight(): float
    {
        return (float)$this->getAttribute('height');
    }

    public function setColor(string $color): self
    {
        $this->setAttribute('stroke', $color);

        return $this;
    }

    public function getColor(): string
    {
        return (string)$this->getAttribute('stroke');
    }

    public function setWeight(float $weight): self
    {
        $this->setAttribute('stroke-width', $weight);

        return $this;
    }

    public function getWeight(): float
    {
        return (float)$this->getAttribute('stroke-width');
    }

    public function setCssClass(string $class): self
    {
        $this->setAttribute('class', $class);

        return $this;
    }

    public function addCssClass(string $class): self
    {
        $this->setAttribute('class', $this->getCssClass() . ' ' . $class);

        return $this;
    }

    public function getCssClass(): string
    {
        return (string)$this->getAttribute('class');
    }
}
