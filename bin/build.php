<?php




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

foreach (glob(implode(DIRECTORY_SEPARATOR, [$rootDir, 'vendor', 'npm-asset', 'feather-icons', 'dist', 'icons', '*.svg'])) as $file) {
    $iconName = preg_replace('/\.svg$/i', '', basename($file));

    $icons[$iconName] = getSvgContents(file_get_contents($file));
}

writeIcons($icons);
