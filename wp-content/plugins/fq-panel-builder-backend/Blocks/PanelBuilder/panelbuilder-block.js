const { registerBlockType } = wp.blocks

registerBlockType( 'figoli-quinn/panel-builder', {
    title: 'Panel Builder',
    category: 'widgets',    

    edit( { attributes, className, setAttributes, isSelected } ) {

        return [
            <div>Panel Builder will show here.</div>
        ];
    },

    save( { attributes } ) {

        return (
            <div id="panel-builder"></div>
        );
}
})