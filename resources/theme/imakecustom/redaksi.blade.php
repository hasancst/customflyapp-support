@extends('tema::layout')

@section('title', 'Our Leadership | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('konten')
<section class="page-header" style="padding-top: 10rem; padding-bottom: 4rem;">
    <div class="container text-center reveal">
        <h1 class="section-title">Our <span>Leadership</span></h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto;">Meet the visionaries and engineers behind the most innovative custom manufacturing company.</p>
    </div>
</section>

<section class="team-content" style="padding-bottom: 8rem;">
    <div class="container">
        <div class="team-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 3rem;">
            <div class="team-card reveal">
                <div class="member-image" style="border-radius: 20px; overflow: hidden; height: 350px; border: 1px solid var(--glass-border);">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=500&q=80" alt="CEO" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="padding-top: 1.5rem; text-align: center;">
                    <h3 style="margin-bottom: 0.3rem;">Alexander Thorne</h3>
                    <p style="color: var(--secondary); font-weight: 600;">CEO & Founder</p>
                </div>
            </div>
            <div class="team-card reveal delay-1">
                <div class="member-image" style="border-radius: 20px; overflow: hidden; height: 350px; border: 1px solid var(--glass-border);">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=500&q=80" alt="CTO" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="padding-top: 1.5rem; text-align: center;">
                    <h3 style="margin-bottom: 0.3rem;">Sarah Jenkins</h3>
                    <p style="color: var(--secondary); font-weight: 600;">Chief Technical Officer</p>
                </div>
            </div>
            <div class="team-card reveal delay-2">
                <div class="member-image" style="border-radius: 20px; overflow: hidden; height: 350px; border: 1px solid var(--glass-border);">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=500&q=80" alt="COO" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="padding-top: 1.5rem; text-align: center;">
                    <h3 style="margin-bottom: 0.3rem;">Michael Chen</h3>
                    <p style="color: var(--secondary); font-weight: 600;">Head of Production</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
