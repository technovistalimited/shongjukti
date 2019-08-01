/**
 * Shongjukti
 *
 * JavaScripts responsible for adding/editing attachments.
 *
 * @package    laravel
 * @subpackage shongjukti
 */
 jQuery(document).ready(function() {

    // Indicate that JavaScript is loaded.
    $('html').addClass('js');


    // When the 'remove' button is pressed...
    $('body').on('click', '.btn-file-remove', function() {
        var this_delete_btn          = $(this);
        var this_attachment_row      = this_delete_btn.parents('.attachment-row');
        var attachment_is_deleted    = this_attachment_row.find('.attachment-is-deleted');
        var attachment_existing_mime = this_attachment_row.find('.attachment-existing-mime');
        var attachment_view_btn      = this_attachment_row.find('.btn-view');

        attachment_is_deleted.val('1');
        attachment_view_btn.hide();
        this_delete_btn.hide();

        var attachment_file_field = this_attachment_row.find('.attachment-file');
        this_attachment_row.find('.btn-file').removeClass('hide d-none');
        if( attachment_file_field.parents('.attachment-file-group').hasClass('file-required') ) {
            attachment_file_field.prop('required', true);
        }
    });


    // Bootstrap File Select
    // http://www.abeautifulsite.net/whipping-file-inputs-into-shape-with-bootstrap-3/
    $('body').on('change', '.attachment-file', function() {
        var input                 = $(this);
        var button                = input.parent('.btn-file');
        var this_attachment_row   = input.parents('.attachment-row');
        var attachment_is_deleted = this_attachment_row.find('.attachment-is-deleted');

        if( 'undefined' !== typeof(this.files[0]) ) {
            var numFiles       = input.get(0).files ? input.get(0).files.length : 1;
            var label          = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            var mime_type      = this.files[0].type;
            var accepted_types = input.attr('accept').split(',');

            // Display error message
            // if mime_type is undetectable, or detected mime_type is not in accepted mime_types array.
            if( ('' == mime_type) || ('' !== mime_type && -1 == accepted_types.indexOf(mime_type)) ) {
                button.find('span').html('<span class="text-danger">'+ _attachments.file_type_msg +'</span>');
            }
            // Display error message
            // if the filesize exceeds the maximum upload size allowed.
            else if( this.files[0].size > _attachments.max_upload_size ) {
                button.find('span').html('<span class="text-danger">'+ _attachments.file_size_msg +'</span>');
            } else {
                var custom_label = label.length > 15 ? '...' + label.slice(-15) : label;
                button.find('span').html( custom_label );

                attachment_is_deleted.val('0');

                // optional field.
                if( false == this_attachment_row.hasClass('row-required') ) {
                    this_attachment_row.find('.attachment-label').prop('required', true);
                }
            }
        } else {
            button.find('span').html(_attachments.browse_text);

            // optional field.
            if( false == this_attachment_row.hasClass('row-required') ) {
                this_attachment_row.find('.attachment-label').removeAttr('required');
            }
        }
    });

});
