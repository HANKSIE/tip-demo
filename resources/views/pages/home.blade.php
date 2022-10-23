@extends('layouts.master')
@section('main')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tip-modal">
    打開打賞彈窗
</button>
<x-tip-modal :storeId="1" :employeeId="2"></x-tip-modal>
@endsection
@push('scripts')
<script src="{{ mix('/js/tip-form.js') }}"></script>
@endpush
