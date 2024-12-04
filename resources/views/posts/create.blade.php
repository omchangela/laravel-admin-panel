@extends('adminlte::page')

@section('title', 'Create Post')

@section('content_header')
<h1></h1>
@stop

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <!-- Form -->
                    <h3 class="text-center">Create Post</h3>
                    <form id="createPostForm" action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control">
                            <small id="titleError" class="text-danger" style="display: none;">Title is required.</small>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control"></textarea>
                            <small id="contentError" class="text-danger" style="display: none;">Content is required.</small>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <small id="statusError" class="text-danger" style="display: none;">Status is required.</small>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="imageInput" class="form-control">
                            <small id="imageError" class="text-danger" style="display: none;">Image is required.</small>
                            <!-- Image Preview -->
                            <div class="mt-3" id="imagePreviewContainer" style="display: none;">
                                <img id="imagePreview" src="#" alt="Selected Image" class="img-thumbnail" style="width: 200px; height: 200px; object-fit: contain;">
                            </div>


                        </div>
                        <button type="submit" class="btn btn-primary">Create Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle image preview
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block'; // Show the preview container
            };
            reader.readAsDataURL(file); // Convert the file to a data URL
        } else {
            previewContainer.style.display = 'none'; // Hide the preview container if no file is selected
        }
    });

    // Form validation
    document.getElementById('createPostForm').addEventListener('submit', function(event) {
        let isValid = true;

        // Title validation
        const title = document.getElementById('title');
        const titleError = document.getElementById('titleError');
        if (title.value.trim() === '') {
            titleError.style.display = 'block';
            isValid = false;
        } else {
            titleError.style.display = 'none';
        }

        // Content validation
        const content = document.getElementById('content');
        const contentError = document.getElementById('contentError');
        if (content.value.trim() === '') {
            contentError.style.display = 'block';
            isValid = false;
        } else {
            contentError.style.display = 'none';
        }

        // Status validation
        const status = document.getElementById('status');
        const statusError = document.getElementById('statusError');
        if (status.value.trim() === '') {
            statusError.style.display = 'block';
            isValid = false;
        } else {
            statusError.style.display = 'none';
        }

        // Image validation
        const imageInput = document.getElementById('imageInput');
        const imageError = document.getElementById('imageError');
        if (!imageInput.files || imageInput.files.length === 0) {
            imageError.style.display = 'block';
            isValid = false;
        } else {
            imageError.style.display = 'none';
        }

        // Prevent form submission if any validation fails
        if (!isValid) {
            event.preventDefault();
        }
    });
</script>
@stop