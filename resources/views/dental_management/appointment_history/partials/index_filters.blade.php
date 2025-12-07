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
        <form method="GET" action="{{ route('dental_management.appointment_history.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="appointment_id">{{ __('dental_management.appointment_history.appointment') }}</label>
                        <input type="text" class="form-control" id="appointment_id" name="appointment_id"
                               value="{{ request('appointment_id') }}" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.appointment_history.appointment_id')]) }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="action">{{ __('dental_management.appointment_history.action') }}</label>
                        <select class="form-control" id="action" name="action">
                            <option value="">{{ __('global.all') }}</option>
                            <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>
                                {{ __('dental_management.appointment_history.action_created') }}
                            </option>
                            <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>
                                {{ __('dental_management.appointment_history.action_updated') }}
                            </option>
                            <option value="status_changed" {{ request('action') == 'status_changed' ? 'selected' : '' }}>
                                {{ __('dental_management.appointment_history.action_status_changed') }}
                            </option>
                            <option value="cancelled" {{ request('action') == 'cancelled' ? 'selected' : '' }}>
                                {{ __('dental_management.appointment_history.action_cancelled') }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="changed_by">{{ __('dental_management.appointment_history.changed_by') }}</label>
                        <select class="form-control" id="changed_by" name="changed_by">
                            <option value="">{{ __('global.all') }}</option>
                            <!-- User options would be populated here -->
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> {{ __('global.search') }}
                            </button>
                            <a href="{{ route('dental_management.appointment_history.index') }}" class="btn btn-secondary">
                                <i class="fas fa-eraser"></i> {{ __('global.clear') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>