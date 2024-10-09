<!-- Success Toast -->
@if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3 toast-index toast-rtl">
        <div class="toast fade bg-success show" id="toast-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex justify-content-between alert-success">
                <div class="toast-body text-white" id="success-message">{{ session('success') }}</div>
                <button class="btn-close btn-close-white me-2 m-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="toast-container position-fixed top-0 end-0 p-3 toast-index toast-rtl">
        <div class="toast fade bg-danger show" id="toast-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex justify-content-between alert-danger">
                <div class="toast-body text-white" id="error-message">{{ session('error') }}</div>
                <button class="btn-close btn-close-white me-2 m-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif