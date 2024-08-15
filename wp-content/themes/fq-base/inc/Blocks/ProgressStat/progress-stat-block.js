const { registerBlockType } = wp.blocks;
const { RichText, InspectorControls } = wp.blockEditor;
const { RangeControl, PanelBody } = wp.components;
import icon from './icon';

registerBlockType( 'figoli-quinn/progress-stat', {
    title: 'Progress Stat',
    category: 'widgets',
    icon,
    attributes: {
        label: {
            type: 'string'
        },
        fill: {
            type: 'integer',
            default: 50,
        },
    },

    edit( { attributes, className, setAttributes, isSelected } ) {

        return [
            <InspectorControls>
                <PanelBody>
                    <RangeControl
                        key={ 'fil' }
                        label={ 'Progress Amount' }
                        value={ attributes.fill }
                        onChange={ (value) => setAttributes({ fill: value })}
                        min={ 0 }
                        max={ 100 }
                        initialPosition={ attributes.fill }
                    />
                </PanelBody>
            </InspectorControls>,
            
            <div className="progress-stat-container align">
                <div className="label">
                    <RichText 
                        onChange={ (value) => setAttributes({ label: value }) }
                        value={ attributes.label }
                        tagName="p"
                        className={'label'}
                        placeholder={'Label'}
                        keepPlaceholderOnFocus={true}
                    />
                </div>
                <div class="progress-bar">
                    <div className="fill" style={ { width: attributes.fill + '%' }}></div>
                </div>
            </div>
        ];
    },

    save( { attributes } ) {

        return (
            <div className="progress-stat-container align">
                <div className="label">
                    <p>
                        { attributes.label }
                    </p>
                </div>
                <div class="progress-bar">
                    <div className="fill" style={ { width: attributes.fill + '%' }}></div>
                </div>
            </div>
        );
    }
});