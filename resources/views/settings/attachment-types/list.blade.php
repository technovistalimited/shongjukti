@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings_attachment_types', 'active')

{{-- display page title --}}
@section('page_title',  __('Attachment Types'))
@section('body_class', 'attachment-types list-attachment-type')

{{-- display page header --}}
@section('page_header_icon', 'icon-attachment')
@section('page_header', __('Attachment Types'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Settings'),
        action('AttachmentController@attachmentTypesIndex') => __('Attachment Types')
    ];

    if( ! empty($scopeKey) ) :
        $breadcrumbs[action('AttachmentController@attachmentTypesIndex', array('scope_key' => $scopeKey))] = $attachmentScopes[$scopeKey];
    endif;
@endphp

@section('breadcrumb_right')
    <li>
        <a href="{{ action('AttachmentController@attachmentTypesAdd') }}">
            <i class="icon-add-to-list mr-5" aria-hidden="true"></i> {{ __('Add New') }}
        </a>
    </li>
@endsection

@section('scripts')

    <script type="text/javascript">
        // Load UI based on Scope.
        // Load Respective Attachments based on Scope Key selection.
        document.addEventListener('DOMContentLoaded', function() {
            function loadScopeData(scope_select) {
                var parameter = scope_select.value;
                var baseUrl   = window.location.href;
                // hard-coded string to indicate from where it can append the slug string.
                var withoutLastChunk = baseUrl.slice(0, baseUrl.lastIndexOf('attachment-types'));
                window.location.href = withoutLastChunk + 'attachment-types/' + parameter;
            }

            document.getElementById('scope-key').onchange = function(event) {
                loadScopeData(this);
            };
        }, false);
    </script>

@endsection

{{-- page content --}}
@section('content')

    <div class="panel">
        <div class="panel-body">
            <select id="scope-key" class="form-control">
                <option value="">{{ __('Select a Scope') }}</option>
                @foreach( $attachmentScopes as $scopeId => $label )
                    <option value="{{ $scopeId }}" {{ trim($scopeKey) === $scopeId ? 'selected="selected"' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if( Session::has('success') )
        <div class="alert alert-success alert-styled-left alert-arrow-left mb-20" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ Session::get('success') }}
        </div>
        @php Session::forget('success'); @endphp
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-20">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if( ! empty($scopeKey) )

        <h6 class="text-uppercase text-bold">{{ sprintf( __('Scope: %s'), $attachmentScopes[$scopeKey] ) }}</h6>

        @if( ! $attachmentTypes->isEmpty() )

            <div class="panel">
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Order') }}</th>
                                <th>{{ __('Custom Label?') }}</th>
                                <th>{{ __('Accepted Extensions') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach( $attachmentTypes as $attachmentType )
                            <tr class="{{ $attachmentType->is_active ? '' : 'text-muted' }}">
                                <td>
                                    <a class="{{ $attachmentType->is_active ? '' : 'text-muted' }}" href="{{ action('AttachmentController@attachmentTypesEdit', ['type_id' => $attachmentType->id]) }}">
                                        <strong>{{ $attachmentType->name }}</strong>
                                    </a>
                                    @if( ! $attachmentType->is_required )
                                        <div class="label label-default">{{ __('Optional') }}</div>
                                    @endif
                                </td>

                                <td>
                                    {{ empty($attachmentType->weight) ? '-' : translateString($attachmentType->weight) }}
                                </td>

                                <td>
                                    @if( ! empty($attachmentType->is_label_accepted) )
                                        <?php $_icon_class = $attachmentType->is_active ? 'text-success' : 'text-muted'; ?>
                                        <i class="icon-checkmark-circle {{ $_icon_class }}" aria-hidden="true"></i> {{ __('Yes') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    {{ empty($attachmentType->accepted_extensions) ? '-' : str_limit($attachmentType->accepted_extensions, 50, '...') }}
                                </td>

                                <td>
                                    <form action="{{ route('attachmenttype.delete', $attachmentType->id) }}" method="POST">
                                        <div class="btn-group">
                                            <a href="{{ action('AttachmentController@attachmentTypesEdit', ['type_id' => $attachmentType->id]) }}" class="btn btn-primary btn-xs">{{ __('Edit') }}</a>

                                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs">{{ __('Delete') }}</button>
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
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Order') }}</th>
                                <th>{{ __('Custom Label?') }}</th>
                                <th>{{ __('Accepted Extensions') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="panel-body" style="border-top: 1px solid #ccc;">
                        <div class="row text-muted">
                            <div class="col-sm-6">
                                <div class="form-control-static small">
                                    {{ sprintf( __('Showing %s out of %s'), $attachmentTypes->count(), $attachmentTypes->total() ) }}
                                </div>
                            </div>
                            <div class="col-sm-6 text-right">
                                @if( $attachmentTypes->total() > $itemsPerPage )
                                    {{ $attachmentTypes->links() }} {{-- Pagination --}}
                                @else
                                    <div class="form-control-static small">{{ __('Page 1') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        @else

            <div class="alert alert-info" role="alert">
                {{ __('No data available in this scope') }}
            </div>

        @endif

    @else

        <div class="alert alert-info" role="alert">
            {{ __('Please select a Scope to manage its attachments') }}
        </div>

    @endif

@endsection
