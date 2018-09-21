$(document).ready(function () {

    $('body').on('click', '.info', function () {
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            type: 'GET',
            url: '/issues/images',
            data: {
                id: id,
                status: status
            },
            success: function (response) {
                var images = '';
                $.each(response, function (key, image) {
                    images += '<a href="' + image.file_name + '"><img src="' + image.file_name + '" alt="..." style="height:150px; width:150px;"  class="img-thumbnail img-fluid"></a>' + "\n";
                });
                $('.popup-gallery').html(images);
                $('#images-modal').modal('toggle');
            },
            error: function (response) {
                console.log(response);
            }
        });

    });


    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            titleSrc: function (item) {
                return '<small>the initial status of broken phone</small>';
            }
        },
        callbacks: {
            open: function () {
                $('#images-modal').modal('toggle');
                console.log('fsdfsdf');
            },
            close: function () {
                $('#images-modal').modal('toggle');
            }
        }
    });







});
