<div class="modal fade" id="advanced-options-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-cogs"></i> {{ __('dental_management.odontogram.advanced_options_title') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($treatments as $treatment)
                        <div class="col-12 col-md-4 col-xl-3 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6>{{ $treatment->name }}</h6>
                                    <div class="form-group mb-0">
                                        <input
                                            type="color"
                                            class="treatment-color-picker"
                                            data-treatment-id="{{ $treatment->id }}"
                                            value="{{ $treatment->color ?? '#4ecdc4' }}"
                                            style="width: 42px; height: 42px; padding: 0; border: none; background: transparent; cursor: pointer;"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('global.close') }}</button>
                <button type="button" class="btn btn-primary" onclick="saveTreatmentColors()">{{ __('global.save_changes') }}</button>
            </div>
        </div>
    </div>
</div>
