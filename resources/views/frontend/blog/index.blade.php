@extends('layouts.app')

@section('title', 'Blog - News & Stories')
@section('hideDefaultNavigation', true)

@section('content')
<style>
    .blog-page {
        background: linear-gradient(135deg, var(--bg-light) 0%, #f8fafc 100%);
        min-height: 100vh;
    }

    .blog-hero {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.62), rgba(0, 0, 0, 0.35)),
                    url('https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1800&h=700&fit=crop') center/cover;
        color: white;
        padding: 8rem 1.5rem 7rem;
        text-align: center;
    }

    .blog-hero h1 {
        font-size: clamp(2.25rem, 6vw, 4rem);
        font-weight: 800;
        margin: 0 auto 1rem;
        max-width: 900px;
    }

    .blog-hero p {
        font-size: 1.125rem;
        line-height: 1.8;
        margin: 0 auto;
        max-width: 720px;
        opacity: 0.95;
    }

    .blog-wrap {
        max-width: 1280px;
        margin: -4rem auto 0;
        padding: 0 2rem 4rem;
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
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .blog-image {
        height: 220px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .blog-category {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: var(--primary);
        color: white;
        padding: 0.25rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
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
        line-height: 1.4;
    }

    .blog-title a {
        color: #111827;
        text-decoration: none;
        transition: color 0.2s ease;
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

    .read-more:hover {
        gap: 0.75rem;
    }

    .featured-section {
        margin-bottom: 3rem;
    }

    .featured-card {
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .featured-image {
        height: 400px;
        background-size: cover;
        background-position: center;
    }

    .featured-content {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .featured-badge {
        background: var(--primary);
        color: white;
        display: inline-block;
        padding: 0.25rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 1rem;
        width: fit-content;
    }

    .featured-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .featured-title a {
        color: #111827;
        text-decoration: none;
    }

    .featured-excerpt {
        color: #6b7280;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 3rem;
    }

    .pagination a, .pagination span {
        padding: 0.5rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination a:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .pagination .active span {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .sidebar {
        position: sticky;
        top: 6rem;
    }

    .sidebar-widget {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .sidebar-title {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary);
        display: inline-block;
    }

    .recent-posts {
        list-style: none;
    }

    .recent-posts li {
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .recent-posts li a {
        color: #374151;
        text-decoration: none;
        font-size: 0.875rem;
        line-height: 1.4;
    }

    .recent-posts li a:hover {
        color: var(--primary);
    }

    .recent-posts .post-date {
        font-size: 0.75rem;
        color: #9ca3af;
        display: block;
        margin-top: 0.25rem;
    }

    .categories-list {
        list-style: none;
    }

    .categories-list li {
        margin-bottom: 0.5rem;
    }

    .categories-list li a {
        color: #374151;
        text-decoration: none;
        display: flex;
        justify-content: space-between;
    }

    .categories-list li a:hover {
        color: var(--primary);
    }

    @media (max-width: 768px) {
        .featured-card {
            grid-template-columns: 1fr;
        }

        .featured-image {
            height: 250px;
        }

        .blog-grid {
            grid-template-columns: 1fr;
        }

        .blog-wrap {
            padding: 0 1rem 4rem;
        }
    }
</style>

@include('layouts.frontend-navigation')

<div class="blog-page">
    <section class="blog-hero">
        <h1>News & Stories</h1>
        <p>Stay updated with the latest news, impact stories, and updates from Agontara Foundation.</p>
    </section>

    <div class="blog-wrap">
        <div class="row" style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem;">
            <div class="main-content">
                @if($featured)
                <div class="featured-section">
                    <div class="featured-card">
                        <div class="featured-image" style="background-image: url('{{ $featured->featured_image ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=800&h=400&fit=crop' }}');"></div>
                        <div class="featured-content">
                            <span class="featured-badge">Featured Story</span>
                            <h2 class="featured-title">
                                <a href="{{ route('blog.show', $featured->slug) }}">{{ $featured->title }}</a>
                            </h2>
                            <div class="blog-meta">
                                <span><i class="far fa-calendar-alt"></i> {{ $featured->published_at ? $featured->published_at->format('F j, Y') : 'Date TBD' }}</span>
                                <span><i class="far fa-eye"></i> {{ number_format($featured->views) }} views</span>
                            </div>
                            <p class="featured-excerpt">{{ $featured->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($featured->content), 150) }}</p>
                            <a href="{{ route('blog.show', $featured->slug) }}" class="read-more">
                                Read Full Story <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <div class="blog-grid">
                    @forelse($posts as $post)
                    <div class="blog-card">
                        <div class="blog-image" style="background-image: url('{{ $post->featured_image ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=400&h=220&fit=crop' }}');">
                            @if($post->category)
                            <span class="blog-category">{{ ucfirst($post->category) }}</span>
                            @endif
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="far fa-calendar-alt"></i> {{ $post->published_at ? $post->published_at->format('F j, Y') : 'Date TBD' }}</span>
                            </div>
                            <h3 class="blog-title">
                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="blog-excerpt">{{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}</p>
                            <a href="{{ route('blog.show', $post->slug) }}" class="read-more">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 4rem; background: white; border-radius: 12px;">
                        <i class="fas fa-newspaper" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem; display: inline-block;"></i>
                        <h3>No posts yet</h3>
                        <p>Check back soon for updates and stories.</p>
                    </div>
                    @endforelse
                </div>

                <div class="pagination">
                    {{ $posts->links() }}
                </div>
            </div>

            <aside class="sidebar">
                <div class="sidebar-widget">
                    <h3 class="sidebar-title">Recent Posts</h3>
                    <ul class="recent-posts">
                        @forelse($recent ?? [] as $recentPost)
                        <li>
                            <a href="{{ route('blog.show', $recentPost->slug) }}">{{ $recentPost->title }}</a>
                            <span class="post-date">{{ $recentPost->published_at ? $recentPost->published_at->format('F j, Y') : 'Date TBD' }}</span>
                        </li>
                        @empty
                        <li>No recent posts</li>
                        @endforelse
                    </ul>
                </div>

                <div class="sidebar-widget">
                    <h3 class="sidebar-title">Categories</h3>
                    <ul class="categories-list">
                        @forelse($categories ?? [] as $cat)
                        <li>
                            <a href="{{ route('blog.category', $cat) }}">
                                {{ ucfirst($cat) }}
                                <span>({{ App\Models\Blog::where('category', $cat)->where('status', 'published')->count() }})</span>
                            </a>
                        </li>
                        @empty
                        <li>No categories</li>
                        @endforelse
                    </ul>
                </div>

                <div class="sidebar-widget">
                    <h3 class="sidebar-title">About Our Blog</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Stay updated with the latest news, success stories, and updates from our projects around the world.</p>
                </div>

                <div class="sidebar-widget">
                    <h3 class="sidebar-title">Get Involved</h3>
                    <p style="color: #6b7280; margin-bottom: 1rem;">Join us in making a difference. Donate, volunteer, or partner with us.</p>
                    <a href="{{ route('donate') }}" class="btn-primary" style="display: block; text-align: center; padding: 0.75rem;">
                        <i class="fas fa-heart"></i> Donate Now
                    </a>
                    <a href="{{ route('volunteer') }}" class="btn-secondary" style="display: block; text-align: center; padding: 0.75rem; margin-top: 0.5rem;">
                        <i class="fas fa-hands-helping"></i> Volunteer
                    </a>
                </div>
            </aside>
        </div>
    </div>
</div>

@include('layouts.frontend-footer')
@endsection