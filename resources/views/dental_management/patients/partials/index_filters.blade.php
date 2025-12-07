<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="document">{{ __('dental_management.patients.document') }}</label>
            <input type="text" class="form-control" id="document" name="document"
                   value="{{ request('document') }}" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.document')]) }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="name">{{ __('dental_management.patients.name') }}</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ request('name') }}" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.name')]) }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="is_active">{{ __('dental_management.patients.is_active') }}</label>
            <select class="form-control" id="is_active" name="is_active">
                <option value="">{{ __('global.all') }}</option>
                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>{{ __('global.active') }}</option>
                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
            </select>
        </div>
    </div>
</div>