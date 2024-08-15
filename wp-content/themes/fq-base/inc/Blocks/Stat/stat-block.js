const { registerBlockType } = wp.blocks;
const { RichText, BlockControls, AlignmentToolbar } = wp.blockEditor;
import icon from './icon';

registerBlockType( 'figoli-quinn/stat', {
    title: 'Stat',
    category: 'widgets',
    icon,
    attributes: {
        stat: {
            type: 'string',
            default: '',
        },
        label: {
            type: 'string',
            default: '',
        },
        align: {
            type: 'string',
            default: 'center',
        }
    },

    edit( { attributes, className, setAttributes, isSelected } ) {

        return [
            <BlockControls>
                <AlignmentToolbar
                    value={ attributes.align }
                    onChange={ (value) => setAttributes({ align: value })}
                />
            </BlockControls>,
            
            <div className={ 'stat-container align-' + attributes.align}>
                <RichText 
                    onChange={ (value) => setAttributes({ stat: value }) }
                    value={ attributes.stat }
                    tagName="p"
                    className={'stat'}
                    placeholder={'Stat here'}
                    keepPlaceholderOnFocus={true}
                />
                <RichText 
                    onChange={ (value) => setAttributes({ label: value }) }
                    value={ attributes.label }
                    tagName="p"
                    className={'label'}
                    placeholder={'Label / Description'}
                    keepPlaceholderOnFocus={true}
                />
            </div>
        ];
    },

    save( { attributes } ) {
        return (
            <div className={ 'stat-container align-' + attributes.align}>
                <p class="stat">{ attributes.stat }</p>
                <p class="label">{ attributes.label }</p>
            </div>
        );
    }
});