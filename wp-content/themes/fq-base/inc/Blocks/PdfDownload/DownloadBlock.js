import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import icon from './DownloadIcon';
const { registerBlockType } = wp.blocks;
const { Button } = wp.components;
const { 
    MediaUploadCheck,
    MediaUpload,
    PlainText,
} = wp.blockEditor;

registerBlockType( 'figoli-quinn/pdf-download', {
    title: __( 'PDF Download' ),
    description: __( 'Link an image thumbnail to a downloadable PDF or other media file.' ),
    category: 'widgets',
    icon,
    keywords: [ __( 'pdf' ), __( 'resource' ), __( 'download' ) ],
    parent: [ 'figoli-quinn/downloads-set' ],
    attributes: {
        title: {
            type: 'string',
            default: '',
            selector: '.download-title',
        },
        downloadID: {
            type: 'string',
            default: '',
            source: 'attribute',
			selector: '.download-link',
			attribute: 'data-id',
        },
        downloadURL: {
			type: 'string',
			default: '',
			source: 'attribute',
			selector: '.download-link',
			attribute: 'href',
        },
        downloadFilename: {
            type: 'string',
			default: '',
			source: 'attribute',
            selector: '.download-link',
            attribute: 'data-file',
        },
        thumbnailID: {
            type: 'string',
            default: '',
            source: 'attribute',
			selector: '.download-thumbnail',
			attribute: 'data-id',
        },
        thumbnailURL: {
			type: 'string',
			default: '',
			source: 'attribute',
			selector: '.download-thumbnail',
			attribute: 'src',
        },
        thumbnailAlt: {
			type: 'string',
			default: '',
			selector: '.download-thumbnail',
			attribute: 'alt',
        },
    },

    edit: props => {

        const {
            attributes: {
                downloadID,
                downloadURL,
                downloadFilename,
                thumbnailID,
                thumbnailURL,
                title
            },
            className,
            setAttributes,
            isSelected,
        } = props;

        const onUpdateThumbnail = ( image ) => {
            setAttributes( {
                thumbnailID: image.id,
                thumbnailURL: image.sizes.medium.url,
                thumbnailAlt: image.alt,
            } );
        };

        const onUpdateDownload = ( file ) => {
            setAttributes( {
                downloadID: file.id,
                downloadURL: file.url,
                downloadFilename: file.filename,
            } );
        };
        
        const removeThumbnail = event => {
			setAttributes(
				{
					thumbnailID: '',
					thumbnailURL: '',
					thumbnailAlt: ''
				}
			);
        };
        
        const removeDownload = event => {
			setAttributes(
				{
					downloadID: '',
                    downloadURL: '',
                    downloadFilename: '',
				}
			);
		};

        const blockClassNames = classnames( {
            [ className ]: className
        } );

        const imageRemoveButton = isSelected => {

			if ( ! isSelected ) {
				return null;
			} else {
				return (
					<Button
						onClick={ removeThumbnail }
						className="button remove"
					>
						X
					</Button>
				);
			}
        }

        const fileRemoveButton = isSelected => {

			if ( ! isSelected ) {
				return null;
			} else {
				return (
					<Button
						onClick={ removeDownload }
						className="button remove"
					>
						X
					</Button>
				);
			}
        }
        
        const renderThumbnail = isSelected => {

				if ( thumbnailID ) {

					return (
                        <div className="download-thumbnail-wrapper">
                            { imageRemoveButton( isSelected ) }
							<img
								data-id={ thumbnailID }
								src={ thumbnailURL }
								className="download-thumbnail"
							/>
                        </div>
					);

				} else {

					return (
                        <MediaUploadCheck fallback={ __( 'You do not have media upload privileges.' ) }>
                            <MediaUpload
                                title={ __( 'Thumbnail image' ) }
                                onSelect={ onUpdateThumbnail }
                                allowedTypes={ ['image'] }
                                value={ thumbnailID }
                                render={ ( { open } ) => (
                                    <Button
                                        className={ 'button thumbnail-image__select' }
                                        onClick={ open }>
                                        { __( 'Set thumbnail image' ) }
                                    </Button>
                                ) }
                            />
                        </MediaUploadCheck>
					);
				}
        }
        
        const renderDownloadFile = isSelected => {

            if ( downloadID && isSelected ) {

                return (
                    <div className="download-link-wrapper">
                        { fileRemoveButton( isSelected ) }
                        <div className="download-link-reference">
                            <a href={ downloadURL }
                                className="download-link"
                                target="_blank"
                                rel="noopener noreferrer"            
                                data-id={ downloadID }
                                data-file={ downloadFilename }
                            >
                                { downloadFilename }
                            </a>
                        </div>
                    </div>
                );

            } else if ( ! downloadID ) {

                return (
                    <MediaUploadCheck fallback={ __( 'You do not have media upload privileges.' ) }>
                        <MediaUpload
                            title={ __( 'Downloadable file' ) }
                            onSelect={ onUpdateDownload }
                            allowedTypes={ ['application/pdf'] }
                            value={ downloadID }
                            render={ ( { open } ) => (
                                <Button
                                    className={ 'button download-file__select' }
                                    onClick={ open }>
                                    { __( 'Select download file' ) }
                                </Button>
                            ) }
                        />
                    </MediaUploadCheck>
                );
            } else {
                return null;
            }
        }
        
        return [
            <div id={ 'download-' + downloadID } className={ blockClassNames }>
                <div className="thumbnail-image-selector">
                    { renderThumbnail( isSelected ) }
                </div>
                <div className="download-file-selector">
                    { renderDownloadFile( isSelected ) }
                </div>
                <h4 className="download-file-title-input">
                    <PlainText
						className="download-title"
						value={ title }
						onChange={ content => setAttributes( { title: content } ) }
						placeholder="Document name ..."
					/>
                </h4>
            </div>
        ];
    },

    save: props => {

        const {
            attributes: {
                downloadID,
                downloadURL,
                downloadFilename,
                thumbnailID,
                thumbnailURL,
                thumbnailAlt,
                title
            },
            className
        } = props;

        let wpImageClass = null;
        if ( thumbnailID ) {
            wpImageClass = 'wp-image-' + thumbnailID;
        }

        const thumbnailClassNames = classnames( {
			'download-thumbnail': true,
			[ wpImageClass ]: wpImageClass,
        } );
        
        const linkClassNames = classnames( {
			'download-link': true,
		} );

        const thumbnailImage = () => {

			if ( ! thumbnailID || ! thumbnailURL ) {

				return null;

			} else {

				if ( thumbnailAlt ) {
					return (
						<img
							className={ thumbnailClassNames }
                            data-id={ thumbnailID }
							src={ thumbnailURL }
							alt={ thumbnailAlt }
						/>
					);
				} else {
                    // No alt set, so let's hide it from screen readers
                    return (
                        <img
                            className={ thumbnailClassNames }
                            data-id={ thumbnailID }
                            src={ thumbnailURL }
                            alt=""
                            aria-hidden="true"
                        />
                    );
                }
			}
        };

        return (
            <div id={ 'download-' + downloadID } className={ className }>
                <a
                    href={ downloadURL }
                    target="_blank"
                    rel="noopener noreferrer"
                    className={ linkClassNames }
                    data-id={ downloadID }
                    data-file={ downloadFilename }
                >
                    { thumbnailImage() }
                    <h4 class="download-title">{ title }</h4>
                </a>
            </div>
        );
    }
});
