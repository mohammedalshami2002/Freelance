<div class="modal fade text-left" id="editBackdrop{{$servicer->id}}" tabindex="-1" aria-labelledby="editModalLabel" data-bs-backdrop="true" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title fs-4" id="editModalLabel" style="font-weight: bold; color: #333;">{{ trans('dashboard.update') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{route('service.update', $servicer->id)}}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="name" class="form-control form-control-lg rounded-pill border-0 shadow-sm" value="{{$servicer->name}}" required>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="description" class="form-control form-control-lg rounded-pill border-0 shadow-sm" value="{{$servicer->description}}" required>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="number" name="price" class="form-control form-control-lg rounded-pill border-0 shadow-sm" value="{{$servicer->price}}" required>
                        </div>
                        <select class="form-select" name="categorie_id">
                            <option disabled>{{ trans('dashboard.categories') }}</option>
                            @foreach ($Categories as $Categorie)
                            @if ($Categorie->id == $servicer->categorie_id)
                            <option selected value="{{$Categorie->id}}">{{ $Categorie->name }}</option>
                            @else
                            <option value="{{$Categorie->id}}">{{ $Categorie->name }}</option>
                            @endif
                            @endforeach
                        </select>
                        <select class="form-select mt-2" name="status">
                            <option disabled>{{ trans('dashboard.status') }}</option>
                            <option {{ $servicer->status == true? 'selected':'' }} value="1">{{ trans('dashboard.active') }}</option>
                            <option {{ $servicer->status == false? 'selected': '' }} value="0">{{ trans('dashboard.Inactive') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-between">
                    <!-- زر الإغلاق -->
                    <button type="button" class="btn btn-light w-100 w-md-25 rounded-pill shadow-sm" data-bs-dismiss="modal">
                        <i class="bx bx-x me-2"></i>
                        <span>{{trans('dashboard.close')}}</span>
                    </button>
                    <!-- زر التفعيل -->
                    <button type="submit" formmethod="post" class="btn btn-success ms-1 w-100 w-md-25 rounded-pill shadow-sm">
                        <i class="bx bx-trash me-2"></i>
                        <span>{{trans('dashboard.update')}}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
