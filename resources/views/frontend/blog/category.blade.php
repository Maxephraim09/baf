@extends('layouts.app')

@section('title', ucfirst($category) . ' - Agontara Foundation Blog')
@section('hideDefaultNavigation', true)

@section('content')
<style>
    .category-page {
        background: linear-gradient(135deg, var(--bg-light) 0%, #f8fafc 100%);
        min-height: 100vh;
    }

    .category-hero {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 6rem 1.5rem 4rem;
        text-align: center;
    }

    .category-hero h1 {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .category-wrap {
        max-width: 1280px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }

    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
    }

    .blog-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .blog-image {
        height: 220px;
        background-size: cover;
        background-position: center;
    }

    .blog-content {
        padding: 1.5rem;
    }

    .blog-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.75rem;
        font-size: 0.75rem;
        color: #6b7280;
    }

    .blog-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .blog-title a {
        color: #111827;
        text-decoration: none;
    }

    .blog-title a:hover {
        color: var(--primary);
    }

    .blog-excerpt {
        color: #6b7280;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .read-more {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
        color: var(--primary);
        text-decoration: none;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 3rem;
    }

    @media (max-width: 768px) {
        .blog-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@include('layouts.frontend-navigation')

<div class="category-page">
    <section class="category-hero">
        <h1>{{ ucfirst($category) }}</h1>
        <p>Exploring stories and updates from {{ ucfirst($category) }} category</p>
    </section>

    <div class="category-wrap">
        <a href="{{ route('blog.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to All Posts
        </a>

        <div class="blog-grid">
            @forelse($posts as $post)
            <div class="blog-card">
                <div class="blog-image" style="background-image: url('{{ $post->featured_image ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=400&h=220&fit=crop' }}');"></div>
                <div class="blog-content">
                    <div class="blog-meta">
                        <span><i class="far fa-calendar-alt"></i> {{ $post->formatted_date }}</span>
                        <span><i class="far fa-clock"></i> {{ $post->reading_time }}</span>
                    </div>
                    <h3 class="blog-title">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    <p class="blog-excerpt">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}</p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="read-more">
                        Read More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 4rem; background: white; border-radius: 12px; grid-column: 1/-1;">
                <i class="fas fa-folder-open" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem; display: inline-block;"></i>
                <h3>No posts in this category yet</h3>
                <p>Check back soon for updates.</p>
                <a href="{{ route('blog.index') }}" class="btn-primary" style="display: inline-block; margin-top: 1rem;">Browse All Posts</a>
            </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $posts->links() }}
        </div>
    </div>
</div>

@include('layouts.frontend-footer')
@endsection