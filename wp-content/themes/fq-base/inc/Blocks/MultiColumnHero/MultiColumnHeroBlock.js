const { registerBlockType } = wp.blocks;
const { InnerBlocks, BlockControls, BlockAlignmentToolbar } = wp.blockEditor;
import { MediaElement } from '../Components/MediaElement';

const TEMPLATE = [
    [
        'core/heading', {
            level: 1,
            content: 'Title here',
        }
    ],
    [
        'core/paragraph', {
            content: 'Description here',
        }
    ] ,
];

registerBlockType( 'figoli-quinn/multi-column-hero', {
    title: 'Multi-Column Hero',
    category: 'widgets',
    attributes: {
        image1_media_id: {
            type: 'integer',
        },
        image1_media_url: {
            type: 'string',
        },
        image1_media_alt: {
            type: 'string',
        },
        image2_media_id: {
            type: 'integer',
        },
        image2_media_url: {
            type: 'string',
        },
        image2_media_alt: {
            type: 'string',
        },
        align: {
            type: 'string',
            default: '',
        },
    },

    edit( { attributes, className, setAttributes } ) {

        let updateMedia = function( index, media ) {
            setAttributes({
                ['image' + index + '_media_id']: media.id,
                ['image' + index + '_media_url']: media.url,
                ['image' + index + '_media_alt']: media.alt,
            });
        };
        
        return (
            <div>
                <BlockControls>
                    <BlockAlignmentToolbar
                        controls={ ['wide', 'full'] }
                        onChange={ (value) => setAttributes({ align: value }) }
                    />
                </BlockControls>
                <div className={ 'multi-column-hero align' + attributes.align }>
                    <div class="image">
                        <MediaElement
                            title="Image"
                            url={ attributes.image1_media_url }
                            id={ attributes.image1_media_id }
                            alt={ attributes.image1_media_alt }
                            onChangeMedia={ (media) => updateMedia('1', media) }
                        />
                    </div>

                    <div class="text">
                        <InnerBlocks
                            template={ TEMPLATE }
                        />
                    </div>

                    <div class="image">
                        <MediaElement
                            title="Image"
                            url={ attributes.image2_media_url }
                            id={ attributes.image2_media_id }
                            alt={ attributes.image2_media_alt }
                            onChangeMedia={ (media) => updateMedia('2', media) }
                        />
                    </div>
                </div>
            </div>
        )
    },

    save( { attributes } ) {

        return (
            <div>
                <div className={ 'multi-column-hero align' + attributes.align }>
                    <div class="image">
                        <div style={ { backgroundImage: 'url(' + attributes.image1_media_url + ')' } }></div>
                    </div>
                    <div class="text">
                        <InnerBlocks.Content />
                    </div>
                    <div class="image">
                        <div style={ { backgroundImage: 'url(' + attributes.image2_media_url + ')' } }></div>
                    </div>
                </div>
            </div>
        );
    },
})