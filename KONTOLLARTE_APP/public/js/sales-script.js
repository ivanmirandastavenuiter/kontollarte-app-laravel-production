
$(document).ready(function() {

    // Hide error messages on click
    $('input#title').focus(function() { $('.title-invalid').css('display', 'none') })
    $('input#price').focus(function() { $('.price-invalid').css('display', 'none') })
    $('textarea#description').focus(function() { $('.description-invalid').css('display', 'none') })

    var target = $('html, body'); 

    // Form id is controlled to make scroll
    if ($('.form-div-value').length > 0) {

        var formId = $('.form-div-value').attr('value')

        // Div is removed for efficiency
        $('.form-div-value').remove()

        // With the given id, we can find selected form
        var targetedForm = $('#selling-form-' + formId)

        // From there on, we can escalate on close relatives
        var formContainer = targetedForm.parentsUntil('.paint-row').last()
        var formContentContainer = formContainer.find('.form-content-container')
        var displayFormIcon = formContainer.find('.display-form')
        var scrollReference = formContainer.parent().find('.paint-name');

        // With animate function, scroll is executed
        target.animate({scrollTop: scrollReference.offset().top - 173 }, {duration: 500, easing: 'linear'});

        $(targetedForm).css({
            'padding' : '60px'
        })
        $(formContentContainer).css({
            'height' : '646px'
        })
        $(displayFormIcon).css('transform', 'rotate(-180deg)')
    }
    
    // Display form on click
    $('.form-container .display-form').click(function() {

        // Relatives are taken
        displayedFormContainer = $(this).siblings().last()
        displayedForm = displayedFormContainer.find('.selling-form')

        // If height > 0 on click, it is open so it needs to close
        if ($(displayedFormContainer).height() > 0) {

            $(displayedForm).css({
                'padding' : '0'
            })
            $(displayedFormContainer).css({
                'height' : '0'
            })
            $(this).css('transform', 'rotate(0deg)')

        } else { 

            // Else, we open it

            $(displayedForm).css({
                'padding' : '60px'
            })
            $(displayedFormContainer).css({
                'height' : '646px'
            })
            $(this).css('transform', 'rotate(-180deg)')
        }
        
    })

    // Executed on submit click
    $('.submit-btn').click(function(e) {

        e.preventDefault();

        // All needed relatives are caught
        formContainer = $(this).parentsUntil('.paint-row').last()
        formContentContainer = formContainer.find('.form-content-container')
        sellingForm = formContainer.find('form')
        loadingContainer = formContainer.parent().find('.loading-container')
        loadingParagraph = loadingContainer.children()
        scrollReference = formContainer.parent().find('.paint-name');
        
        $('.current-path').val(window.location.href);

        $(formContentContainer).css({
            'height' : '0'
        })

        $('html, body').animate({scrollTop: scrollReference.offset().top - 100}, {duration: 500, easing: 'linear'});

        $(loadingContainer).css({
            'left' : '-30%'
        })

        // Loading bar beginning
        setTimeout(function() {

            $(loadingParagraph).css({
                'opacity' : '0'
            })

        }, 1000)

        // Loading bar growing
        setTimeout(function() {

            $(loadingContainer).css({
                'left' : '0%'
            })

            $(loadingParagraph).text('Executing...');

            $(loadingParagraph).css({
                'opacity' : '1'
            })

        }, 2000)

        // Finally, form is submitted
        setTimeout(function() {
            sellingForm.submit();
        }, 3000)

    })

})