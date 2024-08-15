const mix = require('laravel-mix');

mix.react([
    './Blocks/PanelBuilder/panelbuilder-block.js'
], './dist/blocks.js');

mix.react([
    './Blocks/PanelBuilder/panel-builder-front-end.js'
], './dist/blocks-front-end.js');