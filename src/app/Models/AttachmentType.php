<?php

namespace Technovistalimited\Shongjukti\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

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
     * @return object               Attachment Types Object.
     * -----------------------------------------------------------------------
     */
    public static function getAttachmentTypesByScopeKey($scopeKey, $limit = false, $paginate = false, $activeOnly = true)
    {
    	$name = App::isLocale('en') ? 'name' : 'name_bn';

    	$attachmentTypes = DB::table('attachment_types')
	    	->select(
	    		'attachment_types.id',
	    		"attachment_types.{$name} as name",
	    		'attachment_types.accepted_extensions',
	    		'attachment_types.is_active',
	    		'attachment_types.weight',
	    		'attachment_types.is_required',
	    		'attachment_types.is_label_accepted'
	    	)
	    	->where('attachment_types.scope_key', $scopeKey)
	    	->orderBy('attachment_types.weight', 'asc')
	    	->orderBy('attachment_types.is_required', 'desc')
	    	->orderBy('attachment_types.name', 'asc');

    	if( $activeOnly ) {
    		$attachmentTypes = $attachmentTypes->where('attachment_types.is_active', 1);
    	}

    	if( $limit ) {
    		if( $paginate ) {
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
	    	->select('attachment_types.accepted_extensions')
	    	->where('attachment_types.id', intval($attachmentTypeId))
	    	->first();
    }
}
