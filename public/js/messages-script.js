$(document).ready(function() {

    $('.submit-btn').click(function()  {

        var messageBody = $('#message-body')[0].value;
        var galleriesSelected = [];

        $('.custom-control-input').each(function() {
            if (this.checked) {
                galleriesSelected.push(this.value);
            }
        })

        var parameters = { messageBody : messageBody, galleriesList : galleriesSelected }

        var hash = getUrlHashToken('messages.request', parameters)

        console.log(galleriesSelected);

        $.ajax({
        method  : "GET",
        url     : "handle_request",
        dataType: "json",
        data: { "galleriesList" : galleriesSelected, "messageBody" : messageBody, "signature" : hash },
        success : function(data) { 
            
            if(data.result) {

                $('#confirm-message .modal-body .message-content')[0].innerHTML = '';
                $('#confirm-message .modal-body .receivers-content ul').children().remove();
                $('#confirm-message .modal-body .jobs-content').children().remove();

                $('#confirm-message .modal-body .message-content').append(data.messageBody);

                $.each(data.receivers, function() {
                $('#confirm-message .modal-body .receivers-content ul')
                        .append(
                            '<li>' + this.galleryName + ' - ' + this.galleryEmail + '</li>');
                });

                var fixedUrl = document.location.href
                                    .split("public")[0]
                                    .concat('public/');

                                   

                $.each(data.paintings, function() {
                $('#confirm-message .modal-body .jobs-content')
                        .append(
                            "<p><strong>" + this.paintName + "</strong></p>" + 
                            "<img src='" + fixedUrl + this.paintImage + "' width='450' height='400'>" +
                            "<div class='custom-control custom-checkbox'>" 
                                + "<input type='checkbox' data-paint-id='" + this.paintId + "' class='custom-control-input usr-pics' id='paint" + this.paintId + "'>"
                                + "<label class='custom-control-label' for='paint" + this.paintId + "'>Include this job</label>"
                            + "</div>");
                });

                $('#message-form').submit(function(e) {

                    e.preventDefault();

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

                    console.log(selectedPaints)

                    $('input#message-content').attr('value', JSON.stringify(data.messageBody));
                    $('input#receivers').attr('value', JSON.stringify(data.receivers));
                    $('input#pictures').attr('value', JSON.stringify(selectedPaints));

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

function enableDisableSubmitButton() {

    $(document).ready(function() {
        if ($('#message-body')[0].textContent.length > 0) {
            if ($('.galleries-checkbox-container')[0].children[1].children.length > 0) {
                checked = false;
                $("input[id^='customCheck']").each(function() {
                    if(this.checked == true) {
                        checked = true;
                    }
                })
                checked ? $('.submit-btn').prop('disabled', false) : $('.submit-btn').prop('disabled', true)
            }
        } else {
            $('.submit-btn').prop('disabled', true)
        }
    })

}

function changeOnCheckboxClick() {
    $(document).ready(function() {
        $("input[id^='customCheck']").click(function() {
            enableDisableSubmitButton();
        })
    })
}

function getUrlHashToken(route, parameters = null) {

    result = '';

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $("input[name='_token']")[0].value
      }
    });

    method = window.location.href.endsWith('public/')
                ? 'shows/get_hash_url_token'
                : 'get_hash_url_token'

    if (parameters !== null) {

      console.log('Not null');

      $.ajax({
          method      : "post",
          url         : method,
          async       : false,
          cache       : false,
          data        : { "route" : route, "parameters" : parameters},
          dataType    : "text",
          success     : function(data) {
              console.log(data);
            result = data.split('signature=')[1].trim();
          },
          error       : function(errorThrown) {
            console.log('Error thrown: ' + errorThrown);
          }
    });

    } else {

      console.log('yesfuckingfgotdamnull?');

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

enableDisableSubmitButton();
changeOnCheckboxClick();
