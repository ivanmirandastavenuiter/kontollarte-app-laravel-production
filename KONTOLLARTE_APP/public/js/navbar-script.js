$(document).ready(function() {

    // Triggers post request on submit
    $('a.logout-link').click(function() {
        $('#logout').submit()
    })

    var scrollTop = 0;
    
    // Height controls on scroll modifications
    $(window).scroll(function(){

        scrollTop = $(window).scrollTop();

        // Boolean reduceHeight controls if height has to be 0

        if (scrollTop >= 100) {
            $('.navbar-row ').addClass('scrolled-nav');
            $('.title-container').addClass('balance-margin');  
            if ($('.sections-container').height() > 0 
                    && window.innerWidth < 992
                    && !reduceHeight) {
                        $('.sections-container').css({
                            'height' : '624px'
                        })
                    }
        } else if (scrollTop < 100) {
            $('.title-container').removeClass('balance-margin');
            $('.navbar-row ').removeClass('scrolled-nav');
            if ($('.sections-container').height() > 0 
                    && window.innerWidth < 992
                    && !reduceHeight) {
                        $('.sections-container').css({
                            'height' : '624px'
                        })
                    }
        } 
        
    }); 

    // Css controls on width modifications
    $(window).resize(function() {
        if(window.innerWidth > 991) {

            if (parseFloat($('.sections-container').height()) > 0) {
                $('.title-container').removeClass('balance-margin-wrap');
            }

            $('.sections-container').css({
                'height' : ''
            })

            $('.title-section-row').css({
                'margin-bottom' : '0'
            })

            $('.color-bar').css('display', 'initial')

        }
    })

    reduceHeight = '';

    // Flag function to open/close vertical menu
    $('.navbar-title a span').click(function(e) {

        reduceHeight = false;

        e.preventDefault();

        // parseFloat won't work here
        if (window.innerWidth < 992) {

            console.log('clicking')

            $('.color-bar').css('display', 'block')

            if (parseFloat($('.sections-container').height()) > 0) {

                // Transitions are set to its opposite to flow in proper direction
                $('.bar-one').css('transition-delay', '.4s');
                $('.bar-two').css('transition-delay', '.3s');
                $('.bar-three').css('transition-delay', '.2s');
                $('.bar-four').css('transition-delay', '.1s');
                $('.bar-five').css('transition-delay', '.0s');
                $('.bar-six').css('transition-delay', '.0s');
                $('.bar-seven').css('transition-delay', '.0s');

                $('.title-container').removeClass('balance-margin-wrap');  

                $('.sections-container').css({
                    'height' : '0px'
                })  

                $('.color-bar').css({
                    'width' : '0%'
                })

                reduceHeight = true;
                
            } else {

                // Transitions are set to its opposite to flow in proper direction
                $('.bar-one').css('transition-delay', '.1s');
                $('.bar-two').css('transition-delay', '.2s');
                $('.bar-three').css('transition-delay', '.3s');
                $('.bar-four').css('transition-delay', '.4s');
                $('.bar-five').css('transition-delay', '.5s');
                $('.bar-six').css('transition-delay', '.6s');
                $('.bar-seven').css('transition-delay', '.7s');

                $('.title-container').removeClass('balance-margin');  
                $('.title-container').addClass('balance-margin-wrap');  


                $('.sections-container').css({
                    'height' : '624px'
                })

                $('.color-bar').css({
                    'width' : '100%'
                })

            }
        }
    })
})