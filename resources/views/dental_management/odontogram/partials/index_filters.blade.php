<div class="card card-outline card-primary collapsed-card">
    <div class="card-header">
        <h3 class="card-title">{{ __('global.card_title_filter') }}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('dental_management.odontogram.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="patient_id">{{ __('dental_management.odontogram.patient') }}</label>
                        <select class="form-control" id="patient_id" name="patient_id">
                            <option value="">{{ __('global.all') }}</option>
                            @foreach(($patients ?? collect()) as $patient)
                                <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }} {{ $patient->last_name }} ({{ $patient->document }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="doctor_id">{{ __('dental_management.odontogram.doctor') }}</label>
                        <select class="form-control" id="doctor_id" name="doctor_id">
                            <option value="">{{ __('global.all') }}</option>
                            @foreach(($doctors ?? collect()) as $doctor)
                                <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }} {{ $doctor->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> {{ __('global.search') }}
                            </button>
                            <a href="{{ route('dental_management.odontogram.index') }}" class="btn btn-secondary">
                                <i class="fas fa-eraser"></i> {{ __('global.clear') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
