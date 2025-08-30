<div class="modal fade text-left" id="editWorkModal{{ $work->id }}" tabindex="-1"
    aria-labelledby="editWorkModalLabel{{ $work->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <div class="modal-header bg-warning text-dark border-bottom-0">
                <h4 class="modal-title fw-bold" id="editWorkModalLabel{{ $work->id }}">
                    {{ trans('dashboard.update') }}
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('MyWork.update', $work->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4" style="max-height: 60vh; overflow-y: auto;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ trans('dashboard.name') }}</label>
                        <input type="text" name="name" value="{{ $work->name }}"
                            class="form-control rounded-pill shadow-sm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ trans('dashboard.description') }}</label>
                        <textarea name="description" class="form-control rounded-3 shadow-sm" rows="4" required>{{ $work->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ trans('dashboard.image') }}</label>
                        <input type="file" name="image" class="form-control rounded-pill shadow-sm"
                            accept="image/*">
                        @if ($work->image)
                            <img src="{{ asset('assets/image/myworks/' . $work->image) }}" class="img-fluid rounded mt-2"
                                width="120" alt="{{ $work->name }}">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ trans('dashboard.link') }}</label>
                        <input type="url" name="link" value="{{ $work->link }}"
                            class="form-control rounded-pill shadow-sm" placeholder="https://example.com">
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-light rounded-pill shadow-sm" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>{{ trans('dashboard.close') }}
                    </button>
                    <button type="submit" class="btn bg-warning text-dark  rounded-pill shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i>{{ trans('dashboard.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
