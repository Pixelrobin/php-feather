const feather = require('feather-icons');
const fs      = require('fs');
const path    = require('path');

// To test default xml output

const testData = Object.keys(feather.icons)
                       .map(key => {
                           return {name: key, xml: feather.icons[key].toSvg()};
                       });

fs.writeFileSync(
    path.resolve(__dirname, 'XMLTestData.json'),
    JSON.stringify(testData)
);

// To test custom attribute output
// Should it check every icon? I'm not sure of the best way to test this.

const testAttributes = {
    'stroke-width': 1,
    'color'       : 'red',
    'aria-hidden' : true,
    'class'       : 'classymcclassface'
};

const testAttributeIcon = 'feather';

const testAttributeData = {
    name      : 'feather',
    attributes: testAttributes,
    xml       : feather.icons.feather.toSvg(testAttributes)
};

fs.writeFileSync(
    path.resolve(__dirname, 'AttributeTestData.json'),
    JSON.stringify(testAttributeData)
);
