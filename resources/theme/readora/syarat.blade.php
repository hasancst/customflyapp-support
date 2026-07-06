@extends('tema::layout')

@section('title', 'Terms & Conditions')

@section('konten')
<div class="section-padding">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto; background: #fff; padding: 60px; border-radius: 30px; box-shadow: var(--shadow);">
            <h1 style="margin-bottom: 30px; text-align: center;">Terms & Conditions</h1>
            <div style="line-height: 1.8; color: var(--text-main);">
                <p>Welcome to {{ $pengaturan['nama_situs'] ?? 'Readora' }}. By accessing this website, you agree to comply with and be bound by the following terms and conditions of use...</p>
                <h3 style="margin: 30px 0 15px;">1. License to Use</h3>
                <p>Unless otherwise stated, {{ $pengaturan['nama_situs'] ?? 'Readora' }} and/or its licensors own the intellectual property rights for all material on this website.</p>
                <h3 style="margin: 30px 0 15px;">2. Restrictions</h3>
                <p>You are specifically restricted from all of the following: publishing any website material in any other media; selling, sublicensing and/or otherwise commercializing any website material...</p>
                <!-- Add more as needed -->
            </div>
        </div>
    </div>
</div>
@endsection
