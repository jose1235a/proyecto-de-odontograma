<form id="form-save" method="POST" action="{{ route('dental_management.doctors.update', $doctor) }}">
  @csrf
  @method('PUT')

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="document_type">{{ __('dental_management.doctors.document_type') }} <span class="text-danger">*</span></label>
        @php
          $documentType = strtolower(old('document_type', $doctor->document_type ?? ''));
        @endphp
        <select class="form-control @error('document_type') is-invalid @enderror" id="document_type" name="document_type" required>
          <option value="">{{ __('global.select_option') }}</option>
          <option value="dni" {{ $documentType === 'dni' ? 'selected' : '' }}>DNI</option>
          <option value="passport" {{ $documentType === 'passport' ? 'selected' : '' }}>PASSPORT</option>
          <option value="other" {{ $documentType === 'other' ? 'selected' : '' }}>OTHER</option>
        </select>
        @error('document_type')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="document">{{ __('dental_management.doctors.document') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('document') is-invalid @enderror" id="document" name="document"
               value="{{ old('document', $doctor->document) }}" required maxlength="20">
        @error('document')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="name">{{ __('dental_management.doctors.name') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
               value="{{ old('name', $doctor->name) }}" required maxlength="100">
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="last_name">{{ __('dental_management.doctors.last_name') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name"
               value="{{ old('last_name', $doctor->last_name) }}" required maxlength="100">
        @error('last_name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="email">{{ __('dental_management.doctors.email') }} <span class="text-danger">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
               value="{{ old('email', $doctor->email) }}" required maxlength="100">
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="phone">{{ __('dental_management.doctors.phone') }}</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
               value="{{ old('phone', $doctor->phone) }}" maxlength="20">
        @error('phone')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="specialties">{{ __('dental_management.doctors.specialty') }} <span class="text-danger">*</span></label>
        @php
          $selectedSpecialties = old('specialties', $doctor->specialties->pluck('id')->toArray());
        @endphp
        <select class="form-control select2 @error('specialties') is-invalid @enderror" id="specialties" name="specialties[]" multiple="multiple" required>
          @foreach($specialties ?? [] as $specialty)
            <option value="{{ $specialty->id }}" {{ in_array($specialty->id, $selectedSpecialties) ? 'selected' : '' }}>
              {{ $specialty->name }}
            </option>
          @endforeach
        </select>
        @error('specialties')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="is_active">{{ __('dental_management.doctors.is_active') }}</label>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                 {{ old('is_active', $doctor->is_active) ? 'checked' : '' }}>
          <label class="custom-control-label" for="is_active"></label>
        </div>
        @error('is_active')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="address">{{ __('dental_management.doctors.address') }}</label>
        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                  rows="3" maxlength="255">{{ old('address', $doctor->address) }}</textarea>
        @error('address')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>
</form>