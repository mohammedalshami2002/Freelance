<!-- نموذج حل النزاع المحسّن -->
<div class="modal fade text-left" id="backdrop" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="true"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <!-- رأس النموذج -->
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title fs-4 fw-bold text-dark" id="myModalLabel4">
                    {{ trans('dashboard.resolve_dispute') }}
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- النموذج -->
            <form method="POST" action="{{ route('admin.disputes.resolve', $dispute->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- حقل اختيار نتيجة النزاع -->
                    <div class="form-group mb-4">
                        <select name="resolution_type" id="resolution_type" class="form-select form-select-lg" required>
                            <option selected disabled>{{ trans('dashboard.resolution_result') }}</option>
                            <option value="refund">{{ trans('dashboard.refund_client') }}</option>
                            <option value="pay_service_provider">{{ trans('dashboard.pay_service_provider') }}</option>
                        </select>
                    </div>

                    <!-- حقل المبلغ الجزئي (مخفي مبدئياً) -->
                    <div class="form-group mb-4" id="partial_amount_container" style="display: none;">
                        <input type="number" name="partial_amount" id="partial_amount"
                            class="form-control form-control-lg rounded-pill border-0 shadow-sm"
                            placeholder="{{ trans('dashboard.partial_amount') }}" step="0.01" min="0">
                    </div>

                    <!-- حقل رسالة توضيحية -->
                    <div class="form-group mb-4">
                        <textarea rows="3" name="message" class="form-control form-control-lg"
                            placeholder="{{ trans('dashboard.write_your_message_here') }}" required></textarea>
                    </div>

                    <!-- حقل تحميل ملف -->
                    <div class="form-group mb-4">
                        <input type="file" name="attachment" class="form-control form-control-lg">
                    </div>
                </div>

                <!-- ذيل النموذج -->
                <div class="modal-footer border-top-0 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary ms-1 w-100 w-md-25 rounded-pill shadow-sm">
                        <i class="fas fa-check-circle"></i> @lang('dashboard.resolve_dispute')
                    </button>
                    <button type="button" class="btn btn-light w-100 w-md-25 rounded-pill shadow-sm"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x me-2"></i>
                        <span>{{ trans('dashboard.close') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resolutionTypeSelect = document.getElementById('resolution_type');
        const partialAmountContainer = document.getElementById('partial_amount_container');
        const partialAmountInput = document.getElementById('partial_amount');

        resolutionTypeSelect.addEventListener('change', function() {
            if (this.value === 'partial_refund') {
                partialAmountContainer.style.display = 'block';
                partialAmountInput.setAttribute('required', 'required');
            } else {
                partialAmountContainer.style.display = 'none';
                partialAmountInput.removeAttribute('required');
            }
        });
    });
</script>
