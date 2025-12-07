<form method="GET" action="{{ route('dental_management.consultations.index') }}" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="patient_id">{{ __('dental_management.consultations.fields.patient') }}</label>
                <select name="patient_id" id="patient_id" class="form-control">
                    <option value="">{{ __('global.all') }}</option>
                    @foreach(\App\Models\Patient::all() as $patient)
                        <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }} {{ $patient->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="treatment_id">{{ __('dental_management.consultations.fields.treatment') }}</label>
                <select name="treatment_id" id="treatment_id" class="form-control">
                    <option value="">{{ __('global.all') }}</option>
                    @foreach(\App\Models\Treatment::all() as $treatment)
                        <option value="{{ $treatment->id }}" {{ request('treatment_id') == $treatment->id ? 'selected' : '' }}>
                            {{ $treatment->name }} - S/ {{ number_format($treatment->cost, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="doctor_id">{{ __('dental_management.consultations.fields.doctor') }}</label>
                <select name="doctor_id" id="doctor_id" class="form-control">
                    <option value="">{{ __('global.all') }}</option>
                    @foreach(\App\Models\Doctor::all() as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="consultation_date">{{ __('dental_management.consultations.fields.consultation_date') }}</label>
                <input type="date" name="consultation_date" id="consultation_date" class="form-control"
                       value="{{ request('consultation_date') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> {{ __('global.search') }}
            </button>
            <a href="{{ route('dental_management.consultations.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> {{ __('global.clear') }}
            </a>
        </div>
    </div>
</form>