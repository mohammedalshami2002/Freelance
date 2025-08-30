<style>
    .modal-content.custom-modal {
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
    }

    .modal-header.custom-header {
        border-bottom: none;
        position: relative;
    }

    .modal-header.custom-header .btn-close {
        position: absolute;
        top: 1rem;
        right: 1.5rem;
    }

    .delete-icon-container {
        background-color: #ffcccc;
        border-radius: 50%;
        padding: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .delete-icon-container .bi-trash {
        font-size: 2.5rem;
        color: #dc3545;
    }

    .modal-body.custom-body h4 {
        font-weight: 600;
        color: #333;
    }

    .modal-body.custom-body p {
        color: #6c757d;
    }
</style>

<div class="modal fade text-left" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-body text-center custom-body">
                <div class="delete-icon-container">
                    <i class="bi bi-trash"></i>
                </div>
                <h4 class="mb-2">{{ trans('dashboard.delete') }}</h4>
                <p class="mb-4">{{ trans('dashboard.are_you_sure') }}</p>

                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger rounded-pill">
                            {{ trans('dashboard.delete') }}
                        </button>
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">
                            {{ trans('dashboard.close') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
