const { registerBlockType, createBlock } = wp.blocks;
const { InnerBlocks, RichText, InspectorControls } = wp.blockEditor;
const { PanelBody, SelectControl } = wp.components;

const TEMPLATE = [['figoli-quinn/tab', {} ]];
const ALLOWED = ['figoli-quinn/tab'];

registerBlockType( 'figoli-quinn/tabs', {
    title: 'Tabs',
    category: 'widgets',
    attributes: {
        tabTitles: {
            type: 'string',
        },
        currentTabIndex: {
            type: 'integer',
            default: 0,
        },
        tabNavLocation: {
            type: 'string',
            default: 'top',
        },
    },

    edit( { attributes, className, setAttributes, clientId } ) {

        let blocks = wp.data.select('core/block-editor').getBlocks();
        let currentBlock = blocks.find(block => {
            if (block.clientId == clientId) {
                return true;
            }
        });

        // Add a new tab and update the number of titles.
        async function insertTab() {
            tabTitles.push('Tab Title');
            setAttributes({ tabTitles: JSON.stringify(tabTitles) });
            let block = createBlock("figoli-quinn/tab");
            let res = await wp.data.dispatch("core/block-editor").insertBlock(
                block, attributes.currentTabIndex + 1, clientId
            );

            let nextTabIndex = ( currentBlock.innerBlocks == undefined ? 1 : currentBlock.innerBlocks.length );
            setAttributes({ currentTabIndex: nextTabIndex });
        }

        async function removeCurrentTab() {
            let tabBlockClientId = currentBlock.innerBlocks[attributes.currentTabIndex].clientId;
            let res = await wp.data.dispatch('core/block-editor').removeBlock(tabBlockClientId);
            let nextTabIndex = ( currentBlock.innerBlocks == undefined ? 0 : currentBlock.innerBlocks.length - 1 );
            let newCurrentIndex = attributes.currentTabIndex - 1;
            tabTitles.splice(newCurrentIndex, 1);
            setAttributes({ 
                currentTabIndex: newCurrentIndex,
                tabTitles: JSON.stringify(tabTitles),
            });
        }

        // Set the current tab as visible, all else as not.
        if (currentBlock.innerBlocks.length > 0) {
            currentBlock.innerBlocks.forEach((block, index) => {
                wp.data.dispatch('core/editor').updateBlockAttributes([block.clientId], {
                    visible: index == attributes.currentTabIndex,
                });
            });
        }

        // Read the saved titles.
        let tabTitles = [];
        if (attributes.tabTitles == null) {
            tabTitles = ['Tab Title'];
        } else {
            tabTitles = JSON.parse(attributes.tabTitles);
        }

        return [
            <InspectorControls>
                <PanelBody title="Tabs">
                    <SelectControl 
                        label="Tab Nav Location"
                        value={ attributes.tabNavLocation }
                        options={ [
                            { label: 'Top', value: 'top' },
                            { label: 'Bottom', value: 'bottom' },
                        ]}
                        onChange={ (value) => setAttributes({ tabNavLocation: value }) }
                    />
                    <button
                        className="components-button is-secondary"
                        type="button"
                        onClick={ insertTab }
                    >
                        Add New Tab
                    </button>

                    <button
                        className="components-button is-secondary"
                        type="button"
                        onClick={ removeCurrentTab }
                    >
                        Remove Selected Tab
                    </button>
                </PanelBody>
            </InspectorControls>,

            <div>
                <div className={ 'fq-tabs tab-nav-' + attributes.tabNavLocation }>
                    <div class="tabs-container">
                        <InnerBlocks 
                            template={ TEMPLATE }
                            allowedBlocks={ ALLOWED }
                            renderAppender={ null }
                        />
                    </div>

                    <nav class="tab-nav">
                        { tabTitles.map((tab, index) => {
                            return (
                                <div className={ 'tab' + ( attributes.currentTabIndex == index ? ' active' : '' )} onClick={ () => setAttributes({ currentTabIndex: index }) }>
                                    <RichText
                                        value={ tab }
                                        onChange={ (value) => {
                                            tabTitles[index] = value;
                                            setAttributes({ tabTitles: JSON.stringify(tabTitles) });
                                        }}
                                    />
                                </div>
                            );
                        })}
                    </nav>
                </div>
            </div>
        ];
    },

    save( { attributes } ) {

        // Read the saved titles.
        let tabTitles = [];
        if (attributes.tabTitles == null) {
            tabTitles = ['Tab Title'];
        } else {
            tabTitles = JSON.parse(attributes.tabTitles);
        }

        return (
            <div>
                <div className={ 'fq-tabs tab-nav-' + attributes.tabNavLocation }>
                    <div class="tabs-container">
                        <InnerBlocks.Content />
                    </div>

                    <nav class="tab-nav">
                        { tabTitles.map((tab, index) => {
                            return (
                                <div className="tab">
                                    <span>{ tab }</span>
                                </div>
                            );
                        })}
                    </nav>
                </div>
            </div>
        );
    },
});
