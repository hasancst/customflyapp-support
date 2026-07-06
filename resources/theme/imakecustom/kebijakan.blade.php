@extends('tema::layout')

@section('title', 'Privacy Policy | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('konten')
<section class="page-header" style="padding-top: 10rem; padding-bottom: 4rem;">
    <div class="container text-center reveal">
        <h1 class="section-title">Privacy <span>Policy</span></h1>
        <p class="text-muted">Last updated: {{ date('F d, Y') }}</p>
    </div>
</section>

<section class="policy-content" style="padding-bottom: 8rem;">
    <div class="container">
        <div class="glass-card reveal" style="padding: 4rem; line-height: 1.8;">
            <h2>1. Information We Collect</h2>
            <p>We collect information you provide directly to us when you request a quote, create an account, or communicate with us. This may include your name, email address, phone number, and project details.</p>

            <h2>2. How We Use Your Information</h2>
            <p>We use the information we collect to provide, maintain, and improve our services, communicate with you about your projects, and send you technical notices and support messages.</p>

            <h2>3. Data Security</h2>
            <p>We take reasonable measures to help protect information about you from loss, theft, misuse and unauthorized access, disclosure, alteration and destruction.</p>

            <h2>4. Contact Us</h2>
            <p>If you have any questions about this Privacy Policy, please contact us at {{ $pengaturan['email_admin'] ?? 'hello@imakecustom.com' }}.</p>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .policy-content h2 { margin: 2rem 0 1rem; color: var(--primary); font-size: 1.5rem; }
    .policy-content p { margin-bottom: 1.5rem; color: var(--text-main); }
</style>
@endsection
