<?php

namespace App\Model;

use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use App\Model\Settings\AttachmentTypes;
use App\Http\Controllers\AttachmentsController;

class Attachments extends Model
{
    protected $fillable = [
        'scope_key',
        'scope_id',
        'attachment_type_id',
        'attachment_label',
        'mime_type',
        'attachment_path'
    ];


    /**
     * Upload Individual Attachment.
     *
     * @param  array        $file     Array of Form file.
     * @param  null|string  $scopeKey Scope Key.
     * @param  null|integer $scopeId  Scope ID.
     *
     * @return string                 Path of the new upload, otherwise error.
     * -----------------------------------
     */
    public static function uploadAttachment($file, $scopeKey = null, $scopeId = null)
    {
        // STORAGE DIRECTORY STRUCTURE.
        // Make up the directory structure.
        $_parent = null === $scopeKey ? date('Y') : $scopeKey; // if not scope key, year
        $_child  = null === $scopeId ? date('m') : $scopeId; // if not scope id, month

        $_public_path = "public/attachments/{$_parent}/{$_child}";

        // Generate filename to avoid conflict. Original filename is for the file extension.
        $_filename = time() . '-' . $file->getclientoriginalname();
        // If still, same file exists, prepend '1' to the file name.
        if( file_exists(public_path( str_replace('public/', 'storage/', $_public_path) .'/'. $_filename )) ) {
            $_filename = '1'. $_filename;
        }

        // save to /storage/app/public/attachments/scope/id/ as the new $_filename
        $_file_path = $file->storeAs($_public_path, $_filename);

        // Replace 'public' path with 'storage' path;
        // prepend slash to facilitate the base URL.
        //
        // Bug fixed:
        // Unwanted slashes are incorporated to avoid renaming
        // file name instead of directory.
        $_new_path = str_replace('public/', '/storage/', $_file_path);

        return $_new_path;
    }


    /**
     * Store Attachments.
     *
     * Store all the attachments one by one based on array data.
     *
     * @param  array $inputs    Array of Inputs.
     * @param  string $scopeKey Scope Key.
     * @param  integer $scopeId Scope ID.
     * @return array|boolean    If uploads succeed, returns true, else array of errors.
     * -----------------------------------
     */
    public static function storeAttachments($inputs, $scopeKey = null, $scopeId = null) {

        $_errors = array();
        $_err    = false;

        if (is_array($inputs['attachments'])) {
            foreach ($inputs['attachments'] as $_file) {

                // Set default values to avoid undefined index warning.
                $_path      = '';
                $_mime_type = '';

                $_attachment_id     = $_file['attachment_id'];
                $_type_id           = intval($_file['attachment_type_id']);
                $_is_required       = ( $_file['is_required'] == 1 ) ? true : false;
                $_is_label_accepted = ( $_file['is_label_accepted'] == 1 ) ? true : false;
                $_is_deleted        = ( isset($_file['is_deleted']) && $_file['is_deleted'] == 1 ) ? true : false;

                // -------------------------------------------------------
                // NEW ATTACHMENT ----------------------------------------
                // -------------------------------------------------------
                if ( isset($_file['attachment_file']) && ! empty($_file['attachment_file']) ) {

                    // Proceed with the default accepted files.
                    $_extensions = AttachmentsController::$defaultExtensions;

                    if ( ! empty($_type_id) ) {

                        // Accepted extensions per attachment type.
                        $_type_extensions = AttachmentTypes::getAcceptedExtensionsByType($_type_id);

                        if( ! empty($_type_extensions->accepted_extensions) ) {
                            $_extensions = $_type_extensions->accepted_extensions;
                        }

                    }

                    // Get mime types from extensions.
                    $_accepted_mime_types = AttachmentsController::mimeTypesFromExtensions($_extensions);

                    // Get the mime type of the uploaded file.
                    $_mime_type = $_file['attachment_file']->getMimeType();
                    // If it's not in the accepted MIME type list, don't upload it.
                    if ( ! in_array($_mime_type, $_accepted_mime_types) ){
                        $_errors['invalid_mime_type'] = __('File not uploaded because the file type is not accepted.');
                        $_err = true;
                    }

                    // Skip erroneous upload.
                    if( $_err ) continue;

                    // Upload the file and return the file path.
                    $_path = self::uploadAttachment($_file['attachment_file'], $scopeKey, $scopeId);

                }

                // -------------------------------------------------------
                // COMMON FIELDS (when applicable) -----------------------
                // -------------------------------------------------------

                // Attachment Label.
                // Available only when the custom label is accepted.
                if (isset($_file['attachment_label']) && !empty($_file['attachment_label'])) {
                    $_label = $_file['attachment_label'];
                } else {
                    $_label = '';
                }

                // Error: Required label not provided.
                if( $_is_required && $_is_label_accepted && empty($_label) ) {
                    $_errors["label_required_{$_type_id}"] = __('A required label was not provided');
                    $_err = true;
                }

                // Skip erroneous upload.
                if( $_err ) continue;

                if( $_attachment_id )
                {

                    // -------------------------------------------------------------
                    // Edit Mode ----------------------------------------------------
                    // -------------------------------------------------------------

                    $_is_exists = self::isAttachmentExists($scopeKey, $scopeId, $_type_id);

                    if( $_is_exists ) {

                        if( ! $_is_required && $_is_deleted ) {
                            if( empty($_path) && !empty($_is_exists->attachment_path) ) {
                                // exists. but delete.
                                self::deleteAttachment($scopeKey, $scopeId, $_is_exists->attachment_path);
                            }
                        }

                        $attachment_path = empty($_path) ? $_is_exists->attachment_path : $_path;
                        $mime_type       = empty($_mime_type) ? $_is_exists->mime_type : $_mime_type;

                        // exists. update.
                        self::updateAttachment([
                                'scope_key'          => trim($scopeKey),
                                'scope_id'           => intval($scopeId),
                                'attachment_type_id' => $_type_id,
                                'attachment_label'   => trim($_label),
                                'mime_type'          => trim($mime_type),
                                'attachment_path'    => trim($attachment_path)
                            ],
                            trim($_is_exists->attachment_path)
                        );

                    } else {

                        if( empty($_path) ) {
                            if( $_is_required ) {
                                $_errors["file_required_{$_type_id}"] = __('A required file was not uploaded');
                                $_err = true;

                                continue;
                            } else {
                                // Don't store empty value in database.
                                continue;
                            }
                        }

                        // not exists. add.
                        self::addAttachment([
                            'scope_key'          => trim($scopeKey),
                            'scope_id'           => intval($scopeId),
                            'attachment_type_id' => $_type_id,
                            'attachment_label'   => trim($_label),
                            'mime_type'          => trim($_mime_type),
                            'attachment_path'    => trim($_path)
                        ]);
                    }

                }
                else
                {
                    // -------------------------------------------------------------
                    // Add Mode ----------------------------------------------------
                    // -------------------------------------------------------------
                    if( empty($_path) ) {
                        if( $_is_required ) {
                            $_errors["file_required_{$_type_id}"] = __('A required file was not uploaded');
                            $_err = true;

                            continue;
                        } else {
                            // Don't store empty value in database.
                            continue;
                        }
                    }

                    self::addAttachment([
                        'scope_key'          => trim($scopeKey),
                        'scope_id'           => intval($scopeId),
                        'attachment_type_id' => $_type_id,
                        'attachment_label'   => trim($_label),
                        'mime_type'          => trim($_mime_type),
                        'attachment_path'    => trim($_path)
                    ]);
                }

            } //endforeach
        } //endif

        return empty($_errors) ? true : $_errors;

    }

    /**
     * Check if Attachment Exists or not.
     *
     * @param  string  $scopeKey     Scope Key.
     * @param  integer $scopeId      Scope ID.
     * @param  integer $typeId       Scope ID.
     * @param  string  $existingPath Existing Path, where possible.
     *
     * @return boolean|object        Attachment object if exists, False otherwise.
     * -----------------------------------
     */
    public static function isAttachmentExists($scopeKey, $scopeId, $typeId, $existingPath = null)
    {
        $attachment = DB::table('attachments')
                        ->where('scope_key', $scopeKey)
                        ->where('scope_id', $scopeId)
                        ->where('attachment_type_id', $typeId);

        if( null !== $existingPath ) {
            $attachment = $attachment->where('attachment_path', $existingPath);
        }

        $attachment = $attachment->first();

        if( ! $attachment ) return false;

        return $attachment;
    }

    /**
     * Add Attachment to the Database.
     *
     * @param   array $data Array of data.
     *
     * @return  void
     * -----------------------------------
     */
    public static function addAttachment($data)
    {
        DB::table('attachments')->insert($data);
    }

    /**
     * Update Attachment to the Database.
     *
     * - update on database
     * - delete from file path.
     *
     * @see    self::removeAttachment() To delete file from path.
     *
     * @param  array  $data         Array of data.
     * @param  string $existingPath Existing Path, if found.
     *
     * @return void
     * -----------------------------------
     */
    public static function updateAttachment($data, $existingPath = null)
    {
        if( empty($data) ) return false;

        DB::table('attachments')
            ->where('scope_key', $data['scope_key'])
            ->where('scope_id', $data['scope_id'])
            ->where('attachment_type_id', $data['attachment_type_id'])
            ->update($data);

        if( ! empty($existingPath) ) {
            self::removeAttachment($existingPath);
        }
    }

    /**
     * Delete Attachment.
     *
     * - from database
     * - from file path.
     *
     * @see    self::removeAttachment() To delete file from path.
     *
     * @param  string  $scopeKey     Scope Key.
     * @param  integer $scopeId      Scope ID.
     * @param  string  $existingPath Existing Path.
     *
     * @return true                  True, while deleted.
     * -----------------------------------
     */
    public static function deleteAttachment($scopeKey, $scopeId, $existingPath)
    {
        DB::table('attachments')
            ->where('scope_key', $scopeKey)
            ->where('scope_id', $scopeId)
            ->where('attachment_path', $existingPath)
            ->delete();

        self::removeAttachment($existingPath);
    }

    /**
     * Delete the Physical File from path.
     *
     * NOTE:
     * Public path with unlink() function won't work if
     * symlink is not activated.
     *
     * @param  string $existingPath Path to the existing file.
     *
     * @return boolean True if succeed, False otherwise.
     * -----------------------------------
     */
    public static function removeAttachment($existingPath)
    {
        // Stripping out the leading slash to use with public_path().
        $_modified_path = str_replace('/storage', 'storage', $existingPath);
        if( file_exists($_modified_path) ) {
            return unlink( public_path($_modified_path) );
        }

        return false;
    }


    /**
     * Get Attachments for Edit.
     *
     * @param string  $scopeKey Scope Key
     * @param integer $scopeId  Scope ID
     *
     * @return array
     * -----------------------------------------------------------------------
     */
    public static function getAttachmentsForEdit($scopeKey, $scopeId)
    {
        $name = App::isLocale('en') ? 'name' : 'name_bn';

        $_attachments = array();

        $_db_attachments = DB::table('attachments')
            ->leftJoin('attachment_types', 'attachment_types.id', '=', 'attachments.attachment_type_id')
            ->select(
                'attachments.id',
                'attachments.attachment_type_id',
                'attachments.attachment_label',
                'attachments.mime_type',
                'attachments.attachment_path',
                "attachment_types.{$name} as name"
            )
            ->where('attachments.scope_key', $scopeKey)
            ->where('attachments.scope_id', $scopeId)
            ->orderBy('attachment_types.weight', 'asc')
            ->orderBy('attachment_types.is_required', 'desc')
            ->orderBy('attachment_types.name', 'asc')
            ->get();

        foreach ($_db_attachments as $_db_attachment) {
            $_attachments[$_db_attachment->attachment_type_id] = array(
                'id'        => $_db_attachment->id,
                'type_id'   => $_db_attachment->attachment_type_id,
                'label'     => $_db_attachment->attachment_label,
                'mime_type' => $_db_attachment->mime_type,
                'path'      => $_db_attachment->attachment_path
            );
        }

        return $_attachments;
    }

    /**
     * Get Attachments.
     *
     * Get attachments for view mode.
     *
     * @param string  $scopeKey Scope Key
     * @param integer $scopeId  Scope ID
     *
     * @return object
     * -----------------------------------------------------------------------
     */
    public static function getAttachments($scopeKey, $scopeId)
    {
        $name = App::isLocale('en') ? 'name' : 'name_bn';

        $attachmentsObj = DB::table('attachments')
            ->leftJoin('attachment_types', 'attachment_types.id', '=', 'attachments.attachment_type_id')
            ->select(
                'attachments.id',
                'attachments.attachment_type_id',
                'attachments.attachment_label',
                'attachments.attachment_path',
                "attachment_types.{$name} as name",
                "attachment_types.is_required"
            )
            ->where('attachments.scope_key', $scopeKey)
            ->where('attachments.scope_id', $scopeId)
            ->orderBy('attachment_types.weight', 'asc')
            ->orderBy('attachment_types.is_required', 'desc')
            ->orderBy('attachment_types.name', 'asc')
            ->get();

        return $attachmentsObj;
    }
}
