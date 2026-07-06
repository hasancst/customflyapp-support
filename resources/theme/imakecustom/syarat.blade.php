@extends('tema::layout')

@section('title', 'Terms & Conditions | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('konten')
<section class="page-header" style="padding-top: 10rem; padding-bottom: 4rem;">
    <div class="container text-center reveal">
        <h1 class="section-title">Terms & <span>Conditions</span></h1>
        <p class="text-muted">Agreement between You and {{ $pengaturan['nama_situs'] ?? 'iMakeCustom' }}</p>
    </div>
</section>

<section class="terms-content" style="padding-bottom: 8rem;">
    <div class="container">
        <div class="glass-card reveal" style="padding: 4rem; line-height: 1.8;">
            <h2>1. Acceptance of Terms</h2>
            <p>By accessing or using our services, you agree to be bound by these Terms and Conditions. If you do not agree to all of these terms, do not use our services.</p>

            <h2>2. Manufacturing Services</h2>
            <p>All manufacturing services are subject to technical feasibility. We reserve the right to refuse any project that does not meet our safety or production standards.</p>

            <h2>3. Intellectual Property</h2>
            <p>You retain all ownership rights to the designs and materials you provide. {{ $pengaturan['nama_situs'] ?? 'iMakeCustom' }} maintains ownership of any proprietary processes or tools used in production.</p>

            <h2>4. Limitation of Liability</h2>
            <p>In no event shall {{ $pengaturan['nama_situs'] ?? 'iMakeCustom' }} be liable for any indirect, incidental, special, consequential or punitive damages arising out of or in connection with our services.</p>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .terms-content h2 { margin: 2rem 0 1rem; color: var(--primary); font-size: 1.5rem; }
    .terms-content p { margin-bottom: 1.5rem; color: var(--text-main); }
</style>
@endsection
