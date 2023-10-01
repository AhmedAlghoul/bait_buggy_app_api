@extends('admin.parent')

@section('styles')

@endsection


@section('content')

<form class="form" style="background-color: white; border: 1px solid #e4e7f0; padding: 20px;" role="form" method="POST"
    enctype="multipart/form-data" action="{{route('block.store')}}">
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
        <div class="fv-row mb-7 fv-plugins-icon-container">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Blocker User</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="form-group row">
                <div class="col-lg-4 col-md-9 col-sm-12">
                    <select class="form-control js-example-basic-single" name="blocker">
                        <option selected disabled>Select blocker user</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->user_name}}</option>
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
            <label class="required fw-bold fs-6 mb-2">Blocked User</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="form-group row">
                <div class="col-lg-4 col-md-9 col-sm-12">
                    <select class="form-control js-example-basic-single" name="blocked">
                        <option selected disabled>Select blocked user</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->user_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
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

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection