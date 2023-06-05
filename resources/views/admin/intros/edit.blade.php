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
    enctype="multipart/form-data" action="{{route('intro.update',$intro->id)}}">
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
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="d-block fw-bold fs-6 mb-5">Intro Image</label>
            <!--end::Label-->
            <!--begin::Image input-->
            <div class="image-input image-input-outline" data-kt-image-input="true"
                style="background-image: url('assets/media/svg/avatars/blank.svg')">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-125px h-125px"
                    style="background-image: url('{{ asset($intro->image_path) }}');">
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
            <label class="required fw-bold fs-6 mb-2">title</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="title" class="form-control form-control-solid mb-3 mb-lg-0"
                placeholder="Enter Intro title" value="{{$intro->title}}">
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">description</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="description" class="form-control form-control-solid mb-3 mb-lg-0"
                placeholder="Enter Intro description" value="{{$intro->description}}">
            <!--end::Input-->
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
<script>
    setTimeout(function() {
        document.getElementById('success-message').style.display = 'none';
    }, 15000);
    setTimeout(function() {
    document.getElementById('error-message').style.display = 'none';
    }, 15000);
</script>
@endsection
