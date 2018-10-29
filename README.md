# php-feather
PHP Library for [Feather](https://feathericons.com/).

For more information on Feather itself, please refer to their [README](https://github.com/feathericons/feather).

This project is still in an early stage. Suggestions are welcome!

## Important!
This library isn't considered 'stable' yet! To use it, you need to set `minimum-stability` to `dev` in your project's composer.json!

## Installing
php-feather uses [Composer](https://getcomposer.org/). Run the following to install it.
```
composer require pixelrobin/php-feather
```
If you want to install composer without all the tests and nodejs stuff, use `--prefer-dist`.
```
composer require pixelrobin/php-feather --prefer-dist
```
Then, don't forget to autoload your Composer packages!
```php
require 'vendor/autoload.php';
```
## Usage
### Get an icon
Icons echo by default.
```php
<?php
require 'vendor/autoload.php';
$icons = new Feather\Icons;
?>

<!-- Display the 'anchor' icon !-->
<?php $icons->get('feather'); ?>

<!-- Get creative! !-->
<button class="icon-button">Learn More <?php $icons->get('arrow-right'); ?></button>
```

### Get an icon with modified properties
Simply pass an array with the attributes you want. This will be merged over the `Icons` class default attributes, except for `class`, which gets concatenated to the default classes.
```php
$icons->get('feather', array('class' => 'fooclass', 'stroke-width' => 1, 'aria-label' => 'Battery icon'));
// <svg ... class="feather feather-feather fooclass", stroke-width="1", aria-label="Battery icon" ... >...</svg>
```

You can also change the default attributes in the `Icons` class if you want some attributes consistent across multiple `get` calls. The passed attributes are merged over the current default attributes in the class by default.
```php
$icons->setAttributes(array(
    'color' => 'red',
    'stroke-width' => 3
));

$icons->get('mail');
// <svg ... color="red" stroke-width="3" ... >...</svg>
```
### Get an icon as a string
Set the third argument to `false` to get a string instead of echoing the icon.
```php
$icon_string = $icons->get('activity', array(), false);
// Then do whatever with $icon_string
```

## API
### `Feather\Icons`
Usage:
```php
$icons = new Feather\Icons;
```

<br>

### `Feather\Icons->get($name, $attributes = array(), $echo = true)`
Gets an icon as svg. Can be echoed (default) or returned as a string. Attributes passed will be merged over the class defaults.
```php
$icons = new Feather\Icons;

// Echo an icon
$icons->get('anchor');
// <svg ... >...</svg>

// Echo an icon with modified properties
$icons->get('battery', array('class' => 'fooclass', 'stroke-width' => 1, 'aria-label' => 'Battery icon'));
// <svg ... class="feather feather-battery fooclass", stroke-width="1", aria-label="Battery icon" ... >...</svg>

// Get an icon as a string without echoing it
$cloud_icon = $icons->get('cloud', array(), false);
doStuffWith($cloud_icon);
```
#### Arguments
|Argument    |Type   |Description                                                                      |
|------------|-------|---------------------------------------------------------------------------------|
|$name       |string |The name of the icon. A full list can be found [here](https://feathericons.com/).|
|$attributes?|array  |Attributes to modify/add (see 'Usage' above for example)                         |
|$echo?      |boolean|Whether to echo the icon svg (true) or not (false)                               |

<br>

### `Feather\Icons->setAttributes($attributes, $merge = true)`
Sets default attributes of the class. These are used as default attributes for the `get` method. By default, the `$attributes` argument is merged over the current default attributes in the class. You can disable this by setting the `$merge` argument to false, but only do it if you know what you are doing.
```php
$icons = new Feather\Icons;

// Set some default attributes (this will be merged with the current defaults in the class)
$icons->setAttributes(array('color' => 'red', 'stroke-width' => 3));

// Now they will be included with every icon
$icons->get('delete');
// <svg ... color="red" stroke-width="1" ... >...</svg>
```
#### Arguments
|Argument   |Type   |Description                                                                |
|-----------|-------|---------------------------------------------------------------------------|
|$attributes|array  |Attributes to add                                                          |
|$merge?    |boolean|Whether to merge with the current attributes (true) or replace them (false)|

<br>

### `Feather\Icons->getAttributes()`
Get the current default attributes for the class. To set it, use the `setAttributes()` method;
```php
$icons = new Feather\Icons;

$attrs = $icons->getAttributes();
```

<br>

### `Feather\DEFAULT_ATTRIBUTES`
Constant array of default attributes. They are applied to every new `Icons` class. You can use this to reset the attributes of an `Icons` class.
```php
$icons = new Feather\Icons;

// Add/modify some default attributes
$icons->setAttributes( ... );

// ... do some stuff ...

// Now say you want to reset the attributes you modified to the default...
// Set merge to false to overwrite instead of merge the arrays
$icons->setAttributes(Feather\DEFAULT_ATTRIBUTES, false);
```

## Contributing
Feel free to open up issues and PRs for suggesstions.

Developing requires both nodejs and composer. The icons are included as a node module and built for use in php.

Better contributing docs are coming soon!

## License
Licensed under the [MIT License](https://github.com/Pixelrobin/php-feather/blob/master/LICENSE).

The icons in this code are from [Feather](https://github.com/feathericons/feather). It is also licensed under the [MIT License](https://github.com/feathericons/feather/blob/master/LICENSE).
