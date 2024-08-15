const { registerBlockType } = wp.blocks;
const { RichText, InnerBlocks, InspectorControls, URLInput } = wp.blockEditor;
const { PanelBody, ToggleControl } = wp.components;
import { MediaElement } from '../Components/MediaElement';
import icon from './CardIcon';

const TEMPLATE = [['core/button', {}]];

registerBlockType( 'figoli-quinn/card', {
    title: 'Card',
    category: 'widgets',
    icon,
    parent: ['core/group'],
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
        title: {
            type: 'string',
            default: '',
        },
        hasButton: {
            type: 'boolean',
            default: true,
        },
        imageLinkUrl: {
            type: 'string',
            default: '',
        },
    },

    edit( { attributes, className, setAttributes, isSelected } ) {

        let onChangeMedia = function( media ) {
            setAttributes({ 
                media_id: media.id, 
                media_url: media.url, 
                media_alt: media.alt, 
            });
        };

        let buttonElement = null;
        if ( attributes.hasButton ) {
            buttonElement = (
                <InnerBlocks
                    template={ TEMPLATE }
                />
            );
        }

        return [
            <InspectorControls>
                <PanelBody title="Image">
                    <URLInput
                        value={ attributes.imageLinkUrl }
                        onChange={ (value) => setAttributes({ imageLinkUrl: value }) }
                    />
                </PanelBody>
                <PanelBody title="Button">
                    <ToggleControl
                        label={ 'Has Button' }
                        checked={ attributes.hasButton }
                        onChange={ () => setAttributes({ hasButton: !attributes.hasButton }) }
                    />
                </PanelBody>
            </InspectorControls>,

            <div className={ 'fq-card' }>
                <div class="image">
                    <MediaElement 
                        title="Background Image"
                        url={ attributes.media_url }
                        id={ attributes.media_id }
                        alt={ attributes.media_alt }
                        class="image"
                        tagName="img"
                        onChangeMedia={ onChangeMedia } 
                    />
                </div>

                <RichText
                    onChange={ (value) => setAttributes({ title: value }) }
                    value={ attributes.title }
                    className={ 'title' }
                    placeholder={ 'Title here' }
                    keepPlaceholderOnFocus={ true }
                />

                { buttonElement }
            </div>
        ];
    },

    save( { attributes } ) {

        let buttonElement = null;
        if ( attributes.hasButton ) {
            buttonElement = (
                <InnerBlocks.Content />
            );
        }

        let imageElement = null;
        if (attributes.imageLinkUrl == '') {
            imageElement = (
                <img src={ attributes.media_url } alt={ attributes.media_alt }/>
            );
        } else {
            imageElement = (
                <a href={ attributes.imageLinkUrl }>
                    <img src={ attributes.media_url } alt={ attributes.media_alt }/>
                </a>
            );
        }

        return (
            <div className={ 'fq-card'}>
                <div class="image">
                    { imageElement }
                </div>
                <p class="title">{ attributes.title }</p>
                { buttonElement }
            </div> 
        );
    }
});
