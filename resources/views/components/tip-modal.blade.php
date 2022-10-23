@props(['storeId' => null, 'employeeId' => null])
<div class="modal" id="tip-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="tip-form">
                <tip-form
                :store-id='@json($storeId)'
                :employee-id='@json($employeeId)'
                />
            </div>
        </div>
    </div>
</div>
