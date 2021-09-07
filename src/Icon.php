<?php

namespace Feather;

class Icon
{
    use SvgAttributesTrait;

    private $name;

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

                $attributeValue = $this->escapeString((string)$attributeValue);

                return \sprintf('%s %s="%s"', $final, $current, $attributeValue);
            },
            ''
        );

        return '<svg ' . $svgAttributes . '>' . $this->content . '</svg>';
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
