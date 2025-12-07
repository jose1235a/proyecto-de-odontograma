<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="name">{{ __('dental_management.doctors.name') }}</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="last_name">{{ __('dental_management.doctors.last_name') }}</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ request('last_name') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="document">{{ __('dental_management.doctors.document') }}</label>
            <input type="text" class="form-control" id="document" name="document" value="{{ request('document') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="specialty_id">{{ __('dental_management.doctors.specialty') }}</label>
            <select class="form-control" id="specialty_id" name="specialty_id">
                <option value="">{{ __('global.select_option') }}</option>
                @foreach($specialties ?? [] as $specialty)
                    <option value="{{ $specialty->id }}" {{ request('specialty_id') == $specialty->id ? 'selected' : '' }}>
                        {{ $specialty->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>