@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Create Blog</h2>
            <p class="text-muted mb-0">
                Create a new website blog
            </p>
        </div>
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="mb-4">
                            Blog Details
                        </h5>

                        <div class="mb-3">
                            <label class="form-label">
                                Blog Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                placeholder="Enter blog title" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Slug
                            </label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}"
                                placeholder="blog-title">
                            <small class="text-muted">
                                Leave empty to generate automatically from title.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Blog Content <span class="text-danger">*</span>
                            </label>
                            <textarea name="content" id="blog-content"
                                rows="18">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- Publish --}}
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
                                    {{ old('status') === 'draft' ? 'selected' : '' }}>
                                    Draft
                                </option>

                                <option value="published"
                                    {{ old('status') === 'published' ? 'selected' : '' }}>
                                    Published
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Save Blog
                        </button>
                    </div>
                </div>

                {{-- Featured Image --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="mb-4">Featured Image</h5>

                        <input type="file" name="featured_image" id="featured_image"
                            class="form-control @error('featured_image') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/webp">

                        {{-- Server-side validation error --}}
                        @error('featured_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        {{-- Client-side validation error --}}
                        <div id="image-error" class="text-danger small mt-2 d-none"></div>

                        <small class="text-muted d-block mt-2">
                            JPG, JPEG, PNG or WEBP. Maximum 2MB.
                        </small>

                        {{-- Preview + Remove --}}
                        <div id="image-preview-wrapper" class="mt-3 d-none position-relative">
                            <img id="image-preview" src="" alt="Preview"
                                class="img-fluid rounded border" style="max-height: 220px; width: 100%; object-fit: cover;">
                            <button type="button" id="remove-image"
                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2">
                                ✕ Remove
                            </button>
                        </div>
                    </div>
                </div>

                {{-- SEO --}}
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
                                value="{{ old('meta_title') }}" placeholder="SEO title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Meta Description
                            </label>
                            <textarea name="meta_description" class="form-control" rows="5"
                                placeholder="SEO description">{{ old('meta_description') }}</textarea>
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

    // ---- Featured Image: validation + preview + remove ----
    const imageInput   = document.getElementById('featured_image');
    const imageError   = document.getElementById('image-error');
    const previewWrap  = document.getElementById('image-preview-wrapper');
    const previewImg   = document.getElementById('image-preview');
    const removeBtn    = document.getElementById('remove-image');

    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    const maxSize      = 2 * 1024 * 1024; // 2MB

    function resetImage() {
        imageInput.value = '';
        previewImg.src = '';
        previewWrap.classList.add('d-none');
    }

    function showError(message) {
        imageError.textContent = message;
        imageError.classList.remove('d-none');
        imageInput.classList.add('is-invalid');
    }

    function clearError() {
        imageError.textContent = '';
        imageError.classList.add('d-none');
        imageInput.classList.remove('is-invalid');
    }

    imageInput.addEventListener('change', function () {
        clearError();
        const file = this.files[0];

        if (!file) {
            resetImage();
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            showError('Only JPG, JPEG, PNG or WEBP images are allowed.');
            resetImage();
            return;
        }

        if (file.size > maxSize) {
            showError('Image size must not exceed 2MB.');
            resetImage();
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewWrap.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });

    removeBtn.addEventListener('click', function () {
        resetImage();
        clearError();
    });
</script>

@endsection