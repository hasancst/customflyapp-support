@extends('tema::layout')

@section('title', 'Editorial Team')

@section('konten')
<div class="section-padding">
    <div class="container">
        <div style="text-align: center; max-width: 700px; margin: 0 auto 60px;">
            <span style="color: var(--primary); font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">Our Team</span>
            <h1 style="margin-top: 10px;">The Creative Minds Behind {{ $pengaturan['nama_situs'] ?? 'Readora' }}</h1>
        </div>

        <div class="masonry-grid" style="grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));">
            <div style="text-align: center; background: #fff; padding: 30px; border-radius: 20px; box-shadow: var(--shadow);">
                <img src="https://ui-avatars.com/api/?name=Admin+Site&background=FF4C60&color=fff&size=200" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 20px;">
                <h4>Founder & Editor in Chief</h4>
                <p style="color: var(--primary); font-weight: 700; font-size: 14px;">Jane Doe</p>
            </div>
            <div style="text-align: center; background: #fff; padding: 30px; border-radius: 20px; box-shadow: var(--shadow);">
                <img src="https://ui-avatars.com/api/?name=Creative+Director&background=6C5CE7&color=fff&size=200" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 20px;">
                <h4>Creative Director</h4>
                <p style="color: var(--secondary); font-weight: 700; font-size: 14px;">John Smith</p>
            </div>
            <!-- Add more team members -->
        </div>
    </div>
</div>
@endsection
