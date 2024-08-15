jQuery(document).ready(function($) {

    if ($('#livelook').length == 0) {
        return;
    }

    fetchData();

    if ($('.live-look-controls').length == 0) {
        setInterval(function() {
            fetchData();
        }, 3000);
    }

    $('body').on('click', '.live-look-image-chooser', function(e) {
        e.preventDefault();
        var $button = $(this);

        // Create the media frame.
        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or upload image',
            library: { // remove these to show all
                type: 'image' // specific mime
            },
            button: {
                text: 'Select'
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });

        // When an image is selected, run a callback.
        file_frame.on('select', function () {
            const attachment = file_frame.state().get('selection').first().toJSON();
            selectAttachment(attachment);
        });

        // Open the modal.
        file_frame.open();
    });

    $('body').on('click', '.clear-live-look-images', function(e) {
        e.preventDefault();
        selectAttachment();
    });

    $('body').on('change', '#show-images', function() {
        if ($('#show-images').is(':checked')) {
            show();
        } else {
            selectAttachment();
            hide();
        }
    });

    function show() {
        $('.live-look-image-viewer-content').show(); 
        $('#show-images').prop('checked', true);   
        $('.image-viewer-controls').show();    
    }

    function hide() {
        $('.live-look-image-viewer-content').hide();    
        $('#show-images').prop('checked', false);   
        $('.image-viewer-controls').hide();   
    }

    function fetchData() {
        console.log('fetching data..')
        let promise = $.ajax({
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'get_live_look_image',
            },
            dataType: 'json',
        });
        
        promise.done(function (response) {
            console.log('data fetched');
            clearAttachments();

            console.log('attachment', response.attachment.url);

            if (response.attachment.url) {
                show();
                embedAttachment(response.attachment.id, response.attachment.url);
            } else {
                hide();
            }
        });
    }

    function selectAttachment(attachment = null) {

        saveData(attachment);
        clearAttachments();

        if (attachment) {
            embedAttachment(attachment.id, attachment.url);
        }
    }

    function saveData(attachment = null) {
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'save_live_look_image',
                attachment_id: attachment ? attachment.id : null,
            },
        });
    }

    function clearAttachments() {
        $('.live-look-image-viewer-content').html('');
    }

    function embedAttachment(id, url) {
        if (attachmentAlreadyEmbeded(id)) {
            return;
        }

        $('.live-look-image-viewer-content').append(`<img src="${url}" data-id="${id}" />`);
    }

    function attachmentAlreadyEmbeded(id) {
        return $(`.live-look-image-viewer-content img[data-id="${id}"]`).length > 0;
    }

});