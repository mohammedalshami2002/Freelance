<div class="modal fade text-left" id="addWorkLabel" tabindex="-1" aria-labelledby="addWorkLabel" data-bs-backdrop="true" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <div class="modal-header bg-primary text-white border-bottom-0">
                <h4 class="modal-title fw-bold text-white" id="addWorkLabel">
                    {{ trans('dashboard.add') }}
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('MyWork.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ trans('dashboard.name') }}</label>
                        <input type="text" name="name" class="form-control rounded-pill shadow-sm"
                            placeholder="{{ trans('dashboard.name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ trans('dashboard.description') }}</label>
                        <textarea name="description" class="form-control rounded-3 shadow-sm" placeholder="{{ trans('dashboard.description') }}"
                            rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ trans('dashboard.image') }}</label>
                        <input type="file" name="image" class="form-control rounded-pill shadow-sm"
                            accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ trans('dashboard.link') }}</label>
                        <input type="url" name="link" class="form-control rounded-pill shadow-sm"
                            placeholder="https://example.com" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-light rounded-pill shadow-sm" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>{{ trans('dashboard.close') }}
                    </button>
                    <button type="submit" class="btn btn-success rounded-pill shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i>{{ trans('dashboard.create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
