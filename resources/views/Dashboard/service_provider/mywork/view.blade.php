<div class="modal fade" id="showBackdrop{{ $work->id }}" tabindex="-1"
    aria-labelledby="showBackdropLabel{{ $work->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold text-white" id="showBackdropLabel{{ $work->id }}">
                    {{ $work->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <img src="{{ asset('assets/image/myworks/' . $work->image) }}" class="img-fluid rounded shadow-sm"
                        alt="{{ $work->name }}">
                </div>
                <p class="fs-6 text-secondary">{{ $work->description }}</p>
                <ul class="list-unstyled mt-3">
                    <li class="mb-2">
                        <i class="bi bi-calendar3 text-primary me-2"></i>
                        <strong>{{ trans('dashboard.created_at') }}:</strong>
                        {{ $work->created_at->format('Y-m-d H:i') }}
                    </li>
                    @if ($work->link)
                        <li>
                            <i class="bi bi-link-45deg text-primary me-2"></i>
                            <strong>{{ trans('dashboard.visit_link') }}:</strong>
                            <a href="{{ $work->link }}" target="_blank" class="text-decoration-none text-info">
                                {{ $work->link }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> {{ trans('dashboard.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
