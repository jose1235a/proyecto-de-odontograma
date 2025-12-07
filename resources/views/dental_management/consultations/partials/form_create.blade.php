<form id="form-save" action="{{ route('dental_management.consultations.store') }}" method="POST">
    @csrf

    @if(isset($patient) && $patient)
        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
        <div class="form-group">
            <label>{{ __('dental_management.consultations.fields.patient') }}</label>
            <input type="text" class="form-control" value="{{ $patient->name }} {{ $patient->last_name }}" readonly>
        </div>
    @else
        <div class="form-group">
            <label for="patient_id">{{ __('dental_management.consultations.fields.patient') }} <span class="text-danger">*</span></label>
            <select name="patient_id" id="patient_id" class="form-control select2" required>
                <option value="">{{ __('global.select_option') }}</option>
                @foreach(\App\Models\Patient::all() as $patientOption)
                    <option value="{{ $patientOption->id }}" {{ old('patient_id') == $patientOption->id ? 'selected' : '' }}>
                        {{ $patientOption->name }} {{ $patientOption->last_name }} - {{ $patientOption->document }}
                    </option>
                @endforeach
            </select>
            @error('patient_id')
                <p class="text-danger mb-0">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="treatment_id">{{ __('dental_management.consultations.fields.treatment') }} <span class="text-danger">*</span></label>
                <select name="treatment_id" id="treatment_id" class="form-control select2" required>
                    <option value="">{{ __('global.select_option') }}</option>
                    @foreach($treatments ?? [] as $treatment)
                        <option value="{{ $treatment->id }}" {{ old('treatment_id') == $treatment->id ? 'selected' : '' }}>
                            {{ $treatment->name }}
                        </option>
                    @endforeach
                </select>
                @error('treatment_id')
                    <p class="text-danger mb-0">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="consultation_date">{{ __('dental_management.consultations.fields.consultation_date') }} <span class="text-danger">*</span></label>
                <input type="date" name="consultation_date" id="consultation_date" class="form-control"
                       value="{{ old('consultation_date', date('Y-m-d')) }}" required>
                @error('consultation_date')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="consultation_time">{{ __('dental_management.consultations.fields.consultation_time') }} <span class="text-danger">*</span></label>
                <input type="time" name="consultation_time" id="consultation_time" class="form-control"
                       value="{{ old('consultation_time', date('H:i')) }}" required>
                @error('consultation_time')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="fever">{{ __('dental_management.consultations.fields.fever') }}</label>
                <div class="input-group">
                    <input type="number" name="fever" id="fever" class="form-control"
                           value="{{ old('fever') }}" step="0.1" min="30" max="45">
                    <div class="input-group-append">
                        <span class="input-group-text">°C</span>
                    </div>
                </div>
                @error('fever')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="blood_pressure">{{ __('dental_management.consultations.fields.blood_pressure') }}</label>
                <input type="text" name="blood_pressure" id="blood_pressure" class="form-control"
                       value="{{ old('blood_pressure') }}" placeholder="120/80">
                @error('blood_pressure')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="doctor_id">{{ __('dental_management.consultations.fields.doctor') }} <span class="text-danger">*</span></label>
                <select name="doctor_id" id="doctor_id" class="form-control select2" required>
                    <option value="">{{ __('global.select_option') }}</option>
                    @foreach($doctors ?? [] as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }} {{ $doctor->last_name ?? '' }}
                        </option>
                    @endforeach
                </select>
                @error('doctor_id')
                    <p class="text-danger mb-0">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="description">{{ __('dental_management.consultations.fields.description') }} <span class="text-danger">*</span></label>
                <textarea name="description" id="description" class="form-control"
                          rows="2" maxlength="1000" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</form>