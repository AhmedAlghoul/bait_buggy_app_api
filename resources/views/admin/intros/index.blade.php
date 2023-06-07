@extends('admin.parent')

@section('styles')

@endsection

@section('content')

<div class="card">
    <div class="card-header border-0 pt-6">
        <div style="text-align: center;">
            <h2>Intros List</h2>
        </div>
        <a href="{{route('intro.create')}}" class="btn btn-primary">

            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
            <span class="svg-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                        transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"></rect>
                </svg>
            </span>
            <!--end::Svg Icon-->Add Intro
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5 table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Intro Image</th>
                        <th>title</th>
                        <th>description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($intros as $intro)
                    <tr>
                        <td>{{$intro->id}}</td>

                        <td class=" align-items-center">
                            <!--begin:: photo -->
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <div class="symbol-label">
                                    <img src="{{$intro->image_path}}" alt="photo" class="w-100">
                                </div>
                                </a>
                            </div>
                            <!--end:: photo-->
                        </td>
                        <td>{{$intro->title}}</td>
                        <td>{{$intro->description}}</td>

                        <td>
                            <a href="{{route('intro.edit',$intro->id)}}" class="btn btn-info">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="#" class="btn btn-danger" onclick="confirmDestroy({{$intro->id}})">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Intro Image</th>
                        <th>title</th>
                        <th>description</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $("#kt_datatable_zero_configuration").DataTable();
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function confirmDestroy(id){
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'cancel',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
  if (result.isConfirmed) {
    destroy(id);
    // showSuccessMessage();

 }})
}
//  implement delete function using axios
function destroy(id){
  axios.delete('/intro/'+id)
    .then(function (response) {
  // handle success 2xx-3xx
  console.log( response.data);
  Swal.fire(
    'Deleted!',
    'Intro has been deleted.',
    'success'
  )
  location.reload();

  })
  .catch(function (error) {
  // handle error 4xx-5xx
    console.log(error);
  })
  .then(function () {
  // always executed
  });

}


</script>

@endsection