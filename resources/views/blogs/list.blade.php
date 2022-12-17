@extends('layouts.app')

@section('content')
    <div class="container">
        <table id="blogTable" class="display" style="width:100%">
            <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Published_at</th>
                <th>status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Published_at</th>
                <th>status</th>
                <th>Actions</th>
            </tr>
            </tfoot>
        </table>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(()=>{

            // DataTable
            $('#blogTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('blogs.list')}}",
                columns: [
                    { data: 'image' , "searchable": "false"},
                    { data: 'title' },
                    { data: 'published_at' , "searchable": "false"},
                    { data: 'status', "searchable": "false" },
                    { data: 'action', "searchable": "false"},
                ]
            });
        });
    </script>
@endsection
