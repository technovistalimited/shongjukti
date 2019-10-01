@if( Session::has('success') )
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    <?php Session::forget('success'); ?>
@endif

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="clearfix">
    <div class="form-group {{ $errors->has('scope_key') ? ' has-error' : '' }}">
        <label for="scope-key" class="show d-block">
            <span class="text-bold">{{ __('shongjukti::messages.scope') }}</span>
            <span class="pull-right small text-danger">({{ __('shongjukti::messages.required') }})</span>
        </label>

        <?php
        if (old('scope_key')) {
            $_scope_key = old('scope_key');
        } elseif (isset($attachmentType)) {
            $_scope_key = $attachmentType->scope_key;
        } else {
            $_scope_key = '';
        }
        ?>
        <select name="scope_key" id="scope-key" class="form-control" required>
            <option value="">{{ __('shongjukti::messages.select_a_scope') }}</option>
            @foreach($attachmentScopes as $key => $value)
                <option value="{{$key}}" {{ $key == $_scope_key ? 'selected="selected"' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>

        @if ($errors->has('scope_key'))
            <span class="text-danger small">
                {{ $errors->first('scope_key') }}
            </span>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="show d-block">
                <span class="text-bold">{{ __('shongjukti::messages.name_in_english') }}</span>
                <span class="pull-right small text-danger">({{ __('shongjukti::messages.required') }})</span>
            </label>

            <?php
            if (old('name')) {
                $_name = old('name');
            } elseif (isset($attachmentType)) {
                $_name = $attachmentType->name;
            } else {
                $_name = '';
            }
            ?>
            <input id="name" type="text" class="form-control" name="name" value="{{$_name}}" required autocomplete="off">

            @if ($errors->has('name'))
                <span class="text-danger small">
                    {{ $errors->first('name') }}
                </span>
            @endif
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="name-bn" class="show d-block">
                <span class="text-bold">{{ __('shongjukti::messages.name_in_bengali') }}</span>
            </label>

            <?php
            if (old('name_bn')) {
                $_name_bn = old('name_bn');
            } elseif (isset($attachmentType)) {
                $_name_bn = $attachmentType->name_bn;
            } else {
                $_name_bn = '';
            }
            ?>
            <input id="name-bn" type="text" class="form-control" name="name_bn" value="{{$_name_bn}}" autocomplete="off">
        </div>
    </div>
</div>

<div class="clearfix">
    <div class="form-group">
        <label for="accepted-extensions" class="show d-block text-bold">
            {{ __('shongjukti::messages.accepted_file_extensions') }}
        </label>

        <?php
        if (old('accepted_extensions')) {
            $_accepted_extensions = old('accepted_extensions');
        } elseif (isset($attachmentType)) {
            $_accepted_extensions = $attachmentType->accepted_extensions;
        } else {
            $_accepted_extensions = '';
        }
        ?>
        <textarea id="accepted-extensions" class="form-control" name="accepted_extensions" rows="2" placeholder="eg. jpg, png, pdf, gif">{{$_accepted_extensions}}</textarea>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="weight" class="show d-block text-bold">
                {{ __('shongjukti::messages.order') }}
            </label>

            <?php
            if(old('weight')) :
                $_weight = old('weight');
            elseif(isset($attachmentType)):
                $_weight = $attachmentType->weight;
            else :
                $_weight = 0; // default: 0
            endif;
            ?>
            <input id="weight" type="number" class="form-control" name="weight" value="{{$_weight}}" autocomplete="off" min="0">
        </div>
    </div>

    <div class="col-sm-3">
        <?php
        if( old('is_required') ) {
            $_is_required = old('is_required');
        } else if( isset($attachmentType) ) {
            $_is_required = $attachmentType->is_required;
        } else {
            $_is_required = 0; // default: optional
        }
        ?>
        <div class="form-group {{ $errors->has('is_required') ? ' has-error' : '' }}">
            <label for="is-required-true" class="show d-block">
                <span class="text-bold">{{ __('shongjukti::messages.is_required') }}</span>
                <span class="small text-danger">({{ __('shongjukti::messages.required') }})</span>
            </label>

            <label class="radio-inline">
                <input type="radio" name="is_required" class="is-required" value="1" id="is-required-true" {{ $_is_required == '1' ? 'checked="checked"' : '' }}> {{ __('shongjukti::messages.yes') }}
            </label>

            <label class="radio-inline">
                <input type="radio" name="is_required" class="is-required" value="0" id="is-required-false" {{ $_is_required == '0' ? 'checked="checked"' : '' }}> {{ __('shongjukti::messages.no') }}
            </label>

            @if ($errors->has('is_required'))
                <span class="text-danger small">
                    {{ $errors->first('is_required') }}
                </span>
            @endif
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label for="is_label_accepted" class="show d-block text-bold">
                <span class="">{{ __('shongjukti::messages.is_custom_label') }}</span>
            </label>

            <label class="checkbox-inline">
                <?php
                if (old('is_label_accepted')) {
                    $_is_label_accepted = old('is_label_accepted');
                } elseif (isset($attachmentType)) {
                    $_is_label_accepted = $attachmentType->is_label_accepted;
                } else {
                    $_is_label_accepted = '';
                }
                ?>
                <input type="checkbox" name="is_label_accepted" value="1" {{ $_is_label_accepted == 1 ? 'checked="checked"' : '' }}> {{ __('shongjukti::messages.yes') }}
            </label>
        </div>
    </div>

    <div class="col-sm-3">
        <?php
        if( old('is_active') ) {
            $_is_active = old('is_active');
        } elseif( isset($attachmentType) ) {
            $_is_active = $attachmentType->is_active;
        } else {
            $_is_active = 1; // default: active
        }
        ?>
        <div class="form-group {{ $errors->has('is_active') ? ' has-error' : '' }}">
            <label for="is_active" class="show d-block">
                <span class="text-bold">{{ __('shongjukti::messages.status') }}</span>
                <span class="small text-danger">({{ __('shongjukti::messages.required') }})</span>
            </label>

            <label class="radio-inline">
                <input type="radio" name="is_active" id="active" value="1" {{ $_is_active == '1' ? 'checked="checked"' : '' }}> {{ __('shongjukti::messages.active') }}
            </label>

            <label class="radio-inline">
                <input type="radio" name="is_active" id="active" value="0" {{ $_is_active == '0' ? 'checked="checked"' : '' }}> {{ __('shongjukti::messages.inactive') }}
            </label>

            @if ($errors->has('is_active'))
                <span class="text-danger small">
                    {{ $errors->first('is_active') }}
                </span>
            @endif
        </div>
    </div>
</div>

@csrf

<div class="text-right">
    <button type="submit" class="btn btn-primary">
        @yield('attachment_type_form_submit_btn', __('shongjukti::messages.save'))
    </button>
</div>
