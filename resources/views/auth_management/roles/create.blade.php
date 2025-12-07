@extends('layouts.app')

@section('title', __('roles.create_title'))
@section('title_navbar', __('roles.title'))

@section('content')
<form action="{{ route('auth_management.roles.store') }}" method="POST" id="form-save">
    @csrf
    @include('auth_management.roles.form')
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.select-all-checkbox').forEach(function (selectAll) {
            selectAll.addEventListener('change', function () {
                let module = this.dataset.module;
                let isChecked = this.checked;
                document.querySelectorAll('.permission-checkbox-' + module).forEach(function (checkbox) {
                    checkbox.checked = isChecked;
                });
            });
        });
    });
</script>
@endpush
