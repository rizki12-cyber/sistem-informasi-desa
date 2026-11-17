@extends('layouts.app')

@section('title', $news->title)
@section('description', Str::limit(strip_tags($news->content), 160))

@section('content')
<style>
    .news-detail { padding: 120px 0 60px; background: #f5f7f5; }
    .detail-container { max-width: 800px; margin: 0 auto; }
    .detail-card { background: white; border-radius: 16px; padding: 40px; border: 1px solid #e8efe8; }
    .detail-card img { width: 100%; border-radius: 12px; margin-bottom: 24px; }
    .detail-card .date { font-size: 14px; color: #6b7a6b; margin-bottom: 8px; }
    .detail-card h1 { font-size: 32px; font-weight: 700; color: #1a2e1a; margin-bottom: 16px; }
    .detail-card .content { font-size: 16px; color: #2d3a2d; line-height: 1.9; }
    .detail-card .content p { margin-bottom: 16px; }
    .back-link { display: inline-block; margin-top: 24px; color: #2e7d32; font-weight: 600; text-decoration: none; }
    .back-link:hover { text-decoration: underline; }
    .related-news { margin-top: 40px; }
    .related-news h3 { font-size: 20px; font-weight: 600; margin-bottom: 16px; }
    .related-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
    .related-item { background: white; border-radius: 12px; overflow: hidden; border: 1px solid #e8efe8; transition: all 0.3s; }
    .related-item:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
    .related-item img { width: 100%; height: 120px; object-fit: cover; }
    .related-item .body { padding: 12px 16px; }
    .related-item .body h4 { font-size: 14px; font-weight: 600; }
    .related-item .body a { color: #2e7d32; font-size: 13px; }
    @media (max-width: 768px) { .news-detail { padding: 100px 0 40px; } .detail-card { padding: 24px; } .detail-card h1 { font-size: 24px; } }
</style>

<div class="news-detail">
    <div class="container">
        <div class="detail-container">
            <div class="detail-card">
                @if($news->thumbnail)
                    <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" loading="lazy">
                @endif
                <div class="date">{{ $news->formatted_date }}</div>
                <h1>{{ $news->title }}</h1>
                <div class="content">{!! $news->content !!}</div>
                <a href="{{ route('public.news.index') }}" class="back-link">← Kembali ke Berita</a>
            </div>

            @if($relatedNews->isNotEmpty())
                <div class="related-news">
                    <h3>Berita Lainnya</h3>
                    <div class="related-grid">
                        @foreach($relatedNews as $item)
                            <div class="related-item">
                                @if($item->thumbnail)
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" loading="lazy">
                                @endif
                                <div class="body">
                                    <h4>{{ Str::limit($item->title, 40) }}</h4>
                                    <a href="{{ route('public.news.show', $item->slug) }}">Baca →</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection