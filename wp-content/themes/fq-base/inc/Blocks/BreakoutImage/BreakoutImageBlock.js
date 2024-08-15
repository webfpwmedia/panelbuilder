const { registerBlockType } = wp.blocks;
const { InnerBlocks, InspectorControls } = wp.blockEditor;
const { RangeControl, PanelBody, ToggleControl } = wp.components;
import icon from './Icon';

const TEMPLATE = [['core/image', {} ]];
const ALLOWED = ['core/image'];

registerBlockType( 'figoli-quinn/breakout-image', {
    title: 'Breakout Image',
    category: 'widgets',
    icon,
    attributes: {
        top: {
            type: 'integer',
            default: 0,
        },
        bottom: {
            type: 'integer',
            default: 0,
        },
        left: {
            type: 'integer',
            default: 0,
        },
        right: {
            type: 'integer',
            default: 0,
        },
        hide_on_mobile: {
            type: 'boolean',
            default: true,
        },
    },

    edit( { attributes, className, setAttributes, isSelected } ) {

        let style = {
            top: attributes.top + '%',
            bottom: attributes.bottom + '%',
            left: attributes.left + '%',
            right: attributes.right + '%',
        };

        return [
            <InspectorControls>
                <PanelBody title="Position">
                    <ToggleControl
                        label="Hide on Mobile"
                        checked={ attributes.hide_on_mobile }
                        onChange={ () => setAttributes({ hide_on_mobile: !attributes.hide_on_mobile}) }
                    />
                    <RangeControl 
                        key="top"
                        label="Top"
                        value={ attributes.top }
                        onChange={ (value) => setAttributes({ top: value }) }
                        min={ -200 }
                        max={ 200 }
                        initialPosition={ attributes.top }
                    />
                    <RangeControl 
                        key="bottom"
                        label="Bottom"
                        value={ attributes.bottom }
                        onChange={ (value) => setAttributes({ bottom: value }) }
                        min={ -200 }
                        max={ 200 }
                        initialPosition={ attributes.bottom }
                    />
                    <RangeControl 
                        key="left"
                        label="Left"
                        value={ attributes.left }
                        onChange={ (value) => setAttributes({ left: value }) }
                        min={ -200 }
                        max={ 200 }
                        initialPosition={ attributes.left }
                    />
                    <RangeControl 
                        key="right"
                        label="Right"
                        value={ attributes.right }
                        onChange={ (value) => setAttributes({ right: value }) }
                        min={ -200 }
                        max={ 200 }
                        initialPosition={ attributes.right }
                    />
                </PanelBody>
            </InspectorControls>,

            <div>
                <div className={ 'breakout-image' + (attributes.hide_on_mobile ? ' hide-on-mobile' : '') }>
                    <div style={ style }>
                        <InnerBlocks 
                            template={ TEMPLATE } 
                            allowedBlocks={ ALLOWED } 
                            renderAppender={() => {
                                const blocks = wp.data.select( 'core/block-editor' ).getBlocks;
                                const block = find(blocks, ['name', 'image']);
                                // don't return appender if there's one or more blocks:
                                if (block && block.innerBlocks.length > 0) return null;
                                // otherwise, return default appender
                                return (<InnerBlocks.DefaultBlockAppender />);
                            }}
                        />
                    </div>
                </div>
            </div>
        ];

    },

    save( { attributes } ) {

        let style = {
            top: attributes.top,
            bottom: attributes.bottom,
            left: attributes.left,
            right: attributes.right,
        };

        return (
            <div>
                <div className={ 'breakout-image' + (attributes.hide_on_mobile ? ' hide-on-mobile' : '') }>
                    <div style={ style }>
                        <InnerBlocks.Content />
                    </div>
                </div>
            </div>
        );
    }
});