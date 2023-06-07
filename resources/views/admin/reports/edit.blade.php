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
    enctype="multipart/form-data" action="{{route('report.update',$report->id)}}">
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
            <label class="required fw-bold fs-6 mb-2">choose the reported product</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="form-group row">
                <div class="col-lg-4 col-md-9 col-sm-12">
                    <select class="form-control js-example-basic-single" name="product">
                        <option selected disabled>Select product</option>
                        @foreach ($products as $product)
                        <option value="{{$product->id}}" @if($report->product_id == $product->id) selected
                            @endif>{{$product->title}}</option>
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
            <label class="required fw-bold fs-6 mb-2">choose the reporting user</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="form-group row">
                <div class="col-lg-4 col-md-9 col-sm-12">
                    <select class="form-control js-example-basic-single" name="user">
                        <option selected disabled>Select user</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}" @if($report->user_id == $user->id) selected
                            @endif>
                            {{$user->user_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!--end::Input-->
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Input group-->
        <div class="form-group mb-1">
            <label class="required fw-bold fs-6 mb-2">Report text</label>
            <textarea class="form-control" id="exampleTextarea" rows="3"
                name="report">{{$report->report_text}}</textarea>
        </div>


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

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection
