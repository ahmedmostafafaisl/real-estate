<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\Faq;
use Illuminate\Database\Seeder;

class CmsContentSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['slug' => 'about-us', 'title' => 'About Us', 'content' =>
                "Keystone connects property seekers with verified agencies, brokers, owners, and developers across the region. ".
                "We built the platform to make listing, discovering, and closing on a property straightforward for everyone involved — ".
                "clear approval workflows for providers, transparent search for customers, and real oversight for administrators."],
            ['slug' => 'contact-us', 'title' => 'Contact Us', 'content' =>
                "We're happy to help with questions about listings, subscriptions, or your account. ".
                "Reach us using the form on this page or email support@keystone.io — we typically respond within one business day."],
            ['slug' => 'privacy-policy', 'title' => 'Privacy Policy', 'content' =>
                "This Privacy Policy describes how Keystone collects, uses, and protects your information when you use our platform. ".
                "Replace this placeholder with your organization's reviewed privacy policy before going live."],
            ['slug' => 'terms-conditions', 'title' => 'Terms & Conditions', 'content' =>
                "These Terms & Conditions govern your use of the Keystone platform, including listing, browsing, and subscription features. ".
                "Replace this placeholder with your organization's reviewed terms before going live."],
        ];

        foreach ($pages as $p) {
            CmsPage::firstOrCreate(['slug' => $p['slug']], ['title' => $p['title'], 'content' => $p['content'], 'status' => 'published']);
        }

        $faqs = [
            ['question' => 'How do I list a property?', 'answer' => 'Register as a service provider, get verified, then create a listing from your dashboard — it goes live once an admin approves it.', 'sort_order' => 1],
            ['question' => 'How much does a subscription cost?', 'answer' => 'Plans start at SAR 149/month. See the Subscription Packages page for the full comparison.', 'sort_order' => 2],
            ['question' => 'How do I schedule a viewing?', 'answer' => 'Open any published listing and use the "Request a viewing" button — the provider will confirm a time with you.', 'sort_order' => 3],
            ['question' => 'Is my payment information secure?', 'answer' => 'Yes — all payments are processed through PCI-compliant gateways; we never store your card details directly.', 'sort_order' => 4],
        ];

        foreach ($faqs as $f) {
            Faq::firstOrCreate(['question' => $f['question']], $f);
        }
    }
}
