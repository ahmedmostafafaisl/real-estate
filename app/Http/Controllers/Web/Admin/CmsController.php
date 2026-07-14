<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    public function index()
    {
        $pages = CmsPage::all();
        $faqs = Faq::orderBy('sort_order')->get();

        return view('admin.cms', compact('pages', 'faqs'));
    }

    public function storePage(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        // Str::slug() can't transliterate Arabic titles — fall back to a random slug.
        $slug = Str::slug($data['title'], '-', 'en') ?: Str::lower(Str::random(8));
        CmsPage::create([...$data, 'slug' => $slug]);

        return back()->with('status', __('admin.flash_page_created'));
    }

    public function updatePage(CmsPage $page, Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $page->update($data);

        return back()->with('status', __('admin.flash_page_updated'));
    }

    public function storeFaq(Request $request)
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        Faq::create($data);

        return back()->with('status', __('admin.flash_faq_added'));
    }
}
