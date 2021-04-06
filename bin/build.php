<?php

$rootDir = implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), '..']);

$icons = [];

foreach (glob(implode(DIRECTORY_SEPARATOR, [$rootDir, 'icons', '*.svg'])) as $file) {
    $iconName     = preg_replace('/\.svg$/i', '', basename($file));
    $iconContents = file_get_contents($file);

    $icons[$iconName] = $iconContents;
}

$export = var_export($icons, true);

file_put_contents(
    implode(DIRECTORY_SEPARATOR, [$rootDir, 'resources', 'icons.php']),
    <<<EOT
    <?php

    return $export;
    EOT
);
