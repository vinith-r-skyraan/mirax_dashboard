@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Blog Management</h2>
            <p class="text-muted mb-0">
                Manage your website blogs
            </p>
        </div>
        <a href="{{ route('blogs.create') }}" class="btn btn-primary">
            + Create Blog
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="70">#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th width="120">Status</th>
                            <th width="180">Created</th>
                            <th width="250">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            <tr>
                                <td>
                                    {{ $blog->id }}
                                </td>
                                <td>
                                    <strong>
                                        {{ $blog->title }}
                                    </strong>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $blog->slug }}
                                    </small>
                                </td>
                                <td>
                                    @if($blog->status === 'published')
                                        <span class="badge bg-success">
                                            Published
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {{ $blog->created_at->format('d-m-Y H:i') }}
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        {{-- View --}}
                                        {{-- @if($blog->html_file)
                                            <a href="{{ asset($blog->html_file) }}"
                                                target="_blank" class="btn btn-sm btn-success">
                                                View
                                            </a>
                                        @endif --}}

                                        {{-- Edit --}}
                                        <a href="{{ route('blogs.edit', $blog->id) }}"
                                            class="btn btn-sm btn-primary">
                                            Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <h5>No Blogs Found</h5>
                                    <p class="text-muted">
                                        Create your first blog.
                                    </p>
                                    <a href="{{ route('blogs.create') }}" class="btn btn-primary">
                                        + Create Blog
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection