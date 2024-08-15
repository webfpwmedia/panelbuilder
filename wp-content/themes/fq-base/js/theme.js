jQuery( document ).ready( function( $ ) {

	// MOBILE NAV

	var navTrigger = $( '#nav-toggle' );
	var userMenuTrigger = $( '#user-menu-trigger' );
	var userMenuBody = $( '.user-submenu' );

	var submenuTrigger = $( '.menu-item-has-children a' );
	var navBody = $( '.nav-rows .primary' );
	var uiOverlay = $( '.ui-overlay' );
	var searchTrigger = $( '.nav-rows .search-form .search-submit' );

	// Set up event handlers
	navTrigger.on( 'click', toggleNav );
	submenuTrigger.on( 'click', function() {
		toggleSubnav( $(this) );
	});
	uiOverlay.on( 'click', toggleNav );
	uiOverlay.on( 'click', closeSubnav );
	uiOverlay.on( 'click', toggleUserMenu );

	userMenuTrigger.on( 'click', toggleUserMenu );
	searchTrigger.on( 'click', function(e) {

		e.preventDefault();
		var searchForm = $(this).closest( '.search-form' );

		if ( searchForm.hasClass( 'open' ) ) {
			if ( '' != searchForm.find( '.search-field' ).val() ) {
				searchForm.submit();
			} else {
				searchForm.removeClass( 'open' );
			}
		} else {
			$( '.search-form .search-field' ).val( '' );
			$( '.search-form #searchfor' ).focus();
			searchForm.addClass( 'open' );
		}
	} );

	// Functions

	function toggleNav() {
		navBody.toggleClass( 'show' );
		if ( navBody.hasClass( 'show' ) ) {
			navTrigger.addClass( 'open' );
			uiOverlay.addClass( 'enabled' );
		} else {
			navTrigger.removeClass( 'open' );
			uiOverlay.removeClass( 'enabled' );
		}
	}

	function toggleUserMenu() {
		if ( ! userMenuBody.hasClass( 'open' ) ) {
			userMenuBody.addClass( 'open' );
			uiOverlay.addClass( 'enabled' );
		} else {
			userMenuBody.removeClass( 'open' );
			uiOverlay.removeClass( 'enabled' );
		}
	}

	function toggleSubnav( link ) {
		if ( link.hasClass( 'open' ) ) {
			closeSubnav();
		} else {
			openSubnav( link );
		}
	}

	function openSubnav( link ) {
		closeSubnav();
		var subMenu = link.siblings( '.sub-menu' );
		link.toggleClass( 'open' );
		link.closest( '.menu-item' ).addClass( 'submenu-is-active' );
		subMenu.addClass( 'show' );
		uiOverlay.addClass( 'enabled' );
	}

	function closeSubnav() {
		$( '.menu-item-has-children a' ).removeClass( 'open' );
		$( '.menu-item' ).removeClass( 'submenu-is-active' );
		$( '.sub-menu' ).removeClass( 'show' );
	}
});
