@extends('adminlte::page')

@section('title', 'Edit Post')

@section('content_header')
<h1 class="text-center">Edit Post</h1>
@stop

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form id="editPostForm" action="{{ route('admin.post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}">
                            <div id="titleError" class="text-red mt-2" style="display: none;">Title is required.</div>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control">{{ $post->content }}</textarea>
                            <div id="contentError" class="text-red mt-2" style="display: none;">Content is required.</div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active" {{ $post->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $post->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <div id="statusError" class="text-red mt-2" style="display: none;">Status is required.</div>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <!-- Show existing image if available -->
                            @if ($post->image)
                            <div id="existingImageContainer" class="mb-2">
                                <img src="{{ asset('storage/' . $post->image) }}" id="existingImage" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                            @endif
                            <!-- Image input -->
                            <div class="custom-file">
                                <input type="file" name="image" id="imageInput" class="custom-file-input">
                                <label class="custom-file-label" for="imageInput">Choose file</label>
                            </div>
                            <!-- Image preview -->
                            <div class="mt-3" id="imagePreviewContainer" style="display: none;">
                                <img id="imagePreview" src="#" alt="Selected Image" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                            <div id="imageError" class="text-red mt-2" style="display: none;">Image is required.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Image preview handler (same as the Create view)
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');
        const existingImageContainer = document.getElementById('existingImageContainer');
        const fileNameLabel = document.querySelector('.custom-file-label');
        const imageError = document.getElementById('imageError');
        const imageInput = document.getElementById('imageInput');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block'; // Show the preview container
                if (existingImageContainer) {
                    existingImageContainer.style.display = 'none'; // Hide the existing image
                }
            };

            reader.readAsDataURL(file); // Convert the file to a data URL
            fileNameLabel.textContent = file.name; // Update the file label
            imageError.style.display = 'none'; // Hide the image error if file is selected
            imageInput.classList.remove('border', 'border-danger'); // Remove red border
        } else {
            previewContainer.style.display = 'none'; // Hide the preview container
            fileNameLabel.textContent = 'Choose file'; // Reset the file label
            if (existingImageContainer) {
                existingImageContainer.style.display = 'block'; // Show the existing image
            }
            imageError.style.display = 'none'; // Hide the image error
            imageInput.classList.remove('border', 'border-danger'); // Remove red border
        }
    });

    // Form validation on submit
    document.getElementById('editPostForm').addEventListener('submit', function(event) {
        let isValid = true;

        // Title validation
        const title = document.getElementById('title');
        const titleError = document.getElementById('titleError');
        if (title.value.trim() === '') {
            title.classList.add('border', 'border-danger'); // Add red border
            titleError.style.display = 'block';
            isValid = false;
        } else {
            title.classList.remove('border', 'border-danger'); // Remove red border
            titleError.style.display = 'none';
        }

        // Content validation
        const content = document.getElementById('content');
        const contentError = document.getElementById('contentError');
        if (content.value.trim() === '') {
            content.classList.add('border', 'border-danger'); // Add red border
            contentError.style.display = 'block';
            isValid = false;
        } else {
            content.classList.remove('border', 'border-danger'); // Remove red border
            contentError.style.display = 'none';
        }

        // Status validation
        const status = document.getElementById('status');
        const statusError = document.getElementById('statusError');
        if (status.value.trim() === '') {
            status.classList.add('border', 'border-danger'); // Add red border
            statusError.style.display = 'block';
            isValid = false;
        } else {
            status.classList.remove('border', 'border-danger'); // Remove red border
            statusError.style.display = 'none';
        }

        // Image validation: Only required if no image is already set or new image is uploaded
        const imageInput = document.getElementById('imageInput');
        const imageError = document.getElementById('imageError');
        const existingImageContainer = document.getElementById('existingImageContainer');
        if (!imageInput.files.length && !existingImageContainer) {
            imageInput.classList.add('border', 'border-danger'); // Add red border
            imageError.style.display = 'block';
            isValid = false;
        } else {
            imageInput.classList.remove('border', 'border-danger'); // Remove red border
            imageError.style.display = 'none';
        }

        // Prevent form submission if any validation fails
        if (!isValid) {
            event.preventDefault();
        }
    });
</script>
@stop