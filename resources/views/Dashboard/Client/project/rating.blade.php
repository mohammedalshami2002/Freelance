<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="ratingModalLabel">{{ trans('dashboard.add_rating') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ratingForm" action="{{ route('Client.rating') }}" method="POST">
                @csrf
                <div class="modal-body text-center">
                    <input type="hidden" name="project_id" id="ratingProjectId" value="{{ $offer->project_id }}">
                    <div class="rating-stars mb-4">
                        <i class="bi bi-star-fill star-icon" data-rating="1"></i>
                        <i class="bi bi-star-fill star-icon" data-rating="2"></i>
                        <i class="bi bi-star-fill star-icon" data-rating="3"></i>
                        <i class="bi bi-star-fill star-icon" data-rating="4"></i>
                        <i class="bi bi-star-fill star-icon" data-rating="5"></i>
                    </div>
                    <input type="hidden" name="rating" id="ratingValue" required>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center">
                    <button type="button" class="btn btn-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">{{ trans('dashboard.close') }}</button>
                    <button type="submit"
                        class="btn btn-primary rounded-pill px-4">{{ trans('dashboard.add') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-icon');
        const ratingInput = document.getElementById('ratingValue');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;

                stars.forEach(s => {
                    if (s.getAttribute('data-rating') <= rating) {
                        s.classList.add('rated');
                    } else {
                        s.classList.remove('rated');
                    }
                });
            });
        });

        const ratingModal = document.getElementById('ratingModal');
        ratingModal.addEventListener('hidden.bs.modal', function() {
            ratingInput.value = '';
            stars.forEach(s => s.classList.remove('rated'));
        });
    });
</script>

<style>
    .modal-content {
        background-color: #ffffff;
        /* خلفية بيضاء بسيطة */
    }

    .modal-title {
        color: #202124;
        /* لون داكن مثل Google */
    }

    .star-icon {
        font-size: 2.5rem;
        color: #e0e0e0;
        /* رمادي فاتح افتراضي */
        cursor: pointer;
        transition: color 0.2s ease-in-out, transform 0.2s;
    }

    .star-icon:hover,
    .star-icon.rated {
        color: #4285F4;
        /* أزرق Google للنجوم المحددة */
        transform: scale(1.1);
    }

    .btn-primary {
        background-color: #4285F4;
        /* أزرق Google */
        border: none;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: #357ae8;
    }

    .btn-secondary {
        background-color: #f1f3f4;
        /* رمادي فاتح جدًا */
        border: none;
        color: #5f6368;
        transition: background-color 0.2s;
    }

    .btn-secondary:hover {
        background-color: #e0e0e0;
    }
</style>
