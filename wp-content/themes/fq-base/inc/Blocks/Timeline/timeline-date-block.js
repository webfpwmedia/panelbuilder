const { registerBlockType } = wp.blocks;
const { RichText, BlockControls, BlockAlignmentToolbar } = wp.blockEditor;
import icon from './timeline-date-icon'


registerBlockType( 'figoli-quinn/timeline-date', {
    title: 'Timeline Date',
    category: 'widgets',
    parent: ['core/group'],
    icon,
    attributes: {
        date: {
            type: 'string',
            default: '',
        },
        description: {
            type: 'string',
            default: '',
        },
        align: {
            type: 'string',
            default: 'left',
        },
    },

    edit( { attributes, className, setAttributes, isSelected } ) {

        return [
            <BlockControls>
                <BlockAlignmentToolbar
                    controls={ ['left', 'right'] }
                    value={ attributes.align }
                    onChange={ (value) => setAttributes({ align: value })}
                />
            </BlockControls>,

            <div className={ 'timeline-date align-' + attributes.align}>
                <div class="date">
                    <RichText 
                        onChange={ (value) => setAttributes({ date: value }) }
                        value={ attributes.date }
                        tagName="p"
                        placeholder={'2020'}
                        keepPlaceholderOnFocus={true}
                    />
                </div>
                <div class="description">
                    <RichText 
                        onChange={ (value) => setAttributes({ description: value }) }
                        value={ attributes.description }
                        placeholder={'Cras justo odio, dapibus ac facilisis in, egestas eget quam.'}
                        keepPlaceholderOnFocus={true}
                    />
                </div>
            </div>
        ];

    },

    save( { attributes } ) {

        return (
            <div className={ 'timeline-date align-' + attributes.align}>
                <div class="date">
                    { attributes.date }
                </div>
                <div class="description">
                    { attributes.description }
                </div>
            </div>
        );
    }
});