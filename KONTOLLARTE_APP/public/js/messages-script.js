$(document).ready(function() {

    // Elements that trigger opening/closing of message panel
    $('.hmg-container .fa-bars, .left-dropdown-title, .right-dropdown-title').click(function() {

        // Calculate the position and behaves based on it
        if (parseFloat($('.hmg-container').css('left')) > 0) {

            $('.hmg-container').css({
                'transform' : 'rotate(180deg)',
                'left' : '0'
            })
    
            $('.left-dropdown-title').css({
                'opacity': '0'
            })
    
            $('.right-dropdown-title').css({
                'opacity': '1'
            })

            $('.pm-items-box').css({
                'transition' : 'all 1s',
                'height' : 'auto',
                'opacity' : '1',
                'padding-bottom' : '50px'
            })

        } else {

            $('.hmg-container').css({
                'transform' : 'rotate(-180deg)',
                'left' : '97%'
            })
    
            $('.left-dropdown-title').css({
                'opacity': '1'
            })
    
            $('.right-dropdown-title').css({
                'opacity': '0'
            })

            $('.pm-items-box').css({
                'transition' : 'none',
                'height' : '0',
                'opacity' : '0',
                'padding-bottom' : '0'
            })

        }
    })

    // Operations triggered on submit clicked
    $('.submit-btn').click(function()  {

        var messageBody = $('#message-body')[0].value;
        var galleriesSelected = [];

        // Collect all galleries selected
        $('.input-tags').each(function() {
            if (this.checked) {
                galleriesSelected.push(this.value);
            }
        })

        var parameters = { messageBody : messageBody, galleriesList : galleriesSelected }

        // Get the hashed url
        var hash = getUrlHashToken('messages.request', parameters)

        // Ajax call for request handling
        $.ajax({
            method  : "GET",
            url     : "handle_request",
            dataType: "json",
            data: { "galleriesList" : galleriesSelected, "messageBody" : messageBody, "signature" : hash },
            success : function(data) { 
                
                if(data.result) {

                    // Clears previous inputs on modal
                    $('#confirm-message .modal-body .message-content')[0].innerHTML = '';
                    $('#confirm-message .modal-body .receivers-content ul').children().remove();
                    $('#confirm-message .modal-body .jobs-content').children().remove();

                    $('#confirm-message .modal-body .message-content').append(data.messageBody);

                    // List all the targeted receivers
                    $.each(data.receivers, function() {
                    $('#confirm-message .modal-body .receivers-content ul')
                            .append(
                                '<li>' + this.galleryName + ' - ' + this.galleryEmail + '</li>');
                    });

                    // Manipulation of path data
                    var fixedUrl = document.location.href
                                        .split("public")[0]
                                        .concat('public/');

                    // Message building
                    $.each(data.paintings, function() {
                    $('#confirm-message .modal-body .jobs-content')
                            .append(
                                "<p><strong>" + this.paintName + "</strong></p>" + 
                                "<img src='" + fixedUrl + this.paintImage + "' width='300' height='300'>" +
                                "<div class='custom-control custom-checkbox'>" 
                                    + "<input type='checkbox' data-paint-id='" + this.paintId + "' class='custom-control-input usr-pics' id='paint" + this.paintId + "'>"
                                    + "<label class='custom-control-label' for='paint" + this.paintId + "'>Include this job</label>"
                                + "</div>");
                    });

                    // Prevent form from direct sending
                    $('#message-form').submit(function(e) {

                        e.preventDefault();
                        
                        // Gather user selected jobs 
                        var selectedPaints = [];
                        $('.custom-control-input.usr-pics').each(function() {
                            if (this.checked) {
                                inputData = this;
                                $.each(data.paintings, function() { 
                                    if (this.paintId == inputData.dataset.paintId) {
                                        selectedPaints.push(this);
                                    }
                                });
                            }
                        })

                        // Assign the values to inputs
                        $('input#message-content').attr('value', JSON.stringify(data.messageBody));
                        $('input#receivers').attr('value', JSON.stringify(data.receivers));
                        $('input#pictures').attr('value', JSON.stringify(selectedPaints));

                        // Execute sending
                        this.submit();

                    })

                    $('#confirm-message').modal('show')
                    
                } else {

                    $('#empty-message-parameters').modal('show');

                }
            },
            error : function(jqXHR, textStatus, errorThrown) {

                console.log('Response: ' + jqXHR)
                console.log('Type of error: ' + textStatus);
                console.log('Exception: ' + errorThrown);

            }
        }) ;
    });
})

// Centers receiver box in odd case
function relocateLastChild() {

    $(document).ready(function() {

        children = parseFloat($('.wm-ch-box .row').children().length)

        if (children % 2 != 0) {
                $('.wm-ch-box .row')
                            .children()
                            .last()
                            .css('margin', '0 auto')
        }

    })  
}

// Send button status control
function enableDisableSubmitButton() {

    $(document).ready(function() {
        // If a message exists
        if ($('#message-body')[0].textLength > 0) {
            // If there's any receiver selected
            if ($('.wm-ch-box')[0].children.length > 1) {
                checked = false;
                // Then, if any selected
                $("input[id^='customCheck']").each(function() {
                    if(this.checked == true) {
                        checked = true;
                    }
                })
                // Button is enabled
                checked ? $('.submit-btn').prop('disabled', false) : $('.submit-btn').prop('disabled', true)
            }
        } else {
            $('.submit-btn').prop('disabled', true)
        }
    })

}

// Launches button status control on user activity
function changeOnCheckboxClick() {
    $(document).ready(function() {
        $("input[id^='customCheck']").click(function() {
            enableDisableSubmitButton();
        })
    })
}

// Get the hashed url for the request
function getUrlHashToken(route, parameters = null) {

    result = '';

    //CSRF Protection Token
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $("input[name='_token']")[0].value
      }
    });

    // String format needed depending on current path
    method = window.location.href.endsWith('public/')
                ? 'shows/get_hash_url_token'
                : 'get_hash_url_token'

    if (parameters !== null) {

      $.ajax({
          method      : "post",
          url         : method,
          async       : false,
          cache       : false,
          data        : { "route" : route, "parameters" : parameters},
          dataType    : "text",
          success     : function(data) {
                result = data.split('signature=')[1].trim();
          },
          error       : function(errorThrown) {
                console.log('Error thrown: ' + errorThrown);
          }
    });

    } else {

      $.ajax({
          method      : "post",
          url         : method,
          async       : false,
          cache       : false,
          data        : { "route" : route },
          dataType    : "text",
          success     : function(data) {
                result = data.split('signature=')[1].trim();
          },
          error       : function(errorThrown) {
                console.log('Error thrown: ' + errorThrown);
          }
      });

    }

    return result;
}

// Functions running since document ready

enableDisableSubmitButton();
changeOnCheckboxClick();
relocateLastChild();
