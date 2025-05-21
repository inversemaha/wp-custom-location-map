jQuery(document).ready(function($){
    var frame;
    $('#clmp_image_upload').on('click', function(e){
        e.preventDefault();
        if(frame){
            frame.open();
            return;
        }
        frame = wp.media({
            title: 'Select or Upload Image',
            button: { text: 'Use this image' },
            multiple: false
        });
        frame.on('select', function(){
            var attachment = frame.state().get('selection').first().toJSON();
            $('#clmp_image_id').val(attachment.id);
            $('#clmp_image_preview').attr('src', attachment.url).show();
            $('#clmp_image_remove').show();
        });
        frame.open();
    });
    $('#clmp_image_remove').on('click', function(){
        $('#clmp_image_id').val('');
        $('#clmp_image_preview').hide();
        $(this).hide();
    });
});