@include('dental_management.odontogram.partials.odontogram_table', [
    'odontograms' => $odontograms,
    'showPatientColumn' => true,
    'enableDataTable' => true,
])

@if($odontograms->hasPages())
    <div class="d-flex justify-content-center">
        {{ $odontograms->appends(request()->query())->links() }}
    </div>
@endif
