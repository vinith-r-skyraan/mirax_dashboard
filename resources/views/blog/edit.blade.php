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
                        <h5 class="mb-4">
                            Featured Image
                        </h5>
                        @if($blog->featured_image)
                            <div class="mb-3">
                                <img src="{{ asset(str_replace('../', '', $blog->featured_image)) }}"
                                    alt="{{ $blog->title }}" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        @endif
                        <input type="file" name="featured_image" class="form-control"
                            accept="image/jpeg,image/png,image/webp">
                        <small class="text-muted">
                            Leave empty to keep the current image.
                        </small>
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
        .catch(error => {
            console.error(error);
        });
</script>
@endsection