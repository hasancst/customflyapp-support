@extends('tema::layout')

@section('title', 'Privacy Policy')

@section('konten')
<div class="section-padding">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto; background: #fff; padding: 60px; border-radius: 30px; box-shadow: var(--shadow);">
            <h1 style="margin-bottom: 30px; text-align: center;">Privacy Policy</h1>
            <div style="line-height: 1.8; color: var(--text-main);">
                <p>At {{ $pengaturan['nama_situs'] ?? 'Readora' }}, accessible from {{ url('/') }}, one of our main priorities is the privacy of our visitors...</p>
                <h3 style="margin: 30px 0 15px;">Information We Collect</h3>
                <p>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p>
                <h3 style="margin: 30px 0 15px;">How We Use Your Information</h3>
                <p>We use the information we collect in various ways, including to: Provide, operate, and maintain our website; Improve, personalize, and expand our website; Understand and analyze how you use our website...</p>
            </div>
        </div>
    </div>
</div>
@endsection
