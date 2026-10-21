<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    private function websiteRootPath()
    {
        return 'C:/xampp/htdocs/miraxtechnology';
    }

    private function websiteBlogsPath()
    {
        return $this->websiteRootPath() . '/blog';
    }

    private function websiteBlogImagesPath()
    {
        return $this->websiteRootPath() . '/images/blogs';
    }

    private function adminBlogImagesPath()
    {
        return public_path('images/blogs');
    }

    private function imageMessages(): array
    {
        return [
            'featured_image.image' => 'The file must be an image.',
            'featured_image.mimes' => 'Only JPG, JPEG, PNG or WEBP images are allowed.',
            'featured_image.max'   => 'Image size must not exceed 2MB.',
        ];
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $blogs = Blog::latest()
            ->paginate($perPage)
            ->withQueryString(); // page maaarumbodhu per_page maaraama irukkum

        return view('blog.index', compact('blogs', 'perPage'));
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:blogs,title',
            'slug' => ['nullable', 'string', 'max:255', 'unique:blogs,slug'],
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'content' => 'required',
            'status' => ['required', 'in:draft,published'],
        ], $this->imageMessages());

        $slug = Str::slug($request->slug ?: $request->title);

        $featuredImage = $request->hasFile('featured_image')
            ? $this->saveBlogImage($request->file('featured_image'))
            : null;

        $blog = Blog::create([
            'title' => $request->title,
            'slug' => $slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'featured_image' => $featuredImage,
            'content' => $request->content,
            'status' => $request->status,
        ]);

        $this->generateHtml($blog);

        return redirect()
            ->route('blogs.index')
            ->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        return view('blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('blogs', 'title')->ignore($blog->id)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('blogs', 'slug')->ignore($blog->id)],
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_featured_image' => 'nullable|boolean',
            'content' => 'required',
            'status' => ['required', 'in:draft,published'],
        ], $this->imageMessages());

        $slug = Str::slug($request->slug ?: $request->title);
        $featuredImage = $blog->featured_image;

        if ($request->hasFile('featured_image')) {
            // New image upload -> old image rendu place-layum delete
            $this->deleteBlogImage($blog);
            $featuredImage = $this->saveBlogImage($request->file('featured_image'));
        } elseif ($request->boolean('remove_featured_image')) {
            // Remove button click panna
            $this->deleteBlogImage($blog);
            $featuredImage = null;
        }

        // Slug maarinaa old html file delete pannanum
        $oldHtml = $blog->html_file;

        $blog->update([
            'title' => $request->title,
            'slug' => $slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'featured_image' => $featuredImage,
            'content' => $request->content,
            'status' => $request->status,
        ]);

        if ($oldHtml && $oldHtml !== 'blog/' . $slug . '.html') {
            $oldFile = $this->websiteRootPath() . '/' . $oldHtml;
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
        }

        $this->generateHtml($blog);

        return redirect()
            ->route('blogs.index')
            ->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->html_file) {
            $htmlFile = $this->websiteRootPath() . '/' . $blog->html_file;
            if (File::exists($htmlFile)) {
                File::delete($htmlFile);
            }
        }

        $this->deleteBlogImage($blog);

        $blog->delete();

        return redirect()
            ->route('blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    private function saveBlogImage($image): string
    {
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $imageName = time() . '_' . Str::slug($originalName) . '.' . $extension;

        $websitePath = $this->websiteBlogImagesPath();
        $publicPath = $this->adminBlogImagesPath();

        foreach ([$websitePath, $publicPath] as $dir) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
        }

        $image->move($websitePath, $imageName);
        File::copy(
            $websitePath . DIRECTORY_SEPARATOR . $imageName,
            $publicPath . DIRECTORY_SEPARATOR . $imageName
        );

        return '../images/blogs/' . $imageName;
    }

    /**
     * Rendu location-layum image delete pannum.
     */
    private function deleteBlogImage(Blog $blog): void
    {
        if (!$blog->featured_image) {
            return;
        }

        $name = basename($blog->featured_image);

        foreach ([$this->websiteBlogImagesPath(), $this->adminBlogImagesPath()] as $dir) {
            $file = $dir . DIRECTORY_SEPARATOR . $name;
            if (File::exists($file)) {
                File::delete($file);
            }
        }
    }

    private function generateHtml(Blog $blog)
    {
        $html = view('blog.template', ['blog' => $blog])->render();
        $websiteBlogsPath = $this->websiteBlogsPath();

        if (!File::exists($websiteBlogsPath)) {
            File::makeDirectory($websiteBlogsPath, 0755, true);
        }

        $fileName = $blog->slug . '.html';
        File::put($websiteBlogsPath . '/' . $fileName, $html);
        $blog->update(['html_file' => 'blog/' . $fileName]);
    }
}