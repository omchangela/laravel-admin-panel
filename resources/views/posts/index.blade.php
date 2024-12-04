@extends('adminlte::page')

@section('title', 'Posts')

@section('content_header')
<h1>Posts List</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-end">
        <a href="{{ route('admin.post.create') }}" class="btn btn-success">Create Post</a>
    </div>

    <div class="card-body">
        <table id="postsTable" class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($post->content, 50) }}</td>
                    <td>
                        @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-thumbnail" style="max-width: 100px;">
                        @else
                        <span>No Image</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $post->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </td>
                    <td>
                        <!-- Edit button -->
                        <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Delete button -->
                        <form action="{{ route('admin.post.destroy', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#postsTable').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable search functionality
            "ordering": true, // Enable column sorting
            "lengthChange": true, // Enable length change (rows per page)
            "pageLength": 10, // Set default rows per page
        });
    });
</script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

@stop
