const { registerBlockType } = wp.blocks;
const { InspectorControls, InnerBlocks } = wp.blockEditor;
const { PanelBody, TextControl } = wp.components;

registerBlockType( 'figoli-quinn/tab', {
    title: 'Tab',
    category: 'widgets',
    parent: ['core/group'],
    attributes: {
        title: {
            type: 'string',
            default: '',
        },
        visible: {
            type: 'boolean',
            default: true,
        }
    },

    edit( { attributes, className, setAttributes, isSelected } ) {

        return [
            <div className={ 'tab' + (attributes.visible ? ' active' : '')}>
                <InnerBlocks />
            </div>
        ];
    },

    save( { attributes } ) {
        
        return (
            <div className="tab">
                <InnerBlocks.Content />
            </div>
        );
    }
});
