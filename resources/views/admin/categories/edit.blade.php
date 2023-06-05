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
    enctype="multipart/form-data" action="{{route('category.update',$category->id)}}">
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
            <label class="required fw-bold fs-6 mb-2">Category Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="category_name" class="form-control form-control-solid mb-3 mb-lg-0"
                placeholder="Enter category name" value="{{$category->category_name}}">
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->

        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="check" @if($category->is_active)
            @checked(true) @endif>
            <label class="form-check-label" for="check">Is Active</label>
        </div>



        <div class="text-center pt-10">
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