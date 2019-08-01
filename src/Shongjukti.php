<?php

/**
 * Initialize Shongjukti
 *
 * @package    Laravel
 * @subpackage TechnoVistaLimited/Shongjukti
 */

namespace Technovistalimited\Shongjukti;

use Technovistalimited\Shongjukti\App\Controllers\AttachmentController;
use Technovistalimited\Shongjukti\App\Models\AttachmentType;
use Technovistalimited\Shongjukti\App\Models\Attachment;

class Shongjukti
{
    public static function getAttachmentTypesByScopeKey($scopeKey)
    {
        return AttachmentType::getAttachmentTypesByScopeKey($scopeKey, false, false, true);
    }

    public static function storeAttachments($inputs, $scopeKey = null, $scopeId = null)
    {
        return Attachment::storeAttachments($inputs, $scopeKey, $scopeId);
    }

    public static function getAttachments($scopeKey, $scopeId)
    {
        return Attachment::getAttachments($scopeKey, $scopeId);
    }

    public static function getAttachmentsForEdit($scopeKey, $scopeId)
    {
        return Attachment::getAttachmentsForEdit($scopeKey, $scopeId);
    }

    public static function attachmentTypeIndexLink($scopeKey = null)
    {
        return route('attachment_type.index', ['scope_key' => $scopeKey]);
    }

    public static function attachmentTypeCreateLink()
    {
        return route('attachment_type.create');
    }

    public static function attachmentTypeEditLink($id)
    {
        return route('attachment_type.edit', ['id' => $id]);
    }

    public static function bytesToMb($bytes)
    {
        return AttachmentController::bytesToMb($bytes);
    }

    public static function mimeTypesFromExtensions($fileExtensions)
    {
        return AttachmentController::mimeTypesFromExtensions($fileExtensions);
    }
}
