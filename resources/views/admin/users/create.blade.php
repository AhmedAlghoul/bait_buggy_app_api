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
    enctype="multipart/form-data" action="{{route('user.store')}}">
    @csrf
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
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="d-block fw-bold fs-6 mb-5">Profile Photo</label>
            <!--end::Label-->
            <!--begin::Image input-->
            <div class="image-input image-input-outline" data-kt-image-input="true"
                style="background-image: url('assets/media/svg/avatars/blank.svg')">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-125px h-125px"
                    style="background-image: url({{asset('adminassets/media/avatars/300-6.jpg')}});">
                </div>
                <!--end::Preview existing avatar-->
                <!--begin::Label-->
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
                    data-bs-original-title="Change photo">
                    <i class="bi bi-pencil-fill fs-7"></i>
                    <!--begin::Inputs-->
                    <input type="file" name="photo_url">
                    <input type="hidden" name="photo_remove">
                    <!--end::Inputs-->
                </label>
                <!--end::Label-->
                <!--begin::Cancel-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title=""
                    data-bs-original-title="Cancel photo">
                    <i class="bi bi-x fs-2"></i>
                </span>
                <!--end::Cancel-->
                <!--begin::Remove-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title=""
                    data-bs-original-title="Remove photo">
                    <i class="bi bi-x fs-2"></i>
                </span>
                <!--end::Remove-->
            </div>
            <!--end::Image input-->
            <!--begin::Hint-->
            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
            <!--end::Hint-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">User Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="user_name" class="form-control form-control-solid mb-3 mb-lg-0"
                placeholder="Enter User Name">
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Email</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="email" name="user_email" class="form-control form-control-solid mb-3 mb-lg-0"
                placeholder="example@domain.com">
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Phone Number</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" name="phone_number" class="form-control form-control-solid mb-3 mb-lg-0"
                placeholder="+970xxxxxxxxx">
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">User Type</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="form-group row">
                <div class="col-lg-4 col-md-9 col-sm-12">
                    <select class="form-control selectpicker" name="user_type">
                        <option selected disabled>Select user type</option>
                        <option value="shop_owner">shop_owner</option>
                        <option value="user">user</option>
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
            <label class="required fw-bold fs-6 mb-2">Password</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="password" class="form-control form-control-solid mb-3 mb-lg-0"
                placeholder="Enter password">
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
                    <input type="text" name="address" id="address" class="form-control form-control-solid">
                </div>
                <div class="d-flex flex-column flex-grow-1 mb-2">
                    <label class="fw-bold fs-6" for="latitude">Latitude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control form-control-solid">
                </div>
                <div class="d-flex flex-column flex-grow-1 mb-2 me-md-2">
                    <label class="fw-bold fs-6" for="longitude">Longitude</label>
                    <input type="text" name="longitude" id="longitude" class="form-control form-control-solid">
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
</script>
@endsection