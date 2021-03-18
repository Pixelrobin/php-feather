const feather = require('feather-icons');
const fs      = require('fs');
const path    = require('path');

const outPath = path.resolve(__dirname, '../icons');
let defaultAttrs = null;

Object.keys(feather.icons)
	.forEach(key => {
		const { name, contents, attrs } = feather.icons[key];

		if (defaultAttrs === null) {
			defaultAttrs = attrs;
		}

		fs.writeFileSync(path.resolve(outPath, name + '.svg'), contents);
	});

delete defaultAttrs.class;

let php = Object.keys(defaultAttrs)
	.map(key => `'${ key }' => '${ defaultAttrs[key] }'`)
	.reduce((final, current) => final + current + ',', '');

php = '<?php\n\n'
	+ '/* !!! THIS FILE IS AUTO-GENERATED !!! */\n\n'
	+ 'namespace Feather; const DEFAULT_ATTRIBUTES = array('
	+ php.substring(0, php.length - 1)
	+ ');';

fs.writeFileSync(path.resolve(__dirname, '../src/defaultAttributes.php'), php);
