const { registerBlockType } = wp.blocks;
const { RichText, BlockControls, BlockAlignmentToolbar, AlignmentToolbar, InspectorControls, PanelColorSettings } = wp.blockEditor;
const { RangeControl, PanelBody } = wp.components;
import { MediaElement } from '../Components/MediaElement'
import icon from './image-reference-icon'

registerBlockType( 'figoli-quinn/image-reference', {
    title: 'Image Reference',
    category: 'widgets',
    parent: ['core/group'],
    icon,
    attributes: {
        media_id: {
            type: 'integer',
        },
        media_url: {
            type: 'string',
        },
        media_alt: {
            type: 'string',
        },
        description: {
            type: 'string',
            default: '',
        },
    },

    edit( { attributes, className, setAttributes, isSelected } ) {

        let onChangeMedia = function( media ) {
            setAttributes( { media_id: media.id });
            setAttributes( { media_url: media.sizes.thumbnail.url });
            setAttributes( { media_alt: media.alt });
        };

        return [
            <div style={ { height: attributes.height + 'px' } }>
                <div className="image">
                    <MediaElement
                        title="Background Image"
                        url={ attributes.media_url }
                        id={ attributes.media_id }
                        alt={ attributes.media_alt }
                        tagName="img"
                        class="image"
                        onChangeMedia={ onChangeMedia }
                    />
                </div>

                <div className="caption">
                    <RichText
                        onChange={ (value) => setAttributes({ description: value }) }
                        value={ attributes.description }
                        className={ 'caption' }
                        placeholder={ 'Text here' }
                        keepPlaceholderOnFocus={ true }
                    />
                </div>
            </div>
        ];

    },

    save( { attributes } ) {

        return (
            <div>
                <div className="image">
                    <img src={ attributes.media_url } alt={ attributes.media_alt }/>

                    <div class="caption">
                        <div dangerouslySetInnerHTML={{__html: attributes.description }}></div>
                    </div>
                </div>
            </div>
        );
    }
});
