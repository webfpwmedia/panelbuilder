const { registerBlockType } = wp.blocks;
const { PanelBody, ToggleControl, RangeControl } = wp.components;
const { InnerBlocks, InspectorControls, BlockControls, BlockAlignmentToolbar, AlignmentToolbar } = wp.blockEditor;
import classnames from 'classnames';
import icon from './icon'

registerBlockType( 'figoli-quinn/container', {
    title: 'Container',
    category: 'layout',
    icon,
    attributes: {
        width: {
            type: 'number',
            default: 100,
        },
        hasBackground: {
            type: 'boolean',
            default: false,
        },
        contain: {
            type: 'boolean',
            default: true,
        },
        align: {
            type: 'string',
            default: 'center',
        },
        innerAlign: {
            type: 'string',
            default: 'center',
        },
    },

    edit( { attributes, className, setAttributes, isSelected } ) {

        let backgroundClasses = {
            ['align' + attributes.align]: true,
            ['inner-' + attributes.innerAlign]: true,
            'contain': attributes.contain,
        };

        if (attributes.hasBackground) {
            backgroundClasses['has-background'] = true;
        }

        let innerStyle = {};
        if (!attributes.contain) {
            innerStyle = {
                width: attributes.width + '%',
            };
        }

        return [
            <InspectorControls>
                <PanelBody title={ 'Sizing' }>
                    <ToggleControl
                        label={ 'Contain' }
                        checked={ attributes.contain }
                        onChange={ () => setAttributes({ contain: !attributes.contain})}
                    />
                    <RangeControl
                        key={ 'width' }
                        label={ 'Width' }
                        value={ attributes.width }
                        onChange={ (value) => setAttributes({ width: value })}
                        min={ 0 }
                        max={ 100 }
                        initialPosition={ attributes.width }
                    />
                </PanelBody>
                <PanelBody title={ 'Background' }>
                    <ToggleControl
                        label={ 'Use colored background' }
                        checked={ attributes.hasBackground }
                        onChange={ () => setAttributes({ hasBackground: !attributes.hasBackground})}
                    />
                </PanelBody>
            </InspectorControls>,

            <div className={ classnames(backgroundClasses) }>
                <BlockControls>
                    <BlockAlignmentToolbar
                        controls={ ['center', 'wide', 'full'] }
                        value={ attributes.align }
                        onChange={ (value) => setAttributes({ align: value }) }
                    />
                    <AlignmentToolbar
                        value={ attributes.innerAlign }
                        onChange={ (value) => setAttributes({ innerAlign: value })}
                    />
                </BlockControls>
                <div className={ 'inner' }>
                    <div className={ 'content' } style={ innerStyle }>
                        <InnerBlocks />
                    </div>
                </div>
            </div>
        ];
    },

    save( { attributes } ) {

        let backgroundClasses = {
            ['align' + attributes.align]: true,
            ['inner-' + attributes.innerAlign]: true,
            'contain': attributes.contain,
        };

        if (attributes.hasBackground) {
            backgroundClasses['has-background'] = true;
        }

        let innerStyle = {};
        if (!attributes.contain) {
            innerStyle = {
                width: attributes.width + '%',
            };
        }

        return (
            <div className={ classnames(backgroundClasses) }>
                <div className={ 'inner' }>
                    <div className={ 'content' } style={ innerStyle }>
                        <InnerBlocks.Content />
                    </div>
                </div>
            </div>
        );
    }
});