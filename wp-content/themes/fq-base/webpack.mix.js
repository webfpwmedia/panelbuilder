const mix = require('laravel-mix');

mix.webpackConfig({
    externals: {
        'lodash': 'lodash'
    }
});

mix.sass('./sass/style.scss', './style.css')
    .sass('./sass/editor.scss', './editor.css')
    .options({
        processCssUrls: false,
		cssNano: { minifyFontValues: false }
    })
    .react([
        './inc/Blocks/Container/container-block.js',
        './inc/Blocks/Stat/stat-block.js',
        './inc/Blocks/Timeline/timeline-date-block.js',
        './inc/Blocks/Timeline/timeline-block.js',
        './inc/Blocks/Hero/hero-block.js',
        './inc/Blocks/ProgressStat/progress-stat-block.js',
        './inc/Blocks/ImageReferenceGroup/image-reference-group-block.js',
        './inc/Blocks/ImageReferenceGroup/image-reference-block.js',
        './inc/Blocks/MultiColumnHero/MultiColumnHeroBlock.js',
        './inc/Blocks/CardSet/CardBlock.js',
        './inc/Blocks/CardSet/CardSetBlock.js',
        './inc/Blocks/BreakoutImage/BreakoutImageBlock.js',
        './inc/Blocks/Tabs/TabsBlock.js',
        './inc/Blocks/Tabs/TabBlock.js',
        './inc/Blocks/PdfDownload/DownloadsSetBlock.js',
        './inc/Blocks/PdfDownload/DownloadBlock.js',
    ], './js/blocks/blocks-editor-blocks.js')
    .js([
        './inc/Blocks/Tabs/TabsFrontEnd.js',
    ], './js/blocks/blocks-editor-blocks-front-end.js')
    .js([
        './js/breadcrumbs.js',
        './js/theme.js',
        './js/gallery.js',
        './js/swatchlibrary.js',
        './js/panelsequences.js',
    ], './js/dist/theme.js');
