<?php

namespace App\Http\Controllers\Web\Site;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\ContactMessage;
use App\Models\Faq;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $page = CmsPage::where('slug', 'about-us')->where('status', 'published')->first();

        return view('site.page', ['title' => __('site.about_title'), 'page' => $page]);
    }

    public function contact()
    {
        $page = CmsPage::where('slug', 'contact-us')->where('status', 'published')->first();

        return view('site.contact', ['page' => $page]);
    }

    public function submitContact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        ContactMessage::create($data);

        return back()->with('status', __('site.contact_thanks'));
    }

    public function faq()
    {
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();

        return view('site.faq', compact('faqs'));
    }

    public function privacy()
    {
        $page = CmsPage::where('slug', 'privacy-policy')->where('status', 'published')->first();

        return view('site.page', ['title' => __('site.privacy_title'), 'page' => $page]);
    }

    public function terms()
    {
        $page = CmsPage::where('slug', 'terms-conditions')->where('status', 'published')->first();

        return view('site.page', ['title' => __('site.terms_title'), 'page' => $page]);
    }
}
