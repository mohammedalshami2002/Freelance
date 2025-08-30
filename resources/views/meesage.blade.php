@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show rounded" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i> <strong>{{trans('meesage.An_error_occurred')}}</strong>
    <p>{{trans('meesage.Please_check_the_entered_information')}}</p>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
    @if (session()->has('add'))
        <div class="alert alert-success alert-dismissible fade show rounded" role="alert">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>
            <strong>{{ trans('meesage.Added_successfully') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->has('update'))
        <div class="alert alert-success alert-dismissible fade show rounded" role="alert">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>
            <strong>{{ trans('meesage.Updated_successfully') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->has('delete'))
        <div class="alert alert-success alert-dismissible fade show rounded" role="alert">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>
            <strong>{{ trans('meesage.Deleted_successfully') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->has('enable'))
        <div class="alert alert-success alert-dismissible fade show rounded" role="alert">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>
            <strong>{{ trans('meesage.A_request_has_been_approved') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->has('withdrawal'))
        <div class="alert alert-success alert-dismissible fade show rounded" role="alert">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>
            <strong>{{ trans('meesage.A_request_has_been_approved') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
