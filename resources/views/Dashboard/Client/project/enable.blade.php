<div class="modal fade" id="confirmEnableModal" tabindex="-1" aria-labelledby="confirmEnableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmEnableModalLabel">{{ trans('dashboard.enable') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="enableForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <p>{{ trans('dashboard.are_you_sure') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('dashboard.close') }}</button>
                    <button type="submit" class="btn btn-success">{{ trans('dashboard.enable') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>