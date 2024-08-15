const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.blockEditor;
import icon from './timeline-icon';

const TEMPLATE = [['figoli-quinn/timeline-date', {} ]];
const ALLOWED = ['figoli-quinn/timeline-date'];

registerBlockType( 'figoli-quinn/timeline', {
    title: 'Timeline',
    category: 'widgets',
    icon,

    edit( { attributes, className, setAttributes, isSelected } ) {

        return (
            <div>
                <div class="timeline">
                    <InnerBlocks template={ TEMPLATE } allowedBlocks={ ALLOWED } />
                </div>
            </div>
        );

    },

    save( { attributes } ) {

        return (
            <div>
                <div class="timeline">
                    <InnerBlocks.Content />
                </div>
            </div>
        );
    }
});