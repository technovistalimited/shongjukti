<?php
/**
 * Initialize Shongjukti
 *
 * @package    laravel
 * @subpackage shongjukti
 */
namespace Technovistalimited\Shongjukti;

use Technovistalimited\Shongjukti\App\Controllers\AttachmentTypeController;
use Technovistalimited\Shongjukti\App\Controllers\AttachmentController;
use Technovistalimited\Shongjukti\App\Models\AttachmentType;
use Technovistalimited\Shongjukti\App\Models\Attachment;

class Shongjukti
{
	public static function attachmentTypeIndexLink($scopeKey = null)
	{
		return action( 'AttachmentController@index', ['scope_key' => $scopeKey] );
	}

	public static function attachmentTypeCreateLink()
	{
		return action( 'AttachmentController@create' );
	}

	public static function attachmentTypeEditLink($id)
	{
		return action( 'AttachmentController@edit', ['id' => $id] );
	}
}
