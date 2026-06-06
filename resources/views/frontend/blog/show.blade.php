@extends('layouts.app')

@section('title', $post->title . ' - Agontara Foundation Blog')
@section('hideDefaultNavigation', true)

@section('content')
<style>
    .single-post {
        background: linear-gradient(135deg, var(--bg-light) 0%, #f8fafc 100%);
        min-height: 100vh;
    }

    .post-hero {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)),
                    url('{{ $post->featured_image ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1800&h=600&fit=crop' }}') center/cover;
        color: white;
        padding: 10rem 1.5rem 5rem;
        text-align: center;
    }

    .post-hero h1 {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 800;
        max-width: 800px;
        margin: 0 auto 1rem;
    }

    .post-meta {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        font-size: 0.875rem;
    }

    .post-wrap {
        max-width: 900px;
        margin: -3rem auto 0;
        padding: 0 2rem 4rem;
    }

    .post-content {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .post-content h2 {
        font-size: 1.75rem;
        margin: 1.5rem 0 1rem;
        color: #111827;
    }

    .post-content h3 {
        font-size: 1.5rem;
        margin: 1.25rem 0 0.75rem;
        color: #111827;
    }

    .post-content p {
        line-height: 1.8;
        color: #4b5563;
        margin-bottom: 1rem;
    }

    .post-content img {
        max-width: 100%;
        border-radius: 8px;
        margin: 1.5rem 0;
    }

    .post-content ul, .post-content ol {
        margin: 1rem 0 1rem 2rem;
        color: #4b5563;
    }

    .post-content li {
        margin-bottom: 0.5rem;
    }

    .post-tags {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .post-tag {
        background: #f3f4f6;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        color: #4b5563;
    }

    .share-buttons {
        margin-top: 2rem;
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .share-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: transform 0.2s ease;
    }

    .share-btn:hover {
        transform: translateY(-2px);
    }

    .share-facebook { background: #3b5998; }
    .share-twitter { background: #1da1f2; }
    .share-linkedin { background: #0077b5; }
    .share-whatsapp { background: #25d366; }

    .related-posts {
        margin-top: 3rem;
    }

    .related-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .related-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }

    .related-card:hover {
        transform: translateY(-5px);
    }

    .related-image {
        height: 160px;
        background-size: cover;
        background-position: center;
    }

    .related-content {
        padding: 1rem;
    }

    .related-card h4 {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .related-card h4 a {
        color: #111827;
        text-decoration: none;
    }

    .related-card h4 a:hover {
        color: var(--primary);
    }

    .back-to-blog {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    .back-to-blog:hover {
        gap: 0.75rem;
    }

    @media (max-width: 768px) {
        .post-content {
            padding: 1.5rem;
        }
        
        .post-meta {
            gap: 1rem;
        }
    }
</style>

@include('layouts.frontend-navigation')

<div class="single-post">
    <section class="post-hero">
        <div class="container">
            <h1>{{ $post->title }}</h1>
            <div class="post-meta">
                <span><i class="far fa-calendar-alt"></i> {{ $post->formatted_date }}</span>
                <span><i class="far fa-user"></i> {{ $post->author }}</span>
                <span><i class="far fa-clock"></i> {{ $post->reading_time }}</span>
                <span><i class="far fa-eye"></i> {{ number_format($post->views) }} views</span>
                @if($post->category)
                <span><i class="far fa-folder"></i> {{ ucfirst($post->category) }}</span>
                @endif
            </div>
        </div>
    </section>

    <div class="post-wrap">
        <article class="post-content">
            <a href="{{ route('blog.index') }}" class="back-to-blog">
                <i class="fas fa-arrow-left"></i> Back to Blog
            </a>

            {!! $post->content !!}

            @if($post->tags)
            <div class="post-tags">
                <strong>Tags:</strong>
                @foreach(explode(',', $post->tags) as $tag)
                <span class="post-tag">#{{ trim($tag) }}</span>
                @endforeach
            </div>
            @endif

            <div class="share-buttons">
                <span style="font-weight: 600;">Share:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn share-facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="share-btn share-twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}" target="_blank" class="share-btn share-linkedin">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url()->current()) }}" target="_blank" class="share-btn share-whatsapp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </article>

        @if($related->count() > 0)
        <div class="related-posts">
            <h3 class="related-title">You Might Also Like</h3>
            <div class="related-grid">
                @foreach($related as $relatedPost)
                <div class="related-card">
                    <div class="related-image" style="background-image: url('{{ $relatedPost->featured_image ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=400&h=200&fit=crop' }}');"></div>
                    <div class="related-content">
                        <h4><a href="{{ route('blog.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a></h4>
                        <div class="blog-meta" style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">
                            <span><i class="far fa-calendar-alt"></i> {{ $relatedPost->formatted_date }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@include('layouts.frontend-footer')
@endsection