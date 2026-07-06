@extends('tema::layout')

@section('title', $article->judul . ' - Knowledge Base')

@section('konten')
<section style="background: var(--purple-dark); padding: 150px 0 60px; color: #fff;">
    <div class="container">
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
            <a href="/kb" style="color: var(--primary); font-weight: 700;">Knowledge Base</a>
            <span style="opacity: 0.5;">/</span>
            <a href="/kb/category/{{ $article->category->slug }}" style="color: #fff; opacity: 0.8; text-decoration: none;">{{ $article->category->nama }}</a>
        </div>
        <h1 style="font-size: 40px; color: #fff; line-height: 1.2;">{{ $article->judul }}</h1>
        <div style="margin-top: 20px; opacity: 0.7; font-size: 14px; display: flex; gap: 20px;">
            <span><i class="far fa-calendar-alt"></i> Terakhir diperbarui: {{ $article->updated_at->format('d M Y') }}</span>
            <span><i class="far fa-eye"></i> {{ $article->views }} Views</span>
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 50px;">
            <article>
                <div class="kb-content" style="font-size: 18px; line-height: 1.8; color: var(--text-main);">
                    {!! $article->konten !!}
                </div>

                @if($article->tags)
                <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid #eee; display: flex; gap: 10px; flex-wrap: wrap;">
                    <span style="font-weight: 700; margin-right: 10px;">Tags:</span>
                    @foreach(explode(',', $article->tags) as $tag)
                        <span style="background: #f1f5f9; padding: 5px 15px; border-radius: 50px; font-size: 14px;">{{ trim($tag) }}</span>
                    @endforeach
                </div>
                @endif
            </article>

            <aside>
                <div style="background: #f8fafc; padding: 35px; border-radius: 25px; position: sticky; top: 100px;">
                    <h4 style="margin-bottom: 25px;">Artikel Terkait</h4>
                    <div style="display: grid; gap: 15px;">
                        @foreach($relatedArticles as $rel)
                        <a href="/kb/{{ $rel->slug }}" style="display: flex; gap: 10px; color: var(--purple-dark); text-decoration: none; font-weight: 600; line-height: 1.4;">
                            <i class="far fa-file-alt" style="color: var(--primary); margin-top: 4px;"></i>
                            {{ $rel->judul }}
                        </a>
                        @endforeach
                    </div>

                    <div style="margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 30px; text-align: center;">
                        <p style="font-weight: 700; margin-bottom: 10px;">Masih bingung?</p>
                        <p style="font-size: 14px; color: #64748b; margin-bottom: 20px;">Tim bantuan kami siap melayani pertanyaan Anda.</p>
                        <a href="/kontak" class="btn-cmn" style="width: 100%; font-size: 14px;">Buka Tiket</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<style>
    .kb-content h2, .kb-content h3 { margin: 40px 0 20px; color: var(--purple-dark); }
    .kb-content p { margin-bottom: 20px; }
    .kb-content ul, .kb-content ol { margin-bottom: 20px; padding-left: 20px; }
    .kb-content img { max-width: 100%; border-radius: 15px; margin: 30px 0; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .kb-content code { background: #f1f5f9; padding: 3px 8px; border-radius: 5px; font-family: monospace; color: #e11d48; }
    .kb-content pre { background: #1e293b; color: #f8fafc; padding: 25px; border-radius: 15px; overflow-x: auto; margin: 30px 0; }
</style>
@include('knowledgebase::public.ai_assistant')
@endsection
