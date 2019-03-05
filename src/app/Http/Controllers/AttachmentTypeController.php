<?php

namespace Technovistalimited\Shongjukti\App\Controllers;

use Technovistalimited\Shongjukti\App\Models\AttachmentType;
use Technovistalimited\Shongjukti\App\Models\Attachment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AttachmentTypeController extends Controller
{
	/**
	 * Index/List.
	 *
	 * @param  string $scopeKey Scope Key.
	 *
	 * @return \Illuminate\Http\Response
	 * --------------------------------------------------------------------------
	 */
	public function index( $scopeKey = '' ) {
	    $attachmentScopes = (array) config('shongjukti.attachment_scopes');

	    if( ! empty($scopeKey) && ! array_key_exists($scopeKey, $attachmentScopes) ) {
	        return abort(404);
	    }

	    $itemsPerPage = 20;

	    // Fetch all, not just active; but paginate to $itemsPerPage max.
	    $attachmentTypes = AttachmentType::getAttachmentTypesByScopeKey($scopeKey, $itemsPerPage, true, false);

	    return view('shongjukti::attachment-types.index', compact('attachmentScopes', 'attachmentTypes', 'scopeKey', 'itemsPerPage'));
	}


	/**
	 * Create/Add.
	 *
	 * @return \Illuminate\Http\Response
	 * --------------------------------------------------------------------------
	 */
	public function create() {
	    $attachmentScopes = (array) config('shongjukti.attachment_scopes');

	    return view('shongjukti::attachment-types.create', compact('attachmentScopes'));
	}


	/**
	 * Store.
	 *
	 * @param  Request $request Request.
	 *
	 * @return \Illuminate\Http\Response
	 * --------------------------------------------------------------------------
	 */
	public function store(Request $request)
	{
	    try
	    {
	        $inputs = $request->all();

	        $inputs['created_by'] = Auth::id();

	        if ( !isset($inputs['is_label_accepted']) ) {
	            $inputs['is_label_accepted'] = 0;
	        }

	        if ( empty($inputs['weight']) ) {
	            $inputs['weight'] = 0;
	        }

	        // Validate.
	        $rules = array(
	            'scope_key'   => 'required',
	            'name'        => 'required|string|max:255',
	            'is_active'   => 'required',
	            'is_required' => 'required'
	        );

	        $validator = Validator::make($inputs, $rules);

	        if ($validator->fails()) {

	            return back()->withErrors($validator)->withInput($request->all);

	        } else {

	            // Starting database transaction
	            DB::beginTransaction();

	                $attachmentType = AttachmentType::create($inputs);

	            // Commit all transaction
	            DB::commit();

	            Session::flash('success', 'Saved successfully!');

	            // Redirect to edit mode.
	            $editPageUrl = Shongjukti::attachmentTypeEditLink($attachmentType->id);
	            // $editPageUrl = action('AttachmentTypeController@edit', ['attachmentTypeId' => $attachmentType->id]);
	            return redirect( $editPageUrl );

	        }

	    }
	    catch (\Exception $e) {

	        // Rollback all transaction if error occurred
	        DB::rollBack();

	        return back()->withErrors('dangerMsg', $e->getMessage())->withInput($request->all);

	    }
	}


	/**
	 * Edit.
	 *
	 * @param  integer $id Attachment Type ID.
	 *
	 * @return \Illuminate\Http\Response
	 * --------------------------------------------------------------------------
	 */
	public function edit($id) {
	    $attachmentScopes = (array) config('shongjukti.attachment_scopes');
	    $attachmentType   = AttachmentType::findOrFail($id);

	    return view('shongjukti::attachment-types.edit', compact('attachmentScopes', 'attachmentType'));
	}


	/**
	 * Update.
	 *
	 * @param  Request $request Request.
	 * @param  string  $id      Item ID.
	 *
	 * @return \Illuminate\Http\Response
	 * --------------------------------------------------------------------------
	 */
	public function update(Request $request, $id) {
	    try {
	        $inputs = $request->all();

	        // validate
	        $rules = array(
	            'scope_key'   => 'required',
	            'name'        => 'required|string|max:255',
	            'is_active'   => 'required',
	            'is_required' => 'required'
	        );

	        $validator = Validator::make($inputs, $rules);

	        if ($validator->fails()) {

	            return back()->withErrors($validator)->withInput($request->all);

	        } else {

	            // Starting database transaction
	            DB::beginTransaction();

	                $attachmentType = AttachmentType::findorfail($id);

	                $inputs['updated_by'] = Auth::id();

	                if (!isset($inputs['is_label_accepted'])) {
	                    $inputs['is_label_accepted'] = 0;
	                }

	                if ( empty($inputs['weight']) ) {
	                    $inputs['weight'] = 0;
	                }

	                $attachmentType->update($inputs);

	            // Commit all transaction
	            DB::commit();

	            Session::flash('success', 'Updated successfully!');

	            return back();
	        }

	    } catch (\Exception $e) {

	        // Rollback all transaction if error occurred
	        DB::rollBack();

	        return back()->withErrors('dangerMsg', $e->getMessage())->withInput($request->all);
	    }
	}


	/**
	 * Destroy/Delete.
	 *
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * --------------------------------------------------------------------------
	 */
	public function destroy($id) {
	    $used = Attachment::where('attachment_type_id', $id)->first();
	    if( ! empty($used) ) {
	        return back()->withErrors('dangerMsg', 'Cannot delete. The type is in use.');
	    }

	    $attachmentType = AttachmentType::find($id);
	    $attachmentType->delete();

	    return back()->with('success', 'Deleted Successfully');
	}
}
