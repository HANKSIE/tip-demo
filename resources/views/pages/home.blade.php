@extends('layouts.master')
@section('main')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tip-alert-modal">
    打開打賞彈窗
</button>
<div class="modal" id="tip-alert-modal" tabindex="-1">
    <div class="modal-dialog">
        <div id="tip-alert">
            <tip-alert/>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ mix('/js/tip-alert.js') }}"></script>
@endpush
