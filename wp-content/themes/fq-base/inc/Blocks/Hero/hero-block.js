const { registerBlockType } = wp.blocks;
const { InnerBlocks, RichText, BlockControls, BlockAlignmentToolbar, AlignmentToolbar, InspectorControls, PanelColorSettings } = wp.blockEditor;
const { RangeControl, PanelBody, SelectControl } = wp.components;
import { MediaElement } from '../Components/MediaElement';
import icon from './icon';

registerBlockType( 'figoli-quinn/hero', {
    title: 'Hero',
    category: 'widgets',
    icon,
    attributes: {
        caption: {
            type: 'string',
            default: '',
        },
        align: {
            type: 'string',
            default: '',
        },
        media_id: {
            type: 'integer',
        },
        media_url: {
            type: 'string',
        },
        media_alt: {
            type: 'string',
        },
        height: {
            type: 'integer',
            default: 300,
        },
        background_position: {
            type: 'string',
            default: 'center',
        },
        overlay_color: {
            type: 'string',
            default: '#000',
        },
        overlay_opacity: {
            type: 'integer',
            default: 15,
        },
        text_color: {
            type: 'string',
            default: '#fff',
        },
        text_align: {
            type: 'string',
            default: 'left',
        },
    },

    edit( { attributes, className, setAttributes, isSelected } ) {

        let onChangeMedia = function( media ) {
            setAttributes( { media_id: media.id });
            setAttributes( { media_url: media.url });
            setAttributes( { media_alt: media.alt });
        };

        return [
            <InspectorControls>
                <PanelBody title={ 'Sizing' }>
                    <RangeControl
                        key={ 'height' }
                        label={ 'height' }
                        value={ attributes.height }
                        onChange={ (value) => setAttributes({ height: value })}
                        min={ 0 }
                        max={ 1000 }
                        initialPosition={ attributes.height }
                    />
                    <SelectControl 
                        label="Background Position"
                        value={ attributes.background_position }
                        options={[
                            { label: 'Center', value: 'center' },
                            { label: 'Top', value: 'top' },
                            { label: 'Bottom', value: 'bottom' },
                            { label: 'Left', value: 'left' },
                            { label: 'Right', value: 'right' },
                        ]}
                        onChange={ (value) => setAttributes({ background_position: value }) }
                    />
                </PanelBody>
                <PanelBody title="Overlay">
                    <PanelColorSettings
                        title="Overlay Color"
                        colorSettings={ [
                            {
                                label: "Color",
                                value: attributes.overlay_color,
                                onChange: color => setAttributes({ overlay_color: color })
                            }
                        ] }
                    />
                    <RangeControl
                        key={ 'overlay_opacity' }
                        label={ 'Opacity' }
                        value={ attributes.overlay_opacity }
                        onChange={ (value) => setAttributes({ overlay_opacity: value })}
                        min={ 0 }
                        max={ 1000 }
                        initialPosition={ attributes.overlay_opacity }
                    /> 
                </PanelBody>
                <PanelBody title="Text">
                    <PanelColorSettings
                        title="Text Color"
                        colorSettings={ [
                            {
                                label: "Color",
                                value: attributes.text_color,
                                onChange: color => setAttributes({ text_color: color })
                            }
                        ] }
                    />
                </PanelBody>
            </InspectorControls>,

            <div style={ { height: attributes.height + 'px' } }>
                <BlockControls>
                    <BlockAlignmentToolbar 
                        controls={ ['wide', 'full'] }
                        onChange={ (value) => setAttributes({ align: value }) }
                    />
                    <AlignmentToolbar
                        value={ attributes.text_align }
                        onChange={ (value) => setAttributes({ text_align: value })}
                    />
                </BlockControls>
                <div class={ 'hero align' + attributes.align + ' text-' + attributes.text_align + ' bg-' + attributes.background_position }>
                    <MediaElement 
                        title="Background Image"
                        url={ attributes.media_url }
                        id={ attributes.media_id }
                        alt={ attributes.media_alt }
                        class="image"
                        onChangeMedia={ onChangeMedia } 
                    />

                    <div class="overlay-bg" style={ { backgroundColor: attributes.overlay_color, opacity: (attributes.overlay_opacity / 100)  } }></div>
                    <div class="overlay-text">
                        <div class="container">
                            <RichText
                                onChange={ (value) => setAttributes({ caption: value }) }
                                value={ attributes.caption }
                                className={ 'caption' }
                                placeholder={ 'Text here' }
                                style={ { color: attributes.text_color } }
                                keepPlaceholderOnFocus={ true }
                            />
                            <InnerBlocks />
                        </div>

                    </div>
                </div>
            </div>
        ];
    },

    save( { attributes } ) {

        return (
            <div style={ { height: attributes.height + 'px' } }>
                <div class={ 'hero align' + attributes.align + ' text-' + attributes.text_align + ' bg-' + attributes.background_position }>
                    <div class="image" style={ { backgroundImage: 'url(' + attributes.media_url + ')' } }></div>
                    <div class="overlay-bg" style={ { backgroundColor: attributes.overlay_color, opacity: (attributes.overlay_opacity / 100)  } }></div>
                    <div class="overlay-text" style={ { color: attributes.text_color } }>
                        <div class="container">
                            <div class="caption" dangerouslySetInnerHTML={ { __html: attributes.caption } }>
                            </div>
                            <InnerBlocks.Content />
                        </div>
                    </div>
                </div>
            </div>
        );
    }
});