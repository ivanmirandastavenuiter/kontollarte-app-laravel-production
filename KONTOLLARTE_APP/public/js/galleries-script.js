$(document).ready(function() {

    // Plus/minus nodes
    plusNodes = $('.sp-plus');
    minusNodes = $('.sp-minus');

    // On plus clicked
    plusNodes.click(function() {

        // It takes advantage on the gallery id
        nameNodes = this.className.split("-");

        // Here, it appends gallery id to proper node identification
        plusNodeClicked = $('.sp-plus-'.concat(nameNodes[nameNodes.length - 1]));
        minusNodeClicked = $('.sp-minus-'.concat(nameNodes[nameNodes.length - 1]));
        secondaryContainer = $('.secondary-container-'.concat(nameNodes[nameNodes.length - 1]));

        // Once jQuery has set the elements selected, clears one or another depending on the opacity value
        if (parseFloat(plusNodeClicked.css('opacity')) > parseFloat(minusNodeClicked.css('opacity'))) {

            plusNodeClicked.css({
              'opacity' : 0,
              'position' : 'absolute'
            });

            minusNodeClicked.css({
              'opacity' : 1
            });

            secondaryContainer.css({
              '-webkit-transition' : 'height .5s, opacity .5s',
              'opacity' : 1,
              'height' : '103px'
              
            });

        } else {

            minusNodeClicked.css({
              'opacity' : 0
            });
            plusNodeClicked.css({
              'opacity' : 1,
            });

            secondaryContainer.css({
              'opacity' : 0,
              'height' : 0,
              'transition' : 'none'
            });
        }
    })

    // On minus clicked
    minusNodes.click(function() {

    // It takes advantage on the gallery id
    nameNodes = this.className.split("-");

        // Here, it appends gallery id to proper node identification
        plusNodeClicked = $('.sp-plus-'.concat(nameNodes[nameNodes.length - 1]));
        minusNodeClicked = $('.sp-minus-'.concat(nameNodes[nameNodes.length - 1]));
        secondaryContainer = $('.secondary-container-'.concat(nameNodes[nameNodes.length - 1]));

        // Once jQuery has set the elements selected, clears one or another depending on the opacity value
        if (parseFloat(plusNodeClicked.css('opacity')) > parseFloat(minusNodeClicked.css('opacity'))) {

            plusNodeClicked.css({
              'opacity' : 0,
              'position' : 'absolute'
            });

            minusNodeClicked.css({
              'opacity' : 1
            });

            secondaryContainer.css({
              '-webkit-transition' : 'height .5s, opacity .5s',
              'opacity' : 1,
              'height' : '103px'
            });

        } else {

            minusNodeClicked.css({
              'opacity' : 0
            });
            plusNodeClicked.css({
              'opacity' : 1,
            });

            secondaryContainer.css({
              'opacity' : 0,
              'height' : 0,
              'transition' : 'none'
            });

        }
      
    })

    // Sets the value for gallery id on adding form
    $(document).on('click', '.add-btn', function() {
        var galleryId = $(this).data('gallery-id');
        $('.modal-footer #confirm-gallery-id-add-form').attr('action', galleryId);
    });

    // Get gallery details on delete action
    $(document).on('click', '.dlt-btn', function() {

        var deleteId = $(this).data('delete-id');

        // It executes a request to hash the url
        var hash = getUrlHashToken('galleries.details', deleteId.split("/")[1])
        $('.modal-footer #confirm-gallery-id-delete-form').attr('action', deleteId.trim());
        $.ajax({
            method  : "GET",
            url     : "details",
            contentType: "json",
            data: { "galleryId" : deleteId.split("/")[1], "signature" : hash },
            success : function(data) {

                // Fields are previously cleaned
                $('.name > p')[0].innerHTML = '';
                $('.region > p')[0].innerHTML = '';
                $('.site > p')[0].innerHTML = '';
                $('.email > p')[0].innerHTML = '';

                // Data parse to JSON is needed
                $('.name > p').append('<strong>Name: </strong>' + JSON.parse(data).name);
                $('.region > p').append('<strong>Region: </strong>' + JSON.parse(data).region);
                $('.site > p').append('<strong>Site: </strong>' + JSON.parse(data).site);
                $('.email > p').append('<strong>Email: </strong>' + JSON.parse(data).email);

                $('#confirm-delete-gallery-id').modal('show');
                  
            },
            error : function(e) {
                console.log('Error: ' + e);
            }
        })

    });

    // It makes a request to retrieve more galleries 
    $(document).on('click', '.refresh-galleries-btn', function() {

        // Again, it asks for hashed url
        var hash = getUrlHashToken('galleries.reload');
        
        $.ajax({
            method  : "GET",
            url     : "reload",
            data    : { "signature" : hash },
            dataType: "html",
            success : function(data) {
                $('.gi-container > .main-row').append(data);
            },
            error : function(e) {
                console.log('Error: ' + e);
            }
        })

    });

    // Clears filled values on confirmation modal
    $('#confirm-delete-gallery-id').on('hidden.bs.modal', function (e) {
        $('.name > p')[0].innerHTML = '';
        $('.region > p')[0].innerHTML = '';
        $('.site > p')[0].innerHTML = '';
        $('.email > p')[0].innerHTML = '';
    })

})

// Post request to hash url
function getUrlHashToken(route, parameters = null) {

    result = '';

    // CSRF Protection Token
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