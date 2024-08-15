const { registerBlockType } = wp.blocks;
const { InnerBlocks, BlockAlignmentToolbar } = wp.blockEditor;
import icon from './DownloadsSetIcon';

const TEMPLATE = [['figoli-quinn/pdf-download', {} ]];
const ALLOWED = ['figoli-quinn/pdf-download'];

registerBlockType( 'figoli-quinn/downloads-set', {
    title: 'Downloads',
    category: 'widgets',
    icon,
    attributes: {
        align: {
            type: 'string',
            default: '',
        },
    },

    edit( { attributes, className, setAttributes, isSelected } ) {

        return (
            <div>
                <BlockAlignmentToolbar
                    controls={ ['wide', 'full'] }
                    value={ attributes.align }
                    onChange={ (value) => setAttributes({ align: value }) }
                />
                <div className={ 'downloads-set align' + attributes.align }>
                    <InnerBlocks template={ TEMPLATE } allowedBlocks={ ALLOWED } />
                </div>
            </div>
        );

    },

    save( { attributes } ) {

        return (
            <div>
                <div className={ 'downloads-set align' + attributes.align }>
                    <InnerBlocks.Content />
                </div>
            </div>
        );
    }
});