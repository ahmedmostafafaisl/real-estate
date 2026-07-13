<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    // GET /api/pages — public
    public function index()
    {
        return CmsPage::where('status', 'published')->get(['id', 'title', 'slug']);
    }

    public function show(string $slug)
    {
        return CmsPage::where('slug', $slug)->where('status', 'published')->firstOrFail();
    }

    // Admin CRUD
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        return CmsPage::create([...$data, 'slug' => Str::slug($data['title'])]);
    }

    public function update(Request $request, CmsPage $cmsPage)
    {
        $cmsPage->update($request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'content' => ['sometimes', 'nullable', 'string'],
            'status' => ['sometimes', 'in:draft,published'],
        ]));

        return $cmsPage;
    }

    public function destroy(CmsPage $cmsPage)
    {
        $cmsPage->delete();
        return response()->json(['message' => 'Page deleted']);
    }
}
