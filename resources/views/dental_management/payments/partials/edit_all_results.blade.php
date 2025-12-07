<table class="table table-hover">
  <thead class="bg-light">
    <tr>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.payments.edit_all', array_merge(request()->all(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.payments.id') }}
        </a>
      </th>
      <th>{{ __('dental_management.payments.patient') }}</th>
      <th>{{ __('dental_management.payments.appointment') }}</th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.payments.edit_all', array_merge(request()->all(), ['sort' => 'amount', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.payments.amount') }}
        </a>
      </th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.payments.edit_all', array_merge(request()->all(), ['sort' => 'payment_date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.payments.payment_date') }}
        </a>
      </th>
      <th>{{ __('dental_management.payments.fields.payment_method') }}</th>
      <th>
        <a class="text-dark text-decoration-none" href="{{ route('dental_management.payments.edit_all', array_merge(request()->all(), ['sort' => 'status', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
          {{ __('dental_management.payments.fields.status') }}
        </a>
      </th>
      <th>{{ __('global.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($payments as $payment)
      <tr>
        <td>{{ $payment->id }}</td>
        <td>{{ $payment->patient->name ?? '-' }}</td>
        <td>{{ $payment->appointment->treatment->name ?? '-' }}</td>

        <!-- Editable amount field -->
        <td class="editable-cell"
            contenteditable="true"
            data-id="{{ $payment->id }}"
            data-field="amount"
            data-original="{{ $payment->amount }}">
          {{ $payment->amount_formatted }}
        </td>

        <!-- Editable payment_date field -->
        <td>
          <input type="date" class="editable-date form-control form-control-sm"
                 data-id="{{ $payment->id }}"
                 data-field="payment_date"
                 data-original="{{ $payment->payment_date->format('Y-m-d') }}"
                 value="{{ $payment->payment_date->format('Y-m-d') }}">
        </td>

        <!-- Editable payment_method field -->
        <td>
          <select class="editable-select form-control form-control-sm"
                  data-id="{{ $payment->id }}"
                  data-field="payment_method"
                  data-original="{{ $payment->payment_method }}">
            <option value="cash" {{ $payment->payment_method == 'cash' ? 'selected' : '' }}>{{ __('dental_management.payments.methods.cash') }}</option>
            <option value="card" {{ $payment->payment_method == 'card' ? 'selected' : '' }}>{{ __('dental_management.payments.methods.card') }}</option>
            <option value="transfer" {{ $payment->payment_method == 'transfer' ? 'selected' : '' }}>{{ __('dental_management.payments.methods.transfer') }}</option>
            <option value="check" {{ $payment->payment_method == 'check' ? 'selected' : '' }}>{{ __('dental_management.payments.methods.check') }}</option>
          </select>
        </td>

        <!-- Editable status field -->
        <td>
          <select class="editable-select form-control form-control-sm"
                  data-id="{{ $payment->id }}"
                  data-field="status"
                  data-original="{{ $payment->status }}">
            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>{{ __('dental_management.payments.status.pending') }}</option>
            <option value="completed" {{ $payment->status == 'completed' ? 'selected' : '' }}>{{ __('dental_management.payments.status.completed') }}</option>
            <option value="cancelled" {{ $payment->status == 'cancelled' ? 'selected' : '' }}>{{ __('dental_management.payments.status.cancelled') }}</option>
            <option value="refunded" {{ $payment->status == 'refunded' ? 'selected' : '' }}>{{ __('dental_management.payments.status.refunded') }}</option>
          </select>
        </td>

        <td>
          <div class="btn-group btn-group-sm" role="group">
            <a class="btn btn-light" href="{{ route('dental_management.payments.show', $payment->slug) }}?return_url={{ urlencode(route('dental_management.payments.edit_all') . '?' . request()->getQueryString()) }}" title="{{ __('global.show') }}">
              <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.payments.edit', $payment->slug) }}?return_url={{ urlencode(route('dental_management.payments.edit_all') . '?' . request()->getQueryString()) }}" title="{{ __('global.edit') }}">
              <i class="fas fa-pen"></i>
            </a>
            <a class="btn btn-light" href="{{ route('dental_management.payments.delete', $payment->slug) }}?return_url={{ urlencode(route('dental_management.payments.edit_all') . '?' . request()->getQueryString()) }}" title="{{ __('global.delete') }}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
  {{ $payments->links() }}
</div>