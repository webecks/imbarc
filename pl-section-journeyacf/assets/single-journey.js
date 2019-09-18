'use strict';

jQuery( function ( $ ) {
	const $nav = $( '.journey-schedule-nav' ),
		setNotePos = () => {
			$( '.border-note' ).each( function () {
				const $this = $( this ),
					width = $this.width(),
					parentHeight = $this.parent().outerHeight();

				$this.css( 'top', () => {
					return ( ( parentHeight - width ) / 2 ) - 11;
				});
			});
		},
		setNavPos = () => {
			$nav.css( 'top', () => {
				return ( $( window ).height() - $nav.outerHeight() ) / 2;
			});
		};

	setNotePos();
	setNavPos();
	$( window ).on( 'resize', () => {
		setNotePos();
		setNavPos();
	});
	$( window ).on( 'scroll', () => {
		const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

		$nav.children().each( function ( i ) {
			const $this = $( this ),
				$ul = $this.parent(),
				screenHeight = $( window ).height(),
				scrollPos = $( $this.find( 'a' ).attr( 'href' ) ).offset().top - ( screenHeight - screenHeight / 2 );

			if ( i === 0 && scrollTop >= scrollPos ) {
				$ul.css( 'display', 'block' );
			} else if ( i === 0 && scrollTop <= scrollPos ) {
				$ul.css( 'display', 'none' );
			}

			if ( scrollTop >= scrollPos ) {
				if ( ! $this.hasClass( 'active' ) ) {
					$this.addClass( 'active' ).siblings().removeClass( 'active' );
				}
			}
		});
	});
});
