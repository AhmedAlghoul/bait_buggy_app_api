@extends('admin.parent')

@section('styles')
<style>
    #map {

        height: 400px;
        width: 100%;
    }
</style>
@endsection


@section('content')

<form class="form" style="background-color: white; border: 1px solid #e4e7f0; padding: 20px;" role="form" method="POST"
    enctype="multipart/form-data" action="{{route('product.update',$product->id)}}">
    @csrf
    @method('PUT')
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert" id="error-message">
            <h5>warning!</h5>
            <ul>
                @foreach ($errors->all() as $error)
                <li> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success" role="alert" id="success-message">
            {{ session('success') }}
        </div>

        @endif

        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Title</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="title" class="form-control form-control-solid mb-3 mb-lg-0"
                placeholder="Enter the title" value="{{$product->title}}">
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Price</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" name="price" class="form-control form-control-solid mb-3 mb-lg-0"
                placeholder="Enter the price" value="{{$product->price}}">
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Description</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="description" class="form-control form-control-solid mb-3 mb-lg-0"
                placeholder="Enter the product description" value="{{$product->description}}">
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">choose user</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="form-group row">
                <div class="col-lg-4 col-md-9 col-sm-12">
                    <select class="form-control js-example-basic-single" name="user">
                        <option selected disabled>Select user</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}" @if($product->user_id == $user->id) selected
                            @endif>{{$user->user_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">choose category</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="form-group row">
                <div class="col-lg-4 col-md-9 col-sm-12">
                    <select class="form-control js-example-basic-single" name="category">
                        <option selected disabled>Select Category</option>
                        @foreach ($categories as $category)
                        @if ($category->is_active == 1)
                        <option value="{{$category->id}}" @if($product->category_id == $category->id) selected @endif>
                            {{$category->category_name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Location</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="form-group row">
                <!--The Map -->
                <div id="map" style="width: 100%"></div>
            </div>
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <div class="d-flex flex-column flex-md-row align-items-md-start">
                <div class="d-flex flex-column flex-grow-1 mb-2 me-md-2">
                    <label class="fw-bold fs-6" for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control form-control-solid"
                        value="{{$product->address}}">
                </div>
                <div class="d-flex flex-column flex-grow-1 mb-2">
                    <label class="fw-bold fs-6" for="latitude">Latitude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control form-control-solid"
                        value="{{$product->latitude}}">
                </div>
                <div class="d-flex flex-column flex-grow-1 mb-2 me-md-2">
                    <label class="fw-bold fs-6" for="longitude">Longitude</label>
                    <input type="text" name="longitude" id="longitude" class="form-control form-control-solid"
                        value="{{$product->longitude}}">
                </div>
            </div>
            <!--end::Label-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->
        <div class="text-center pt-15">
            <div class="card-footer">
                <button type="reset" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </div>
        </div>
</form>

@endsection

@section('scripts')
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPHfiiXdYkeqGP-pKXjygARGNhUEUn2oM&callback=initMap&v=weekly"
    defer></script>
<script src="{{asset('adminassets/js/map.js')}}"></script>
<script>
    setTimeout(function() {
        document.getElementById('success-message').style.display = 'none';
    }, 15000);
    setTimeout(function() {
    document.getElementById('error-message').style.display = 'none';
    }, 15000);

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection