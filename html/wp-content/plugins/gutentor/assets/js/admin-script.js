(function( $ ){

	let settingAjax = function( action, block_id ){

		var data = {
			action   : action,
			nonce    : GUTENTOR_SETTINGS.ajax_nonce,
			block_id : block_id
		};

		$.ajax({
			url : GUTENTOR_SETTINGS.ajax_url,
			type: "POST",
			data: data,
			success: function(result){
				// console.log( result );
		  	},
		  	beforeSend: function(){

		  	},
			complete : function(){

			}
		});
	};

	$( document ).ready( function(){
        $( document ).on( 'click', '.onoffswitch', function( e ){
            e.preventDefault();

			let block_id = $( this ).find('input').data( 'action' );

			$( this ).find('input').prop( 'checked', !$( this ).find('input').prop( 'checked' ) );
            let val = $( this ).find('input').prop( 'checked' );
            let action = val ? 'activate_block' : 'deactivate_block';
			if( 'bulk' === block_id ){
				action = val ? 'bulk_activate_blocks' : 'bulk_deactivate_blocks';
			}

            settingAjax( action, block_id );

		});

        /*Video*/
        $('.gutentor-getting-started-watch-video').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false,
        });
	});
})( jQuery );