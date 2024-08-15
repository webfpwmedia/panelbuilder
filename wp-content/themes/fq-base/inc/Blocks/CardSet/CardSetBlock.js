const { registerBlockType } = wp.blocks;
const { InnerBlocks, BlockAlignmentToolbar } = wp.blockEditor;
import icon from './CardSetIcon';

const TEMPLATE = [['figoli-quinn/card', {} ]];
const ALLOWED = ['figoli-quinn/card'];

registerBlockType( 'figoli-quinn/card-set', {
    title: 'Card Set',
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
                <div className={ 'card-set align' + attributes.align }>
                    <InnerBlocks template={ TEMPLATE } allowedBlocks={ ALLOWED } />
                </div>
            </div>
        );

    },

    save( { attributes } ) {

        return (
            <div>
                <div className={ 'card-set align' + attributes.align }>
                    <InnerBlocks.Content />
                </div>
            </div>
        );
    }
});