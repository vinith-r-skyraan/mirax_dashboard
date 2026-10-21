@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Edit Blog</h2>
            <p class="text-muted mb-0">
                Update blog #{{ $blog->id }}
            </p>
        </div>
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blogs.update', $blog->id) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="mb-4">
                            Blog Details
                        </h5>
                        <div class="mb-3">
                            <label class="form-label">
                                Blog Title
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $blog->title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Slug
                            </label>
                            <input type="text" name="slug" class="form-control"
                                value="{{ old('slug', $blog->slug) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Blog Content
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="content" id="blog-content"
                                class="form-control" rows="18"
                                required>{{ old('content', $blog->content) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="mb-4">
                            Publish
                        </h5>
                        <div class="mb-3">
                            <label class="form-label">
                                Status
                            </label>
                            <select name="status" class="form-select">
                                <option value="draft"
                                    {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}>
                                    Draft
                                </option>
                                <option value="published"
                                    {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>
                                    Published
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            Update Blog
                        </button>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Featured Image</h5>

                    {{-- Current image --}}
                    @if($blog->featured_image)
                        <div id="current-image-wrapper" class="mb-3 position-relative">
                            <img src="{{ asset('images/blogs/' . basename($blog->featured_image)) }}"
                                alt="{{ $blog->title }}" class="img-fluid rounded border"
                                style="max-height: 220px; width: 100%; object-fit: cover;">
                            <button type="button" id="remove-current-image"
                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2">
                                ✕ Remove
                            </button>
                        </div>
                    @endif

                    {{-- 1 = current image delete pannanum --}}
                    <input type="hidden" name="remove_featured_image" id="remove_featured_image" value="0">

                    <input type="file" name="featured_image" id="featured_image"
                        class="form-control @error('featured_image') is-invalid @enderror"
                        accept="image/jpeg,image/png,image/webp">

                    @error('featured_image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <div id="image-error" class="text-danger small mt-2 d-none"></div>

                    <small class="text-muted d-block mt-2">
                        JPG, JPEG, PNG or WEBP. Maximum 2MB. Leave empty to keep the current image.
                    </small>

                    {{-- New image preview --}}
                    <div id="image-preview-wrapper" class="mt-3 d-none position-relative">
                        <img id="image-preview" src="" alt="Preview" class="img-fluid rounded border"
                            style="max-height: 220px; width: 100%; object-fit: cover;">
                        <button type="button" id="remove-new-image"
                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2">
                            ✕ Remove
                        </button>
                    </div>
                </div>
            </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="mb-4">
                            SEO Settings
                        </h5>
                        <div class="mb-3">
                            <label class="form-label">
                                Meta Title
                            </label>
                            <input type="text" name="meta_title" class="form-control"
                                value="{{ old('meta_title', $blog->meta_title) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Meta Description
                            </label>
                            <textarea name="meta_description" class="form-control"
                                rows="5">{{ old('meta_description', $blog->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#blog-content'))
        .catch(error => console.error(error));

    const imageInput     = document.getElementById('featured_image');
    const imageError     = document.getElementById('image-error');
    const previewWrap    = document.getElementById('image-preview-wrapper');
    const previewImg     = document.getElementById('image-preview');
    const removeNewBtn   = document.getElementById('remove-new-image');
    const currentWrap    = document.getElementById('current-image-wrapper');
    const removeCurBtn   = document.getElementById('remove-current-image');
    const removeFlag     = document.getElementById('remove_featured_image');

    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    const maxSize      = 2 * 1024 * 1024;

    function showError(msg) {
        imageError.textContent = msg;
        imageError.classList.remove('d-none');
        imageInput.classList.add('is-invalid');
    }

    function clearError() {
        imageError.textContent = '';
        imageError.classList.add('d-none');
        imageInput.classList.remove('is-invalid');
    }

    function resetNewImage() {
        imageInput.value = '';
        previewImg.src = '';
        previewWrap.classList.add('d-none');
    }

    // Current image remove
    if (removeCurBtn) {
        removeCurBtn.addEventListener('click', function () {
            currentWrap.classList.add('d-none');
            removeFlag.value = '1';
        });
    }

    // New image select
    imageInput.addEventListener('change', function () {
        clearError();
        const file = this.files[0];

        if (!file) {
            resetNewImage();
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            showError('Only JPG, JPEG, PNG or WEBP images are allowed.');
            resetNewImage();
            return;
        }

        if (file.size > maxSize) {
            showError('Image size must not exceed 2MB.');
            resetNewImage();
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewWrap.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });

    // New image remove
    removeNewBtn.addEventListener('click', function () {
        resetNewImage();
        clearError();
    });
</script>
@endsection