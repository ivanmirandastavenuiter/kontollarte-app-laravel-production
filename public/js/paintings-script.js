
function uploadPaint() {

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("input[name='_token']")[0].value
            }
        });

        $("#btn-prev").click(function() {

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
                    beforeSend : function() {
                        $("#preview").fadeOut();
                        $("#err").fadeOut();
                    },
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
                            }
                        }

                    },
                    error: function(e) {
                        $("#err").html(e).fadeIn();
                    }                     
                });

            }

        });
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
uploadPaint();
