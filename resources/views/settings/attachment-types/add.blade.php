@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_attachment_types', 'active')

{{-- display page title --}}
@section('page_title', __('New Attachment Type'))
@section('body_class', 'attachment-types add-attachment-type')

{{-- display page header --}}
@section('page_header_icon', 'icon-attachment')
@section('page_header', __('New Attachment Type'))

{{-- submit button label --}}
@section('attachment_type_form_submit_btn', __('Add'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Settings'),
        action('AttachmentsController@attachmentTypesIndex') => __('Attachment Types'),
        action('AttachmentsController@attachmentTypesAdd')   => __('Add New')
    ];
@endphp

@section('breadcrumb_right')
    <li>
        <a href="{{ action('AttachmentsController@attachmentTypesIndex') }}">
            <i class="icon-list-unordered mr-5" aria-hidden="true"></i> {{ __('List') }}
        </a>
    </li>
@endsection

@section('scripts')
    <script type="text/javascript">
        // Remember the Scope choice from the last entry.
        // Using JavaScript Cookie.
        document.addEventListener('DOMContentLoaded', function() {
            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires="+d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }

            function getCookie(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for(var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }

            var scopeKeyChoice = document.getElementById('scope-key');

            // Remember the value on choice.
            scopeKeyChoice.onchange = function(event) {
                setCookie('attachment-scope', this.value, 10);
            };

            // Set the value on page load.
            var attachmentScope = getCookie('attachment-scope');
            if (attachmentScope != '') {
                scopeKeyChoice.value = attachmentScope;
            }
        }, false);
    </script>
@endsection

{{-- page content --}}
@section('content')

    <div class="panel panel-sm panel-theme">
        <div class="panel-heading">
            <h6 class="panel-title">
                {{ __('New Attachment Type') }}
            </h6>
        </div>

        <div class="panel-body">
            <form action="{{ route('attachmenttype.store') }}" method="POST">

                @include('settings/attachment-types/form')

            </form>
        </div>
    </div>

@endsection
