import icon from './MediaContainerIcon';
import { get } from 'lodash';
const { Component } = wp.element;
const { BlockControls, BlockIcon, MediaUpload, MediaPlaceholder } = wp.blockEditor;
const { Toolbar, IconButton, ResizableBox } = wp.components;

const ALLOWED_MEDIA_TYPES = [ 'image' ];

export class MediaElement extends Component {

    constructor(props) {
        super(...arguments);
        this.props = props;
    }

    render() {

        let media_element = this.render_media_element();

        return (
            <div className={ 'media-element ' + this.props.title }>
                { media_element }
            </div>
        );
    }

    // Render the media element (placeholder or actual image).
    render_media_element() {
        // If we have an image to use.
        if (this.props.url) {
            return this.render_media();
        }

        // Otherwise, use the placeholder selector.
        return this.render_media_placeholder();
    }

    // Render the actual image.
    render_media() {

        let innerMediaElement = (
            <div 
                style={ { cursor: 'pointer', backgroundImage: 'url(' + this.props.url + ')' } } 
                className={ this.props.class != undefined ? this.props.class : '' } 
            ></div>
        );

        if (this.props.tagName == 'img') {
            innerMediaElement = (
                <img src={ this.props.url } className={ this.props.class != undefined ? this.props.class : '' } />
            );
        }
        
        let media_element = (
            <MediaUpload
                onSelect={ (media) => this.on_select_media(media) }
                allowedTypes={ ALLOWED_MEDIA_TYPES }
                value={ this.props.id }
                render={ ( { open } ) => (
                    <div onClick={ open }>
                        { innerMediaElement }
                    </div>
                ) }
            />
        );

        return (
            <ResizableBox
                className="editor-media-container__resizer"
                size={ { width: '100%' } }
                minWidth="100%"
                maxWidth="100%"
                axis="x"
            >
                { media_element }
            </ResizableBox>
        );
    }

    // Render the toolbar edit.
    render_toolbar_edit_button() {
        return (
            <BlockControls>
                <Toolbar>
                    <MediaUpload
                        onSelect={ (media) => this.on_select_media(media) }
                        allowedTypes={ ALLOWED_MEDIA_TYPES }
                        value={ this.props.id }
                        render={ ( { open } ) => (
                            <IconButton
                                className="components-toolbar__control"
                                label={ ' Edit ' + this.props.title }
                                icon="edit"
                                onClick={ open }
                            />
                        ) }
                    />
                </Toolbar>
            </BlockControls>
        );
    }

    // After selecting an image.
    on_select_media(media) {
        let src = get( media, [ 'sizes', 'large', 'url' ] ) || get( media, [ 'media_details', 'sizes', 'large', 'source_url' ] );
        this.props.onChangeMedia(media);
    }

    // Render the placeholder for selecting an image to use.
    render_media_placeholder() {
        return (
            <MediaPlaceholder
                icon={ <BlockIcon icon={ icon } /> }
                labels={ {
                    title: this.props.title + ' area',
                } }
                onSelect={ (media) => this.on_select_media(media) }
                accept="image/*"
                allowedTypes={ ALLOWED_MEDIA_TYPES }
            />
        );
    }

}