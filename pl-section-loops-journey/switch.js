!function ($) {

  /** Set up initial load and load on option updates (.pl-trigger will fire this) */
  $( '.pl-sn-switch' ).on('template_ready', function(){

    $.plSwitch.init( $(this) )

  })

  $.plSwitch = {

    init: function( section ){

      var theSelect = section.find('.switch-select'),
          selected  = section.find('.switch-selected'), 
          theOpts   = section.find('.switch-options') 
          container = section.find('.switch-container'), 
          theSwitch = container.find('.the-switch'), 
          dflt      = parseInt( container.data('default') ), 
          
          
      dflt = ( dflt < 0 ) ? 0 : dflt

      var selOpt    = theOpts.find( sprintf('[data-index="%s"]',  dflt) ), 
          dfltText  = selOpt.find('.sel-text').text()

      selOpt.addClass('selected')

      section.find( sprintf( '.switch-item[data-index="%s"]', dflt ) ).show()

      selected.find('.sel-text').text( dfltText )

      selected.not('.loaded').on('click', function( e ){

        e.stopPropagation()

        var theSwitch = $(this).closest('.the-switch')
        
   
        if( ! theSwitch.hasClass('active') ){

          theSwitch.addClass('active')

          $('body').on('click', function(e){


            if( $(e.target).closest('.switch-options').length == 0 ){

              theSwitch.removeClass('active')

              $( this ).off( e );

            }
            
          })



        } 

        else {
          theSwitch.removeClass('active')
        }

      }).addClass('loaded')


      theOpts.not('.loaded').delegate( '.sw-option', 'click', function( e ){

        var theValue    = $(this).attr('data-index'), 
            theText     = $(this).find('.sel-text').text()

        var theSwitch = $(this).closest('.the-switch')

        theOpts.find('.sw-option').removeClass('selected')

        $(this).addClass('selected')


        selected.find('.sel-text').text( theText )

        theSwitch.removeClass('active')

        section.find('.switch-item').hide()

        section.find( sprintf( '.switch-item[data-index="%s"]', theValue ) ).show()

      }).addClass('loaded')

    }

  }



}(window.jQuery);