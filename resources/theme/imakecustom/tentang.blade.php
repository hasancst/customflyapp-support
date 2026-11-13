@extends('tema::layout')

@section('title', 'About Us | ' . ($pengaturan['nama_situs'] ?? 'iMakeCustom'))

@section('styles')
<style>
    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    .about-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .about-apps-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-top: 4.5rem;
    }
    .about-app-card {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 1.75rem;
        transition: transform 0.25s ease, border-color 0.25s ease;
    }
    .about-app-card:hover {
        transform: translateY(-4px);
        border-color: rgba(56, 189, 248, 0.45);
    }
    @media (max-width: 991px) {
        .about-grid,
        .about-apps-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .about-stats {
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }
    }
    @media (max-width: 575px) {
        .about-stats {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('konten')
<section class="page-header" style="padding-top: 9.5rem; padding-bottom: 3.5rem;">
    <div class="container text-center reveal">
        <h1 class="section-title">About <span>{{ $pengaturan['nama_situs'] ?? 'iMakeCustom' }}</span></h1>
        <p class="text-muted" style="max-width: 680px; margin: 0 auto;">Empowering Shopify merchants and Print-on-Demand brands with effortless 2D product personalization, high-res file uploads, and unlimited custom options.</p>
    </div>
</section>

<section class="about-content" style="padding-bottom: 7rem;">
    <div class="container">
        <div class="about-grid">
            <div class="reveal">
                <div class="image-wrapper" style="border-radius: 24px; overflow: hidden; border: 1px solid var(--glass-border); position: relative; background: #0f172a;">
                    <img src="{{ asset('theme/imakecustom/img/suite/customfly-canvas.png') }}" alt="iMakeCustom Shopify App Suite" style="width: 100%; display: block;">
                    <div class="glass-card" style="position: absolute; bottom: 18px; left: 18px; padding: 0.75rem 1.15rem; font-size: 0.9rem;">
                        <strong>Shopify App Suite</strong> · Customfly · Uploadfly · Optionfly
                    </div>
                </div>
            </div>
            <div class="reveal delay-1">
                <h2 style="font-size: 2.3rem; margin-bottom: 1.25rem;">Built for Custom Commerce</h2>
                <p style="margin-bottom: 1.1rem; color: var(--text-muted); font-size: 1.05rem; line-height: 1.75;">
                    At {{ $pengaturan['nama_situs'] ?? 'iMakeCustom' }}, we build specialized Shopify applications—<strong>Customfly</strong>, <strong>Uploadfly</strong>, and <strong>Optionfly</strong>—engineered to turn complex product customization into a fast, intuitive shopping experience.
                </p>
                <p style="margin-bottom: 1.5rem; color: var(--text-muted); font-size: 1.02rem; line-height: 1.75;">
                    From real-time 2D visual previews and automated 300+ DPI print-ready exports to unlimited custom options beyond Shopify’s 1000+ variant limits, our platform helps merchants eliminate manual order back-and-forth and scale custom sales globally.
                </p>
                <div class="about-stats">
                    <div>
                        <h3 style="color: var(--secondary); font-size: 1.85rem;">3 Apps</h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem;">Complete Shopify Suite</p>
                    </div>
                    <div>
                        <h3 style="color: var(--secondary); font-size: 1.85rem;">300+ DPI</h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem;">Print-Ready Automation</p>
                    </div>
                    <div>
                        <h3 style="color: var(--secondary); font-size: 1.85rem;">1000+</h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem;">Variants & Options</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-apps-grid">
            <div class="about-app-card reveal">
                <span style="color: #f77062; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">01 · Visual Personalizer</span>
                <h3 style="margin: 0.5rem 0 0.75rem; font-size: 1.35rem;">Customfly</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.65; margin-bottom: 1.25rem;">Interactive live 2D product customizer with multi-view switching, curved text, monograms, clipart, and instant mockup previews.</p>
                <a href="/blog/customfly-review-the-ultimate-interactive-product-personalizer-for-shopify-stores" style="color: #f77062; font-weight: 600; text-decoration: none;">Learn More <i class="fas fa-arrow-right" style="margin-left: 4px;"></i></a>
            </div>
            <div class="about-app-card reveal delay-1">
                <span style="color: #a855f7; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">02 · File Uploader</span>
                <h3 style="margin: 0.5rem 0 0.75rem; font-size: 1.35rem;">Uploadfly</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.65; margin-bottom: 1.25rem;">Seamless multi-format customer artwork uploads (PNG, JPG, PDF, SVG, AI, PSD) with in-browser crop/enhance and conditional rules.</p>
                <a href="/blog/uploadfly-the-best-shopify-file-uploader-app-for-custom-products-conditional-logic-dynamic-pricing" style="color: #a855f7; font-weight: 600; text-decoration: none;">Learn More <i class="fas fa-arrow-right" style="margin-left: 4px;"></i></a>
            </div>
            <div class="about-app-card reveal delay-2">
                <span style="color: #38bdf8; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">03 · Product Options</span>
                <h3 style="margin: 0.5rem 0 0.75rem; font-size: 1.35rem;">Optionfly</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.65; margin-bottom: 1.25rem;">Unlimited custom product options, color/image swatches, smart conditional logic, and live add-on pricing synced directly to the cart.</p>
                <a href="https://demo.imakecustom.com/pages/optionfly" target="_blank" rel="noopener" style="color: #38bdf8; font-weight: 600; text-decoration: none;">Explore App <i class="fas fa-arrow-right" style="margin-left: 4px;"></i></a>
            </div>
        </div>
    </div>
</section>
@endsection
