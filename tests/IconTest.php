<?php

use Feather\Icon;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Xml\Loader;

class IconTest extends TestCase
{
    /**
     * @var Icon
     */
    private $icon;

    /**
     * @var string
     */
    private $iconContent = '<polyline points="0 12 24 12" />';

    protected function setUp(): void
    {
        $this->icon = new Icon('test', $this->iconContent, []);
    }

    public function testRender(): void
    {
        $iconString = \sprintf(
            '<svg class="feather feather-%s" aria-hidden="true">%s</svg>',
            $this->icon->getName(),
            $this->iconContent
        );

        $this->assertXmlStringEqualsXmlString($iconString, $this->icon->render());
    }

    public function testToString(): void
    {
        $this->assertXmlStringEqualsXmlString($this->icon->render(), (string)$this->icon);
    }

    public function testAttributeFiltering(): void
    {
        $this->icon->setAttributes(['width' => 24, 'height' => null]);

        $iconString = \sprintf(
            '<svg class="feather feather-%s" aria-hidden="true" width="24">%s</svg>',
            $this->icon->getName(),
            $this->iconContent
        );

        $this->assertXmlStringEqualsXmlString($iconString, $this->icon->render());
    }

    public function testAttributeEscaping(): void
    {
        $this->icon->setAttributes(['data-title' => 'Quote " should be escaped']);

        $iconString = \sprintf(
            '<svg class="feather feather-%s" aria-hidden="true" data-title="Quote &quot; should be escaped">%s</svg>',
            $this->icon->getName(),
            $this->iconContent
        );

        $this->assertXmlStringEqualsXmlString($iconString, $this->icon->render());
    }

    public function testAltText(): void
    {
        $iconTitleId = 'feather-icon-title';

        $this->icon->setAltText('Example alt text');

        $iconString = \sprintf(
            <<<SVG
                <svg aria-labelledby="%s" class="feather feather-%s" role="img">
                  <title id="%s">%s</title>
                  %s
                 </svg>
            SVG,
            $iconTitleId,
            $this->icon->getName(),
            $iconTitleId,
            $this->icon->getAltText(),
            $this->iconContent
        );

        $this->assertXmlStringEqualsXmlString($iconString, $this->changeSvgTitleId($this->icon->render(), $iconTitleId));
    }

    public function testSettingAttributes(): void
    {
        $attributes = [
            'data-custom-attribute' => 'test',
            'data-other-attribute' => 'test2',
            'width' => 12,
            'height' => 24,
            'stroke' => '#fff',
            'stroke-width' => 2,
            'class' => 'custom-class'
        ];

        $this->icon->setAttributes(['data-custom-attribute' => $attributes['data-custom-attribute']])
            ->setAttribute('data-other-attribute', $attributes['data-other-attribute'])
            ->setSize($attributes['width'], $attributes['height'])
            ->setColor($attributes['stroke'])
            ->setWeight($attributes['stroke-width'])
            ->setCssClass($attributes['class']);

        $this->assertEquals($attributes, $this->icon->getAttributes());
    }

    private function changeSvgTitleId(string $svg, string $id): string
    {
        $xmlLoader = new Loader();
        $iconXml = $xmlLoader->load($svg);

        $svgNode = $iconXml->firstChild;

        $labelledByAttribute = $svgNode->attributes->getNamedItem('aria-labelledby');
        $labelledByAttribute->nodeValue = $id;

        $titleNode = $svgNode->childNodes->item(0);

        $idAttribute = $titleNode->attributes->getNamedItem('id');
        $idAttribute->nodeValue = $id;

        return $iconXml->saveXML();
    }
}
