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

    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:blogs,title',
            'slug' => ['nullable','string','max:255','unique:blogs,slug',],
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'featured_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048',],
            'content' => 'required',
            'status' => ['required','in:draft,published',],
        ]);

       // $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $slug = Str::slug($request->title);
        $featuredImage = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $originalName = pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $imageName = time(). '_' . Str::slug($originalName) . '.' . $extension;
            $imagePath = $this->websiteBlogImagesPath();
            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath,0755,true);
            }
            $image->move($imagePath,$imageName);
            $featuredImage = '../images/blogs/' . $imageName;
        }

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
            ->with('success','Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        return view('blog.edit',compact('blog'));
    }

    public function update(Request $request,Blog $blog) {

        $request->validate([
            'title' => 'required|string|max:255',

            'slug' => ['nullable','string','max:255',
                Rule::unique('blogs','slug')->ignore($blog->id),
            ],
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'featured_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048',],
            'content' => 'required',
            'status' => ['required','in:draft,published',],
        ]);
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $featuredImage = $blog->featured_image;
        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                $oldImage = $this->websiteRootPath(). '/' . str_replace('../','',$blog->featured_image);
                if (File::exists($oldImage)) {
                    File::delete($oldImage);
                }
            }

            $image = $request->file('featured_image');
            $originalName = pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $imageName = time(). '_' . Str::slug($originalName) . '.' . $extension;
            $imagePath = $this->websiteBlogImagesPath();
            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath,0755,true);
            }

            $image->move($imagePath,$imageName);
            $featuredImage ='../images/blogs/' . $imageName;
        }

        $blog->update([
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
            ->with('success','Blog updated successfully.');
    }


    public function destroy(Blog $blog)
    {
        if ($blog->html_file) {
        $htmlFile = $this->websiteRootPath(). '/' . $blog->html_file;
        if (File::exists($htmlFile)) {
            File::delete($htmlFile);
        }
    }

        if ($blog->featured_image) {
            $imageFile = $this->websiteRootPath(). '/' . str_replace('../','',$blog->featured_image);
            if (File::exists($imageFile)) {
                File::delete($imageFile);
            }
        }

        $blog->delete();
        return redirect()
            ->route('blogs.index')
            ->with('success','Blog deleted successfully.');
    }


    private function generateHtml(Blog $blog)
    {
        $html = view('blog.template',['blog' => $blog])->render();
        $websiteBlogsPath = $this->websiteBlogsPath();
        //dd($websiteBlogsPath);
        if (!File::exists($websiteBlogsPath)) {
            File::makeDirectory($websiteBlogsPath,0755,true);
        }

        $fileName = $blog->slug . '.html';
        $htmlFile = $websiteBlogsPath. '/' . $fileName;
        File::put($htmlFile,$html);
        $blog->update(['html_file' => 'blog/' . $fileName,]);
    }
}