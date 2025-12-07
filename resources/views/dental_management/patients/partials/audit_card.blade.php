<div class="row mt-4">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> {{ __('global.record_audit') }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @include('dental_management.patients.partials.form_show_audit')
            </div>
        </div>
    </div>
</div>
