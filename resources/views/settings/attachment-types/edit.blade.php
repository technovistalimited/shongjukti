@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_attachment_types', 'active')

{{-- display page title --}}
@section('page_title', __('Edit Attachment Type'))
@section('body_class', 'attachment-types edit-attachment-type')

{{-- display page header --}}
@section('page_header_icon', 'icon-attachment')
@section('page_header', __('Edit Attachment Type'))

{{-- submit button label --}}
@section('attachment_type_form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Settings'),
        action('AttachmentsController@attachmentTypesIndex') => __('Attachment Types'),
        action('AttachmentsController@attachmentTypesEdit')   => __('Edit')
    ];
@endphp

@section('breadcrumb_right')
    <li>
        <a href="{{ action('AttachmentsController@attachmentTypesIndex') }}">
            <i class="icon-list-unordered mr-5" aria-hidden="true"></i> {{ __('List') }}
        </a>
    </li>

    <li>
        <a href="{{ action('AttachmentsController@attachmentTypesAdd') }}">
            <i class="icon-add-to-list mr-5" aria-hidden="true"></i> {{ __('Add New') }}
        </a>
    </li>
@endsection

{{-- page content --}}
@section('content')

    <div class="panel panel-sm panel-theme">
        <div class="panel-heading">
            <h6 class="panel-title">
                {{ __('Edit Attachment Type') }}
            </h6>
        </div>

        <div class="panel-body">
            <form action="{{ route('attachmenttype.update') }}" method="POST">

                @include('settings/attachment-types/form')

                <input type="hidden" name="id" value="{{ $attachmentType->id }}">

                @method('PUT')

            </form>
        </div>
    </div>

@endsection
