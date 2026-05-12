<!-- شريط البحث -->
<div class="card sidebar-card search-card shadow-sm mb-4 mt-5">
    <div class="card-body">
        <h5 class="sidebar-title"><i class="fas fa-search me-2"></i>ابحث في المدونة</h5>
        <form action="{{ route('blog.search') }}" method="GET" accept-charset="UTF-8">
            <div class="input-group">
                <input type="text" name="q" class="form-control search-input" placeholder="البحث..."
                    value="{{ htmlspecialchars(request('q') ?? '', ENT_QUOTES, 'UTF-8') }}">
                <button type="submit" class="btn btn-primary search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- التصنيفات -->
<div class="card sidebar-card categories-card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="sidebar-title"><i class="fas fa-folder-open me-2"></i>التصنيفات</h5>
        <div class="list-group list-group-flush category-list">
            @foreach ($categories as $category)
                <a href="{{ route('blog.category', $category->slug) }}"
                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category-item">
                    <span><i class="fas fa-angle-left me-2 small"></i> {{ $category->name }}</span>
                    <span class="badge bg-primary rounded-pill badge-counter">{{ $category->posts_count }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- المقالات الشائعة -->
<div class="card sidebar-card popular-card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="sidebar-title"><i class="fas fa-star me-2"></i>المقالات الشائعة</h5>
        <div class="popular-posts">
            @foreach ($popularPosts as $post)
                <div class="popular-post-item">
                    <div class="row g-2">
                        @if ($post->featured_image)
                            <div class="col-3">
                                <a href="{{ route('blog.show', $post->slug) }}" class="popular-post-image">
                                    <img src="{{ $post->featured_image }}" class="img-fluid rounded"
                                        alt="{{ $post->title }}">
                                </a>
                            </div>
                            <div class="col-9">
                            @else
                                <div class="col-12">
                        @endif
                        <h6 class="mb-1">
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none post-title">
                                {{ Str::limit($post->title, 45) }}
                            </a>
                        </h6>
                        <div class="d-flex justify-content-between small text-muted">
                            <span><i class="far fa-calendar-alt me-1"></i>
                                {{ $post->published_at->format('d M, Y') }}</span>
                            <span><i class="far fa-eye me-1"></i> {{ $post->views }}</span>
                        </div>
                    </div>
                </div>
        </div>
        @endforeach
    </div>
</div>
</div>

<!-- النشرة البريدية إذا كانت متاحة -->
<div class="card sidebar-card newsletter-card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="sidebar-title"><i class="fas fa-envelope me-2"></i>النشرة البريدية</h5>
        <p class="text-muted small">اشترك في نشرتنا البريدية للحصول على أحدث المقالات والأخبار</p>
        <form action="#" method="POST" id="newsletter-form">
            @csrf
            <div class="mb-2">
                <input type="email" class="form-control newsletter-input" name="email"
                    placeholder="البريد الإلكتروني" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 newsletter-btn">
                <i class="fas fa-paper-plane me-1"></i> اشتراك
            </button>
        </form>
    </div>
</div>

<!-- الوسوم -->
<div class="card sidebar-card tags-card shadow-sm">
    <div class="card-body">
        <h5 class="sidebar-title"><i class="fas fa-tags me-2"></i>الوسوم</h5>
        <div class="d-flex flex-wrap gap-2 tags-cloud">
            @foreach ($tags as $tag)
                <a href="{{ route('blog.tag', $tag->slug) }}"
                    class="btn btn-sm btn-outline-secondary tag-btn {{ rand(0, 5) > 3 ? 'btn-large' : '' }}"
                    style="opacity: {{ 0.7 + ($tag->posts_count / max($tags->max('posts_count'), 1)) * 0.3 }}">
                    {{ $tag->name }}
                    <span class="tag-count">{{ $tag->posts_count }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- بطاقة الدعم أو الإعلان إذا كانت متاحة -->
<div class="card sidebar-card support-card shadow-sm my-4">
    <div class="card-body text-center">
        <h5 class="sidebar-title"><i class="fas fa-comments me-2"></i>هل تحتاج مساعدة؟</h5>
        <p class="mb-3 text-muted">نحن هنا للإجابة على استفساراتك ومساعدتك</p>
        <a href="{{ route('home') }}#contact" class="btn btn-outline-primary w-100">
            <i class="fas fa-headset me-1"></i> تواصل معنا
        </a>
    </div>
</div>

@push('styles')
    <style>
        /* تنسيق الشريط الجانبي */
        .sidebar-card {
            border-radius: 10px;
            overflow: hidden;
            border: none;
            transition: all 0.3s ease;
        }

        .sidebar-card:hover {
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.08) !important;
        }

        .sidebar-title {
            position: relative;
            font-weight: 600;
            padding-bottom: 10px;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .sidebar-title::after {
            content: "";
            position: absolute;
            bottom: -1px;
            right: 0;
            width: 50px;
            height: 2px;
            background-color: #f59c27;
        }

        /* البحث */
        .search-input {
            border-radius: 20px 0 0 20px;
            padding-right: 15px;
        }

        .search-btn {
            border-radius: 0 20px 20px 0;
        }

        /* تصنيفات */
        .category-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .category-item {
            transition: all 0.2s ease;
            border-radius: 5px;
            margin-bottom: 2px;
            border-right: 3px solid transparent;
        }

        .category-item:hover {
            transform: translateX(-5px);
            border-right-color: #404770;
            background-color: #f8f9fa;
        }

        .badge-counter {
            font-size: 10px;
            min-width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* المقالات الشائعة */
        .popular-posts {
            max-height: 350px;
            overflow-y: auto;
        }

        .popular-post-item {
            padding: 10px 0;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
        }

        .popular-post-item:last-child {
            border-bottom: none;
        }

        .popular-post-image {
            display: block;
            overflow: hidden;
            border-radius: 5px;
            height: 100%;
        }

        .popular-post-image img {
            height: 60px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .popular-post-item:hover .popular-post-image img {
            transform: scale(1.1);
        }

        .post-title {
            color: #333;
            font-weight: 500;
            transition: color 0.2s ease;
            line-height: 1.4;
            display: block;
        }

        .post-title:hover {
            color: #404770;
        }

        /* النشرة البريدية */
        .newsletter-input {
            border-radius: 8px;
        }

        .newsletter-btn {
            border-radius: 8px;
        }

        /* الوسوم */
        .tags-cloud {
            max-height: 250px;
            overflow-y: auto;
        }

        .tag-btn {
            transition: all 0.3s;
            margin-bottom: 5px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .tag-btn.btn-large {
            font-size: 0.9rem;
        }

        .tag-btn:hover {
            background-color: #404770;
            color: white;
        }

        .tag-count {
            font-size: 0.75rem;
            opacity: 0.8;
            margin-right: 3px;
            display: inline-block;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // معالجة نموذج النشرة البريدية
            const newsletterForm = document.getElementById('newsletter-form');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // يمكن استبدال هذا بإرسال طلب Ajax
                    alert('تم الاشتراك في النشرة البريدية بنجاح!');
                    this.reset();
                });
            }
        });
    </script>
@endpush
