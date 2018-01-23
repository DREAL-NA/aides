// export function hideOnClickOutside(selector) {
// 	const outsideClickListener = (event) => {
// 		if (!$(event.target).closest(selector).length) {
// 			$('.menu-list-children').removeClass('active');
// 		}
// 	}
//
// 	document.addEventListener('click', outsideClickListener)
// }

(function ( $ ) {
	$.fn.menu = function() {
		this.find('[menu-selector]').bind("click.menu", function (e) {
			e.preventDefault();

			var id = $(this).attr('menu-selector');

			if(!$('#submenu-'+id).get(0)) {
				return false;
			}

			var _submenu_container = $('#submenu-'+id);
			$('.menu-list-children').not(_submenu_container).removeClass('active');
			$('.menu-list .menu-item').not($(this).parents('.menu-item')).removeClass('active');
			_submenu_container.toggleClass('active');
			$(this).parents('.menu-item').toggleClass('active');
		});

		document.addEventListener('click', (event) => {
			if ($(event.target).closest(this.find('[menu-selector]')).length > 0 || $(event.target).closest('.menu-children').length > 0) return;

			$('.menu-list-children').removeClass('active');
			$('.menu-list .menu-item').removeClass('active');
		});

		return this;
	};

	function debug( obj ) {
		if ( window.console && window.console.log ) {
			window.console.log( "menu selection count: " + obj.length );
		}
	};
}( jQuery ));