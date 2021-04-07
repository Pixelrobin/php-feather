<?php

namespace Feather;

class Icon
{
    private $name;

    private $attributes;

    private $content;

    public function __construct(string $name, array $attributes, string $content)
    {
        $this->name       = $name;
        $this->attributes = $attributes;
        $this->content    = $content;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function render(): string
    {
        $attributes = $this->filterAttributes($this->attributes);

        $svgAttributes = \array_reduce(
            \array_keys($attributes),
            function ($final, $current) use ($attributes): string {
                $attributeValue = $attributes[$current];

                if (\is_bool($attributeValue)) {
                    $attributeValue = $attributeValue ? 'true' : 'false';
                }

                $attributeValue = \htmlspecialchars((string)$attributeValue, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false);

                return \sprintf('%s %s="%s"', $final, $current, $attributeValue);
            },
            ''
        );

        return '<svg ' . $svgAttributes . '>' . $this->content . '</svg>';
    }

    private function filterAttributes(array $attributes): array
    {
        return \array_filter(
            $attributes,
            function ($item): bool {
                return $item !== null;
            }
        );
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
