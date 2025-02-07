@extends('layouts.app')
@section('title') Authors List  @endsection
@section('css')
<link href="{{ url('datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
@endsection

@section('content')

<div class="container">
    <h3>Authors List</h3>
    <table id="authors" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Action</th>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@endsection

@section('js')
<script src="{{ url('datatables/datatables.min.js') }}"></script>

<script>
    var table;
    $(function() {
        table = $('#authors').DataTable({
        	processing: true,
            serverSide: true,
            "ajax": {
                "url":'{{ url(route("authors.search"))  }}',
                "type": "POST",
                "async": false,
            },
            columns: [
                { data: 'sr_no' ,name:'sr_no', orderable: false},
            	{ data: 'first_name', name: 'first_name',orderable: false},
                { data: 'last_name', name: 'last_name',orderable: false},
                { data: 'gender', name: 'gender',orderable: false},
                { data: 'action', name: 'action', orderable: false },
            ],
            "aaSorting": [[3,'asc']],
         });
    });
</script>
@endsection
