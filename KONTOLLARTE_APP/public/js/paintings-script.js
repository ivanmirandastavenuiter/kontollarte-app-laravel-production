$(document).ready(function() {

    // Bool to control open/close preview
    var skipClose = false;

    // If upload image bar changes
    $('#upload-paint-form #uploadImage').change(function() {
        $('#upload-paint-form .btn-prev').attr('disabled', false);

        var previewSet = $('#upload-paint-form #preview').html().length > 0;

        if (previewSet) {
            skipClose = true;
            $('#upload-paint-form .btn-close').click();
        }

    });

    // CSRF Protection Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("input[name='_token']")[0].value
        }
    });

    // Ajax call triggered in case of preview request
    $("#upload-paint-form .btn-prev").click(function() {

        var className = $(this)[0].className;

        // If already opened, it closes preview
        if (className.endsWith('btn-info') && !skipClose) {

            $('#upload-paint-form .btn-close').toggleClass('btn-prev btn-close btn-success btn-info');
            $('#upload-paint-form .btn-prev').html('Preview');
            $('#upload-paint-form #preview').html('').fadeOut();

        } else {

            // In case of closed, it opens preview
            var image = $("#upload-paint-form #uploadImage")[0].files[0];
            // FormData object type usage
            var formData = new FormData();
            formData.append('image', image);

            if (image != undefined) {

                $.ajax({
                    url: "get_image_preview",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false, // Needed in case of sending DOM objects
                    success: function(data) {
                        
                        var fixedUrl = document.location.href
                                                .split("public")[0]
                                                .concat('public/');

                        var imgData = JSON.parse(data).imgTag;
                        var success = JSON.parse(data).success;

                        // Url modifications needed to reorder elements
                        imgData = imgData.split("src='")[0]
                                            .concat("src='", fixedUrl, imgData.split("src='")[1]);

                        if (success) {
                            if (imgData != '') {
                                $("#upload-paint-form #preview").html(imgData).fadeIn();
                                $('#upload-paint-form .btn-prev').toggleClass('btn-prev btn-close btn-success btn-info'); // Toggle function allows to exchange classes in pairs
                                $('#upload-paint-form .btn-close').html('Back');
                                cleanPreviewsFolder();
                                skipClose = false;
                            }
                        }

                    },
                    error: function(e) {
                        $("#upload-paint-form #err").html(e).fadeIn();
                    }                     
                });

            }
        }
    });

    var skipClose = false;

    //  Behaves accordingly in case of changes on upload bar
    $('#update-paint-form #uploadImageForUpdate').change(function() {
        $('#update-paint-form .btn-prev').attr('disabled', false);

        var previewSet = $('#update-paint-form #preview').html().length > 0;

        if (previewSet) {
            skipClose = true;
            $('#update-paint-form .btn-close').click();
        }

    });

    // CSRF Protection Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("input[name='_token']")[0].value
        }
    });

    // Ajax call triggered in case of update request
    $("#update-paint-form .btn-prev").click(function() {

        var className = $(this)[0].className;
        if (className.endsWith('btn-info') && !skipClose) {

            $('#update-paint-form .btn-close').toggleClass('btn-prev btn-close btn-success btn-info');
            $('#update-paint-form .btn-prev').html('Preview');
            $('#update-paint-form #preview').html('').fadeOut();

        } else {

            var image = $("#update-paint-form #uploadImageForUpdate")[0].files[0];
            var formData = new FormData();
            formData.append('image', image);

            if (image != undefined) {

                $.ajax({
                    url: "get_image_preview",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false, // Needed in case of sending DOM objects
                    success: function(data) {
                        
                        var fixedUrl = document.location.href
                                                .split("public")[0]
                                                .concat('public/');

                        var imgData = JSON.parse(data).imgTag;
                        var success = JSON.parse(data).success;

                        imgData = imgData.split("src='")[0]
                                            .concat("src='", fixedUrl, imgData.split("src='")[1]);

                        if (success) {
                            if (imgData != '') {
                                $("#update-paint-form #preview").html(imgData).fadeIn();
                                $('#update-paint-form .btn-prev').toggleClass('btn-prev btn-close btn-success btn-info');
                                $('#update-paint-form .btn-close').html('Back');
                                cleanPreviewsFolder();
                                skipClose = false;
                            }
                        }

                    },
                    error: function(e) {
                        $("#update-paint-form #err").html(e).fadeIn();
                    }                     
                });

            }

        }

    });

});

// Clean all the images on previews folder path
function cleanPreviewsFolder() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("input[name='_token']")[0].value
        }
    });

    $.ajax({
        url: "delete_preview",
        type: "POST",
        cache: false,
        success: function(data) {
            console.log('Current preview sucessfully deleted');
        },
        error: function(e) {
            console.log("Exception: " + e)
        }                     
    });

}

// Executes a call to get more jobs
function loadPaints(id) {

    var totalImages = parseFloat($('.paintings-items-container').attr('data-total-images'));
    var imagesLoaded = parseFloat($('.paintings-items-container').attr('data-loaded-images'));

    imagesToLoad = totalImages - imagesLoaded;

    if (imagesToLoad > 2) {
        imagesToLoad = 2
    }
    
    var xhttp;  
  
    if (id == "") {
        document.getElementById('.paintings-items-container').innerHTML = "";
        return;
    }
    
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('.wrapper-row').append(this.responseText);
            relocateLastChild();
        }
    };

    var parameters = { id : id, imagesLoaded : imagesLoaded, imagesToLoad : imagesToLoad }

    var url = "load/" + id + "/" + imagesLoaded + "/" + imagesToLoad;
    var hash = getUrlHashToken('paintings.load', parameters);

    xhttp.open("GET", url + "?signature=" + hash, true);

    xhttp.send();

    if (imagesToLoad > 0 ) {
        $('.paintings-items-container').attr('data-loaded-images', imagesLoaded + imagesToLoad)
    }

    imagesLoaded = parseFloat($('.paintings-items-container').attr('data-loaded-images'));

    if ((totalImages - imagesLoaded) > 0) {
        $('#btn-container').show();
    } else {
        $('#btn-container').hide();
    }

}

// Controls if load more items button has to be in sight or not
function controlLoadButtonFlow() {

    $(document).ready(function() {

        $('.paintings-items-container').attr('data-loaded-images', $('.first > img').length);

        var totalImages = parseFloat($('.paintings-items-container').attr('data-total-images'));
        var imagesLoaded = parseFloat($('.paintings-items-container').attr('data-loaded-images'));
    
        if ((totalImages - imagesLoaded) > 0) {
            $('#btn-container').show();
        } else {
            $('#btn-container').hide();
        }

    })

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

  // Catches selected paint info to show it on the modal
  function catchDataOnUpdateClick() {

    $(document).ready(function() {
        $('.update-btn-modify').click(function() {

            $("#update-paint-form input[name='paintId']").val(this.value);

            dataContainer = $('.paint-box-'
                                .concat(this.value)
                                .concat(' .paint-data-container'));

                                console.log(dataContainer);

            title = $("#update-paint-form input[name='title']")
            date = $("#update-paint-form input[name='date']")
            description = $("#update-paint-form textarea[name='description']")

            titleData = dataContainer.children()[1].textContent;
            dateData = dataContainer.children()[3].innerHTML;
            descriptionData = dataContainer.children()[5].textContent;
            imgData = $('.first img')[0].src;

            title.val(titleData);
            date.val(dateData);
            description.val(descriptionData);

      })
    })

  }

  // Catches paint id in case of clicked
  function catchDataOnDeleteClick() {
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            $("#confirm-delete input[name='delete-paintId']").val(this.value);
        })
    })
  }

 

    // Centers paint in odd case
    function relocateLastChild() {

        $(document).ready(function() {
            children = parseFloat($('.wrapper-row').children().filter('div.col-md-6').length)

            if (children % 2 != 0) {
                lastChild = $('.wrapper-row')
                                .children()
                                .filter('div.col-md-6')
                                .last();
        
                lastChild.css('margin', '0 auto');
            }
        })
        
    }
    
// Functions running since document ready

catchDataOnUpdateClick();
catchDataOnDeleteClick();
controlLoadButtonFlow();
relocateLastChild();
