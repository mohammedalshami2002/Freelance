<div class="modal fade text-left" id="backdrop" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="true" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title fs-4" id="myModalLabel4" style="font-weight: bold; color: #333;">{{ trans('dashboard.add') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{route('skill.store')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" name="name" class="form-control form-control-lg rounded-pill border-0 shadow-sm" placeholder="{{trans('dashboard.name')}}" required>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <select class="form-select" id="basicSelect" name="categorie_id">
                            <option selected disabled>{{ trans('dashboard.categories') }}</option>
                            @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-between">
                    <!-- زر الإغلاق -->
                    <button type="button" class="btn btn-light w-100 w-md-25 rounded-pill shadow-sm" data-bs-dismiss="modal">
                        <i class="bx bx-x me-2"></i>
                        <span>{{trans('dashboard.close')}}</span>
                    </button>
                    <button type="submit" formmethod="post" class="btn btn-success ms-1 w-100 w-md-25 rounded-pill shadow-sm">
                        <i class="bx bx-trash me-2"></i>
                        <span>{{trans('dashboard.create')}}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
