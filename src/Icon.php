<?php

namespace Feather;

class Icon
{
    use SvgAttributesTrait;

    private $name;

    private $content;

    private $altText;

    public function __construct(string $name, string $content, array $attributes = [], ?string $altText = null)
    {
        $this->name       = $name;
        $this->content    = $content;
        $this->attributes = $attributes;
        $this->altText    = $altText;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setAltText(?string $altText): self
    {
        $this->altText = $altText;

        return $this;
    }

    public function getAltText(): ?string
    {
        return $this->altText;
    }

    public function render(): string
    {
        $altText    = '';
        $attributes = $this->filterAttributes($this->attributes);

        if (!empty($this->altText)) {
            $uniqId = \uniqid($this->getName());

            $attributes['role']            = $attributes['role'] ?? 'img';
            $attributes['aria-labelledby'] = $uniqId;
            $altText                       = \sprintf('<title id="%s">%s</title>', $this->escapeString($uniqId), $this->escapeString((string)$this->getAltText()));
        } else {
            $attributes['aria-hidden'] = true;
        }

        $svgAttributes = \array_reduce(
            \array_keys($attributes),
            function ($final, $current) use ($attributes): string {
                $attributeValue = $attributes[$current];

                if (\is_bool($attributeValue)) {
                    $attributeValue = $attributeValue ? 'true' : 'false';
                }

                $attributeValue = $this->escapeString((string)$attributeValue);

                return \sprintf('%s %s="%s"', $final, $current, $attributeValue);
            },
            ''
        );

        return '<svg ' . $svgAttributes . '>' . $altText . $this->content . '</svg>';
    }

    private function filterAttributes(array $attributes): array
    {
        $classes = [
            'feather',
            'feather-' . $this->getName(),
            (string)($attributes['class'] ?? ''),
        ];

        $attributes['class'] = \trim(\implode(' ', $classes));

        return \array_filter(
            $attributes,
            function ($item): bool {
                return $item !== null;
            }
        );
    }

    private function escapeString(string $string): string
    {
        return \htmlspecialchars($string, \ENT_QUOTES | \ENT_SUBSTITUTE, 'UTF-8', false);
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
