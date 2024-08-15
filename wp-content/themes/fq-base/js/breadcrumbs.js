if ( document.getElementById('main-breadcrumbs') ) {
    window.addEventListener('scroll', () => {
        if ( parseInt( window.scrollY ) >= parseInt( document.getElementById('main').offsetTop ) ) {
            document.getElementById('main-breadcrumbs').classList.add('visible');
        } else {
            document.getElementById('main-breadcrumbs').classList.remove('visible');
        }
    });
}