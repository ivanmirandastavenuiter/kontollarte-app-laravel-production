
$(document).ready(function() {

    var skipClose = false;

    $('#uploadImage').change(function() {
        $('.btn-prev').attr('disabled', false);

        var previewSet = $('#preview').html().length > 0;

        if (previewSet) {
            skipClose = true;
            $('.btn-close').click();
        }

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("input[name='_token']")[0].value
        }
    });

    $(".btn-prev").click(function() {

        var className = $(this)[0].className;
        console.log(className);

        if (className.endsWith('btn-info') && !skipClose) {

            $('.btn-close').toggleClass('btn-prev btn-close btn-success btn-info');
            $('.btn-prev').html('Preview');
            $('#preview').html('').fadeOut();

        } else {

            var image = $("#uploadImage")[0].files[0];
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
                                $("#preview").html(imgData).fadeIn();
                                $('.btn-prev').toggleClass('btn-prev btn-close btn-success btn-info');
                                $('.btn-close').html('Back');
                                cleanPreviewsFolder();
                                skipClose = false;
                            }
                        }

                    },
                    error: function(e) {
                        $("#err").html(e).fadeIn();
                    }                     
                });

            }

        }

    });

});

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
    
function loadPaints(id) {

    var totalImages = parseFloat($('#main-wrapper').attr('data-total-images'));
    var imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));

    imagesToLoad = totalImages - imagesLoaded;

    if (imagesToLoad > 2) {
        imagesToLoad = 2
    }
    
    var xhttp;  
  
    if (id == "") {
        document.getElementById("main-wrapper").innerHTML = "";
        return;
    }
    
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $("#main-wrapper").append(this.responseText);
        }
    };
    var url = "load/" + id + "/" + imagesLoaded + "/" + imagesToLoad;
    console.log('URL: ' + url);
    xhttp.open("GET", "load/" + id + "/" + imagesLoaded + "/" + imagesToLoad, true);

    xhttp.send();

    if (imagesToLoad > 0 ) {
        $('#main-wrapper').attr('data-loaded-images', imagesLoaded + imagesToLoad)
    }

    imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));

    if ((totalImages - imagesLoaded) > 0) {
        $('#btn-container').show();
    } else {
        $('#btn-container').hide();
    }

}

function controlLoadButtonFlow() {

    $(document).ready(function() {

        $('#main-wrapper').attr('data-loaded-images', $('.col-12 > img').length);

        var totalImages = parseFloat($('#main-wrapper').attr('data-total-images'));
        var imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));
    
        if ((totalImages - imagesLoaded) > 0) {
            $('#btn-container').show();
        } else {
            $('#btn-container').hide();
        }

    })

}

// Executed automatically

controlLoadButtonFlow();
