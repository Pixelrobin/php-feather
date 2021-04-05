<?php

function getSvgAttributes(string $svg): array
{
    $attributes = [];

    $icon = new SimpleXMLElement($svg);

    $xmlNamespaces = $icon->getDocNamespaces();

    $attributes['xmlns'] = array_shift($xmlNamespaces);

    foreach ($icon->attributes() as $attribute => $value) {
        $attributes[(string)$attribute] = (string)$value;
    }

    unset($attributes['class']);

    return $attributes;
}

function getSvgContents(string $svg): string
{
    $icon = new SimpleXMLElement($svg);

    $doc = new DOMDocument('1.0', 'UTF-8');

    $dom = dom_import_simplexml($icon);
    $dom = $doc->importNode($dom, true);

    $doc->appendChild($dom);

    $svgContents = '';

    foreach ($doc->getElementsByTagName('svg')[0]->childNodes as $node) {
        $svgContents .= $doc->saveXML($node, LIBXML_NOEMPTYTAG);
    }

    return $svgContents;
}

function writeAttributes(array $attributes): void
{
    global $rootDir;

    $export = var_export($attributes, true);

    file_put_contents(
        implode(DIRECTORY_SEPARATOR, [$rootDir, 'src', 'defaultAttributes.php']),
        <<<EOT
    <?php

    /* !!! THIS FILE IS AUTO-GENERATED !!! */

    namespace Feather;

    const DEFAULT_ATTRIBUTES = $export;

    EOT
    );
}

function writeIcons(array $icons): void
{
    global $rootDir;

    $export = var_export($icons, true);

    file_put_contents(
        implode(DIRECTORY_SEPARATOR, [$rootDir, 'resources', 'icons.php']),
        <<<EOT
    <?php

    return $export;

    EOT
    );
}

$rootDir = implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), '..']);

$icons = [];

$defaultAttributes = null;

foreach (glob(implode(DIRECTORY_SEPARATOR, [$rootDir, 'vendor', 'npm-asset', 'feather-icons', 'dist', 'icons', '*.svg'])) as $file) {
    $iconName = preg_replace('/\.svg$/i', '', basename($file));

    if (null === $defaultAttributes) {
        $defaultAttributes = getSvgAttributes(file_get_contents($file));
    }

    $icons[$iconName] = getSvgContents(file_get_contents($file));
}

writeAttributes($defaultAttributes);
writeIcons($icons);
