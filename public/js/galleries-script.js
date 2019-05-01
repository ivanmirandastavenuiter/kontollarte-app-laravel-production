$(document).ready(function() {
    
    $(document).on('click', '.add-btn', function() {
        var galleryId = $(this).data('gallery-id');
        $('.modal-footer #confirm-gallery-id-add-form').attr('action', galleryId);
    });

    $(document).on('click', '.dlt-btn', function() {

        var deleteId = $(this).data('delete-id');
        var hash = getUrlHashToken('galleries.details', deleteId.split("/")[1])
        $('.modal-footer #confirm-gallery-id-delete-form').attr('action', deleteId.trim());
        $.ajax({
            method  : "GET",
            url     : "details",
            contentType: "json",
            data: { "galleryId" : deleteId.split("/")[1], "signature" : hash },
            success : function(data) {

              console.log(data);

                $('.name > p')[0].innerHTML = '';
                $('.region > p')[0].innerHTML = '';
                $('.site > p')[0].innerHTML = '';
                $('.email > p')[0].innerHTML = '';

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

    $(document).on('click', '.refresh-galleries-btn', function() {

        var hash = getUrlHashToken('galleries.reload');
        
        $.ajax({
            method  : "GET",
            url     : "reload",
            data    : { "signature" : hash },
            dataType: "html",
            success : function(data) {
                $('.cards-container').append(data);
            },
            error : function(e) {
                console.log('Error: ' + e);
            }
        })

    });

    $('#confirm-delete-gallery-id').on('hidden.bs.modal', function (e) {
        $('.name > p')[0].innerHTML = '';
        $('.region > p')[0].innerHTML = '';
        $('.site > p')[0].innerHTML = '';
        $('.email > p')[0].innerHTML = '';
    })

})

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