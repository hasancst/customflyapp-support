@extends('tema::layout')

@section('title', 'Knowledge Base - Pusat Bantuan')

@section('konten')
<section style="background: var(--purple-dark); padding: 150px 0 100px; color: #fff; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; margin-bottom: 20px; color: #fff;">Pusat Bantuan & Panduan</h1>
        <p style="font-size: 18px; opacity: 0.8; margin-bottom: 40px;">Cari jawaban, panduan penggunaan, dan solusi teknis dengan cepat.</p>
        
        <form action="/kb" method="GET" style="max-width: 700px; margin: 0 auto; position: relative;">
            <input type="text" name="q" value="{{ $search }}" placeholder="Apa yang bisa kami bantu? (contoh: cara install, masalah login...)" style="width: 100%; padding: 20px 30px; border-radius: 50px; border: none; font-size: 18px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); outline: none;">
            <button type="submit" style="position: absolute; right: 10px; top: 10px; bottom: 10px; padding: 0 30px; background: var(--primary-grad); color: #fff; border: none; border-radius: 40px; font-weight: 700; cursor: pointer;">Cari</button>
        </form>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        @if($search)
            <div style="margin-bottom: 50px;">
                <h3 style="margin-bottom: 30px;">Hasil Pencarian: "{{ $search }}"</h3>
                @if($results->isEmpty())
                    <div style="padding: 40px; background: #f8fafc; border-radius: 20px; text-align: center;">
                        <p>Maaf, kami tidak menemukan hasil untuk kata kunci tersebut.</p>
                        <a href="/kb" style="color: var(--primary); font-weight: 700;">Kembali ke Beranda KB</a>
                    </div>
                @else
                    <div style="display: grid; gap: 20px;">
                        @foreach($results as $res)
                            <a href="/kb/{{ $res->slug }}" class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 25px; transition: 0.3s; border: 1px solid #e2e8f0;">
                                <div>
                                    <h4 style="margin-bottom: 5px; color: var(--purple-dark);">{{ $res->judul }}</h4>
                                    <small style="color: #64748b;">Di posting dalam: {{ $res->category->nama }}</small>
                                </div>
                                <i class="fas fa-arrow-right" style="color: var(--primary);"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-bottom: 80px;">
                @foreach($categories as $cat)
                <div class="card" style="padding: 40px; text-align: center; transition: 0.3s; border: 1px solid #e2e8f0;">
                    <div style="width: 70px; height: 70px; background: var(--primary-grad); color: #fff; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 30px;">
                        <i class="{{ $cat->ikon ?: 'fas fa-book' }}"></i>
                    </div>
                    <h3 style="margin-bottom: 15px;">{{ $cat->nama }}</h3>
                    <p style="color: #64748b; margin-bottom: 25px;">{{ $cat->deskripsi ?: 'Kumpulan panduan mengenai ' . $cat->nama }}</p>
                    <a href="/kb/category/{{ $cat->slug }}" class="btn-cmn btn-outline" style="border-radius: 50px; font-size: 14px;">Lihat {{ $cat->articles_count }} Artikel</a>
                    
                    @if($cat->children->isNotEmpty())
                        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #e2e8f0; text-align: left;">
                            <small style="font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.75rem;">Sub Kategori:</small>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px;">
                                @foreach($cat->children as $child)
                                    <a href="/kb/category/{{ $child->slug }}" style="background: #f1f5f9; padding: 5px 12px; border-radius: 15px; font-size: 0.85rem; color: var(--purple-dark); text-decoration: none; transition: 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='#f1f5f9'; this.style.color='var(--purple-dark)';">
                                        {{ $child->nama }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>

            <div style="background: #f8fafc; padding: 60px; border-radius: 30px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center;">
                    <div>
                        <h2 style="margin-bottom: 30px;">Artikel Populer</h2>
                        <div style="display: grid; gap: 15px;">
                            @foreach($popularArticles as $pop)
                            <a href="/kb/{{ $pop->slug }}" style="display: flex; gap: 15px; align-items: center; color: var(--purple-dark); font-weight: 600; text-decoration: none;">
                                <i class="far fa-file-alt" style="color: var(--primary);"></i>
                                {{ $pop->judul }}
                                <small style="margin-left: auto; color: #a0aec0; font-weight: 400;">{{ $pop->views }} views</small>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div style="text-align: center;">
                        <div style="background: var(--purple); color: #fff; padding: 40px; border-radius: 25px;">
                            <h3 style="color: #fff; margin-bottom: 15px;">Masih ada kendala?</h3>
                            <p style="opacity: 0.8; margin-bottom: 25px;">Jika Anda tidak menemukan jawaban di sini, tim kami siap membantu Anda melalui sistem tiket.</p>
                            <a href="/kontak" class="btn-cmn" style="background: #fff; color: var(--purple); border: none;">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

@include('knowledgebase::public.ai_assistant')
@endsection
