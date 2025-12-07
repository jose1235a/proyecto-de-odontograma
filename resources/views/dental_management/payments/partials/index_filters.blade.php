<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="payment_date">{{ __('dental_management.payments.payment_date') }}</label>
            <input type="date" class="form-control" id="payment_date" name="payment_date"
                   value="{{ request('payment_date') }}">
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="status">{{ __('dental_management.payments.fields.status') }}</label>
            <select class="form-control" id="status" name="status">
                <option value="">{{ __('global.all') }}</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                    {{ __('dental_management.payments.status.pending') }}
                </option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                    {{ __('dental_management.payments.status.completed') }}
                </option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                    {{ __('dental_management.payments.status.cancelled') }}
                </option>
                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>
                    {{ __('dental_management.payments.status.refunded') }}
                </option>
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="payment_method">{{ __('dental_management.payments.fields.payment_method') }}</label>
            <select class="form-control" id="payment_method" name="payment_method">
                <option value="">{{ __('global.all') }}</option>
                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>
                    {{ __('dental_management.payments.methods.cash') }}
                </option>
                <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>
                    {{ __('dental_management.payments.methods.card') }}
                </option>
                <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>
                    {{ __('dental_management.payments.methods.transfer') }}
                </option>
                <option value="check" {{ request('payment_method') == 'check' ? 'selected' : '' }}>
                    {{ __('dental_management.payments.methods.check') }}
                </option>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="patient_id">{{ __('dental_management.payments.patient') }}</label>
            <select class="form-control select2" id="patient_id" name="patient_id">
                <option value="">{{ __('global.all') }}</option>
                @foreach(\App\Models\Patient::active()->orderBy('name')->get() as $patient)
                    <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }} {{ $patient->last_name }} - {{ $patient->document }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="amount_min">{{ __('dental_management.payments.amount') }} Min/Max</label>
            <div class="input-group">
                <input type="number" class="form-control" id="amount_min" name="amount_min"
                       placeholder="Min" value="{{ request('amount_min') }}" step="0.01">
                <input type="number" class="form-control" id="amount_max" name="amount_max"
                       placeholder="Max" value="{{ request('amount_max') }}" step="0.01">
            </div>
        </div>
    </div>
</div>