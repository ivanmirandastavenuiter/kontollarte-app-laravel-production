$(document).ready(function() {
    
    $(document).on('click', '.add-btn', function() {
        var galleryId = $(this).data('gallery-id');
        $('.modal-footer #confirm-gallery-id-add-form').attr('action', galleryId);
    });

    $(document).on('click', '.dlt-btn', function() {
        var deleteId = $(this).data('delete-id');
        $('.modal-footer #confirm-gallery-id-delete-form').attr('action', deleteId.trim());
        $.ajax({
            method  : "GET",
            url     : "details",
            contentType: "json",
            data: { "galleryId" : deleteId.split("/")[1] },
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
                  
            },
            error : function(e) {
                console.log('Error: ' + e);
            }
        })

    });

    $(document).on('click', '.refresh-galleries-btn', function() {
        
        $.ajax({
            method  : "GET",
            url     : "reload",
            dataType: "html",
            success : function(data) {
                $('.cards-container').append(data);
            },
            error : function(e) {
                console.log('Error: ' + e);
            }
        })

    });

})