/*
 * WPea Admin JavaScript
 *
 * Copyright (c) 2023 Hexadecaedre
 * http://dev.hexadecaedre.com
 *
 * Depends:
 *   jquery.ui.core.js
 */
jQuery(document).ready(function ($) {
    
    // lazy load
    $(function() {
        if ( $("img.lazy").length > 0 ) {
            $("img.lazy").lazyload({
                effect : "fadeIn"
            });
        }
    });
    
    // swipe box
    $(function() {
        if ( $('.swipebox').length > 0 ) {
            $( '.swipebox' ).swipebox();
        }
    });
    
    // DPE diagram
    if( $( "#wpea-dpe" ).data( 'value' ) != undefined ) {
        var dpeLabel, dpeVal = parseInt( $( "#wpea-dpe" ).data( 'value' ) );
        if( dpeVal <= 50 ) {
            dpeLabel = "a";
        }
        else if ( dpeVal >= 51 && dpeVal <= 90 ) {
            dpeLabel = "b";
        }
        else if ( dpeVal >= 91 && dpeVal <= 150 ) {
            dpeLabel = "c";
        }
        else if ( dpeVal >= 151 && dpeVal <= 230 ) {
            dpeLabel = "d";
        }
        else if ( dpeVal >= 231 && dpeVal <= 330 ) {
            dpeLabel = "e";
        }
        else if ( dpeVal >= 331 && dpeVal <= 450 ) {
            dpeLabel = "f";
        }
        else if ( dpeVal > 450 ) {
            dpeLabel = "g";
        }
        if( dpeVal != "" ) {
            var dpeSpan = dpeVal + "<b>" + dpeLabel.toUpperCase() + "</b>";
            $( ".wpea-dpe-" + dpeLabel ).html( dpeSpan );
            $( ".wpea-dpe-" + dpeLabel ).parent().css( "display", "block" );
        }        
    }
    
    // GES diagram
    if( $( "#wpea-ges" ).data( 'value' ) != undefined ) {
        var gesLabel, gesVal = parseInt( $( "#wpea-ges" ).data( 'value' ) );
        if (gesVal <= 5) {
            gesLabel = "a";
        }
        else if ( gesVal >= 6 && gesVal <= 10 ) {
            gesLabel = "b";
        }
        else if ( gesVal >= 11 && gesVal <= 20 ) {
            gesLabel = "c";
        }
        else if ( gesVal >= 21 && gesVal <= 35 ) {
            gesLabel = "d";
        }
        else if ( gesVal >= 36 && gesVal <= 55 ) {
            gesLabel = "e";
        }
        else if ( gesVal >= 56 && gesVal <= 80 ) {
            gesLabel = "f";
        }
        else if ( gesVal > 80 ) {
            gesLabel = "g";
        }
        if( gesVal != "" ) {
            var gesSpan = gesVal + "<b>" + gesLabel.toUpperCase() + "</b>";
            $(".wpea-ges-" + gesLabel).html(gesSpan);
            $(".wpea-ges-" + gesLabel).parent().css( "display", "block" );
        }
    }
    
});

jQuery( window ).load( function(){
    // property gallery
    //if($('.wpea-gallery').is(':visible')) {
    if ( jQuery( '#carousel li' ).length > 0 ) {
            var current = 0,
            $preview = jQuery( '#preview' ),
            $full = jQuery( '#full' ),
            $carouselEl = jQuery( '#carousel' ),
            $carouselItems = $carouselEl.children(),
            carousel = $carouselEl.elastislide( {
                current : current,
                minItems : 4,
                onClick : function( el, pos, evt ) {
                    console.log(el);
                    changeImage( el, pos );
                    evt.preventDefault();
                },
                onReady : function() {
                    changeImage( $carouselItems.eq( current ), current );
                }
            } );

            function changeImage( el, pos ) {
                $preview.attr( 'src', el.data( 'preview' ) );
                $full.attr( 'href', el.data( 'full' ) );
                $carouselItems.removeClass( 'current-img' );
                el.addClass( 'current-img' );
                carousel.setCurrent( pos );
            }

    }
});    

