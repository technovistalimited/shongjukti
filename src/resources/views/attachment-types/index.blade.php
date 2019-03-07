@extends('shongjukti::layouts.layout')

@section('page_header', __('shongjukti::messages.attachment_types'))

@section('page_header_right')
	<a href="{{ Shongjukti::attachmentTypeCreateLink() }}" class="btn btn-primary">
		{{ __('shongjukti::messages.add_new') }}
	</a>
@endsection

@section('content')

	<div class="panel card">
		<div class="panel-body card-body">
			<select id="scope-key-choice" class="form-control">
				<option value="">{{ __('shongjukti::messages.select_a_scope') }}</option>
				@foreach( $attachmentScopes as $scopeId => $label )
				<option value="{{ $scopeId }}" {{ trim($scopeKey) === $scopeId ? 'selected="selected"' : '' }}>{{ $label }}</option>
				@endforeach
			</select>
		</div>
	</div>

	@if( Session::has('success') )
		<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ Session::get('success') }}
		</div>
		<?php Session::forget('success'); ?>
	@endif

	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	@if( ! empty($scopeKey) )

		<h6 class="text-uppercase text-bold">{{ sprintf( __('shongjukti::messages.scope_x'), $attachmentScopes[$scopeKey] ) }}</h6>

		@if( ! $attachmentTypes->isEmpty() )

			<div class="panel card">
				<div class="table-responsive-sm">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>{{ __('shongjukti::messages.name') }}</th>
								<th>{{ __('shongjukti::messages.order') }}</th>
								<th>{{ __('shongjukti::messages.is_label') }}</th>
								<th>{{ __('shongjukti::messages.accepted_extensions') }}</th>
								<th>{{ __('shongjukti::messages.action') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach( $attachmentTypes as $attachmentType )
								<tr class="{{ $attachmentType->is_active ? '' : 'text-muted' }}">
									<td>
										<a class="{{ $attachmentType->is_active ? '' : 'text-muted' }}" href="{{ Shongjukti::attachmentTypeEditLink($attachmentType->id) }}">
											<strong>{{ $attachmentType->name }}</strong>
										</a>
										@if( ! $attachmentType->is_required )
											<span class="badge badge-default badge-secondary">{{ strtolower( __('shongjukti::messages.optional') ) }}</span>
										@endif
									</td>

									<td>
										{{ empty($attachmentType->weight) ? '-' : translateString($attachmentType->weight) }}
									</td>

									<td>
										@if( ! empty($attachmentType->is_label_accepted) )
										<?php $_fill_color = $attachmentType->is_active ? '#4CAF50' : '#999999'; ?>
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="4 4 16 16" fill="{{ $_fill_color }}" aria-hidden="true" style="display: inline-block;"><path d="M12 4a8 8 0 1 0 0 16 8 8 0 0 0 0-16zm-.833 11.528l-3-2.91 1.238-1.238 1.762 1.671 3.762-3.856 1.238 1.238-5 5.095z"/></svg> {{ __('shongjukti::messages.yes') }}
										@else
										-
										@endif
									</td>

									<td>
										{{ empty($attachmentType->accepted_extensions) ? '-' : str_limit($attachmentType->accepted_extensions, 50, '...') }}
									</td>

									<td>
										<form action="{{ route('attachment_type.delete', $attachmentType->id) }}" method="POST">
											<div class="btn-group">
												<a href="{{ Shongjukti::attachmentTypeEditLink($attachmentType->id) }}" class="btn btn-primary btn-xs">{{ __('shongjukti::messages.edit') }}</a>

												<button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs">{{ __('shongjukti::messages.delete') }}</button>
											</div>
											@csrf
											@method('DELETE')
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th>{{ __('shongjukti::messages.name') }}</th>
								<th>{{ __('shongjukti::messages.order') }}</th>
								<th>{{ __('shongjukti::messages.is_label') }}</th>
								<th>{{ __('shongjukti::messages.accepted_extensions') }}</th>
								<th>{{ __('shongjukti::messages.action') }}</th>
							</tr>
						</tfoot>
					</table>

					<div class="panel-body card-body" style="border-top: 1px solid #ccc;">
						<div class="row text-muted">
							<div class="col-sm-6">
								<div class="form-control-static small">
									{{ sprintf( __('shongjukti::messages.showing_x_out_y'), $attachmentTypes->count(), $attachmentTypes->total() ) }}
								</div>
							</div>
							<div class="col-sm-6 text-right">
								@if( $attachmentTypes->total() > $itemsPerPage )
									{{ $attachmentTypes->links() }} {{-- Pagination --}}
								@else
									<div class="form-control-static small">{{ __('shongjukti::messages.page_1') }}</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>


		@else

			<div class="alert alert-info" role="alert">
				{{ __('shongjukti::messages.no_data_in_scope') }}
			</div>

		@endif

	@else

		<div class="alert alert-info" role="alert">
			{{ __('shongjukti::messages.select_a_scope_to_manage') }}
		</div>

	@endif

@endsection
