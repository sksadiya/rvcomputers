@extends('layout.master')

@section('title') States  @endsection
@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />   
@endsection
@section('content')
@include('layout.session')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">States</h4>
      </div>

      <div class="card-body">
        <div class="listjs-table" id="stateList">
        <div class="row">
                    <div class="col-sm-9">
                        <h4 class="card-title mb-4">Manage States</h4>
                    </div>
                    <div class="col-sm-3 text-end">
                        <a href="{{ route('state.create') }}" class="btn btn-primary">Add New</a>
                    </div>
                </div>
          <div class="table-responsive">
            <table  width="100%"class="table table-bordered table-striped table-hover" id="stateTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Options</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function () {
$('#stateTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '{{ route('states.data') }}',
        type: 'GET',
        dataSrc: function (json) {
            console.log('Data received:', json);
            return json.data;
        },
        error: function(xhr, textStatus, errorThrown) {
            console.error('AJAX error:', textStatus, errorThrown);
        }
    },
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'status', name: 'status' },
        { data: 'options', name: 'action', orderable: false, searchable: false }
    ],
    order: [[0, 'asc'], [1, 'desc']],
    pageLength: 10
});
$('#stateTable tbody').on('click', 'button', function () {
    let id = $(this).attr('data-id');

    if (this.name == "btn-delete") {
        var isDelete = confirm("Are you sure you want to delete this?");
        if (isDelete) {
            $.ajax({
                type: 'DELETE',
                url: '{{ route('states.destroy', ':id') }}'.replace(':id', id),
                data: {
                    _token: '{{ csrf_token() }}', // Include CSRF token
                },
                success: function (response) {
                    $('#stateTable').DataTable().ajax.reload();
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('AJAX error:', status, error);
                }
            });
        }
    }
});
$('#stateTable tbody').on('click', '.state_status_change', function (e) {
    e.preventDefault();

    let id = $(this).data('id');
    $.ajax({
        url: "{{ route('states.changeStatus') }}",
        type: "POST",
        data: {
            state_id: id,
            _token: "{{ csrf_token() }}" 
        },
        success: function (response) {
            $('#stateTable').DataTable().ajax.reload();
            alert(response.message);
        },
        error: function (xhr) {
            alert('Error changing status. Please try again.');
        }
    });
    });
});
</script>
@endsection