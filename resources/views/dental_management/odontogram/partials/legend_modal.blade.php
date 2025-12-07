<div class="modal fade" id="odontogram-legend-modal" tabindex="-1" role="dialog" aria-labelledby="odontogramLegendLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="odontogramLegendLabel">{{ __('dental_management.odontogram.legend') }}</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                @if($treatments->count())
                    <div class="row">
                        @foreach($treatments as $treatment)
                            <div class="col-6 col-md-4 col-lg-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="odontogram-legend-swatch mr-3" style="background-color:{{ $treatment->color ?? '#4ecdc4' }};"></span>
                                    <div>
                                        <span class="d-block font-weight-bold">{{ $treatment->name }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">{{ __('global.no_records') }}</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('global.close') }}</button>
            </div>
        </div>
    </div>
</div>
