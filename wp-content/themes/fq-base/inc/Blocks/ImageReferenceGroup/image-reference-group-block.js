const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.blockEditor;
import icon from './image-reference-group-icon';

const TEMPLATE = [['figoli-quinn/image-reference', {} ]];
const ALLOWED = ['figoli-quinn/image-reference'];

registerBlockType( 'figoli-quinn/image-reference-group', {
    title: 'Image Reference Group',
    category: 'widgets',
    icon,

    edit( { attributes, className, setAttributes, isSelected } ) {

        return (
            <div>
                <div class="image-reference-group">
                    <InnerBlocks template={ TEMPLATE } allowedBlocks={ ALLOWED } />
                </div>
            </div>
        );

    },

    save( { attributes } ) {

        return (
            <div>
                <div class="image-reference-group">
                    <InnerBlocks.Content />
                </div>
            </div>
        );
    }
});