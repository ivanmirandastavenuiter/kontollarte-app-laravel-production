$(document).ready(function() { 

    // Next show request
    function loadNextShowImage() {

    var route = window.location.href.endsWith('public/')
                  ? 'shows/next'
                  : 'next';
    
    // Position refers to order in database
    var position = $('.data-storage').data('position');
    
    var hash = getUrlHashToken('shows.next', position);

    var img = $('.image-container > img');

      $.ajax({
          method  : "GET",
          url     : route,
          dataType: "json",
          data: { "signature" : hash , "position" : position },
          success : function(data) {  

            if (!data.error) {

              var showData = data.showData;

              // Image
              img.attr('src', showData.imgData.link);
              img.attr('height', 300);
              img.attr('width', 300);

              // Dates
              $('.date-paragraph').children().remove();
              $('.date-paragraph').append(
                formatDates(showData.startingDate, showData.endingDate)
              );
              
              // Name
              $('.name-paragraph')[0].textContent = showData.name;

              // Description
              $('.description-paragraph')[0].textContent = showData.description;

              // Position increased value
              $('.data-storage').data('position', data.newPosition);

            }
          },
          error : function(jqXHR, textStatus, errorThrown) {

             console.log('Response: ' + jqXHR)
             console.log('Type of error: ' + textStatus);
             console.log('Exception: ' + errorThrown);

          }
        }) ;

    }

    // Previous show request
    function loadPrevShowImage() {

      var route = window.location.href.endsWith('public/')
                    ? 'shows/previous'
                    : 'previous';

      var position = $('.data-storage').data('position');

      var hash = getUrlHashToken('shows.previous', position);

      var img = $('.image-container > img');

      $.ajax({
          method  : "GET",
          url     : route,
          dataType: "json",
          data: { "signature" : hash, "position" : position },
          success : function(data) {

            var showData = data.showData;

            // Image
            img.attr('src', showData.imgData.link);
            img.attr('height', 300);
            img.attr('width', 300);

            // Dates
            $('.date-paragraph'). children().remove();
            $('.date-paragraph').append(
            formatDates(showData.startingDate, showData.endingDate)
            );
            
            // Name
            $('.name-paragraph')[0].textContent = showData.name;

            // Description
            $('.description-paragraph')[0].textContent = showData.description;

            // Position increased value
            $('.data-storage').data('position', data.newPosition);

          },
          error : function(jqXHR, textStatus, errorThrown) {

            console.log('Response: ' + jqXHR)
            console.log('Type of error: ' + textStatus);
            console.log('Exception: ' + errorThrown);

          }
      }) ;


    }

    // On previous show button clicked
    $('.control-prev').click(function() {

        // Loading scene is presented
        $('.image-container img').css('display','none')
        $('.image-container').css('background','transparent')
        $('.image-container .spinner-border').css('display','block')
        $('.image-container').addClass('d-flex justify-content-center align-items-center')

        // Checks show amount on database
        checkShowsOnDatabase();

        var databaseEntries = $('.data-storage').attr('data-database');
        if (databaseEntries == 'true') {

            var button = $(this);

            // Removing/adding disabled class, it maintains button disabled
            if (button.hasClass('disabled')) {
                return;
            } else {
                loadPrevShowImage();
                button.addClass('disabled');
            }

            setTimeout(function() {
              button.removeClass('disabled');
              $('.image-container img').css('display','block')
              $('.image-container').css('background','#000')
              $('.image-container .spinner-border').css('display','none')
              $('.image-container').removeClass('d-flex justify-content-center align-items-center')
            }, 3000);

        } else {
            $('#empty-shows').modal('show');
            $('.image-container img').css('display','block')
            $('.image-container').css('background','#000')
            $('.image-container .spinner-border').css('display','none')
            $('.image-container').removeClass('d-flex justify-content-center align-items-center')
        }

    });

    // On next show button clicked
    $(".control-next").click(function() {

        $('.image-container img').css('display','none')
        $('.image-container').css('background','transparent')
        $('.image-container .spinner-border').css('display','block')
        $('.image-container').addClass('d-flex justify-content-center align-items-center')

          var button = $(this);

          if (button.hasClass('disabled')) {
              return;
          } else {
              loadNextShowImage(); 
              button.addClass('disabled');
          }

          setTimeout(function() {
              button.removeClass('disabled');
              $('.image-container img').css('display','block')
              $('.image-container').css('background','#000')
              $('.image-container .spinner-border').css('display','none')
              $('.image-container').removeClass('d-flex justify-content-center align-items-center')
          }, 3000);
      
    }) ;

    // Get the shows quantity on database
    function checkShowsOnDatabase() {

        var route = window.location.href.endsWith('public/')
                    ? 'shows/count'
                    : 'count';

        var hash = getUrlHashToken('shows.count');

              $.ajax({
                method  : "GET",
                async: false,
                url     : route,
                data    : { "signature" : hash },
                dataType: "text",
                success : function(data) {

                  if (data == 0) {
                    $('.data-storage').attr('data-database', 'false');
                  } else {
                    $('.data-storage').attr('data-database', 'true'); 
                  }
                    
                },
                error : function(jqXHR, textStatus, errorThrown) {

                  console.log('Response: ' + jqXHR)
                  console.log('Type of error: ' + textStatus);
                  console.log('Exception: ' + errorThrown);

                }
              }) ;

    }

    // Gives the format to date information
    function formatDates(startingDate, endingDate) {
        $('.date-paragraph')[0].textContent = '';
        return "<div class='dates-container'>" + 
                  "<b>Starting date:</b> " + startingDate + "</br>" +
                  "<b>Ending date:</b> " + endingDate +
               "</div>";
    }

    // Get the hashed url for the request
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

}) ;