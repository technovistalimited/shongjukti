<?php

namespace Technovistalimited\Shongjukti\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Attachment Model Class.
 *
 * @category   Models
 * @package    Laravel
 * @subpackage TechnoVistaLimited/Shongjukti
 * @author     Mayeenul Islam <wz.islam@gmail.com>
 * @author     Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @license    GPL3 (http://www.gnu.org/licenses/gpl-3.0.html)
 * @link       https://github.com/technovistalimited/shongjukti/
 */
class AttachmentType extends Model
{
    protected $fillable = [
        'scope_key',
        'name',
        'name_bn',
        'accepted_extensions',
        'weight',
        'is_active',
        'is_required',
        'is_label_accepted',

        'created_by',
        'updated_by'
    ];


    /**
     * Get Attachment Types by Scope Key.
     *
     * @param  string  $scopeKey    Scope Key.
     * @param  integer $limit       Max data to be fetched. 'False' to fetch all.
     * @param  boolean $paginate    Whether to paginate or not.
     * @param  boolean $activeOnly  Whether to fetch 'all' or active only.
     *
     * @since v1.1.0 - Get all the fields instead of localized. Localize later.
     *
     * @return object               Attachment Types Object.
     * -----------------------------------------------------------------------
     */
    public static function getAttachmentTypesByScopeKey($scopeKey, $limit = false, $paginate = false, $activeOnly = true)
    {
        $attachmentTypes = DB::table('attachment_types')
            ->select(
                'id',
                'name',
                'name_bn',
                'accepted_extensions',
                'is_active',
                'weight',
                'is_required',
                'is_label_accepted'
            )
            ->where('scope_key', $scopeKey)
            ->orderBy('weight', 'asc')
            ->orderBy('is_required', 'desc')
            ->orderBy('name', 'asc');

        if ($activeOnly) {
            $attachmentTypes = $attachmentTypes->where('is_active', 1);
        }

        if ($limit) {
            if ($paginate) {
                $attachmentTypes = $attachmentTypes->paginate($limit);
            } else {
                $attachmentTypes = $attachmentTypes->get($limit);
            }
        } else {
            $attachmentTypes = $attachmentTypes->get();
        }

        return $attachmentTypes;
    }


    /**
     * Get Attachment Types
     *
     * @param integer $attachmentTypeId Attachment Type.
     *
     * @return array
     * -----------------------------------------------------------------------
     */
    public static function getAcceptedExtensionsByType($attachmentTypeId)
    {
        return DB::table('attachment_types')
            ->select('accepted_extensions')
            ->where('id', intval($attachmentTypeId))
            ->first();
    }
}
