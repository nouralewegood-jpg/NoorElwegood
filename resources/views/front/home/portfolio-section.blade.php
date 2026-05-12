<!-- معرض الأعمال المميزة - بتصميم احترافي -->
<div class="row g-4 portfolio-grid">
    @foreach ($featuredPortfolios as $portfolio)
        <div class="col-lg-4 col-md-6 portfolio-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="portfolio-card">
                <a href="{{ route('portfolio.show', $portfolio->id) }}" class="portfolio-card-link">
                    <div class="portfolio-image">
                        <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" loading="lazy">
                        <div class="portfolio-overlay">
                            <div class="portfolio-overlay-content">
                                <h3 class="portfolio-title">{{ $portfolio->title }}</h3>
                                @if ($portfolio->category)
                                    <div class="portfolio-category">{{ $portfolio->category }}</div>
                                @endif
                                <span class="portfolio-button">
                                    <i class="bi bi-arrow-right-circle"></i> عرض التفاصيل
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="portfolio-info">
                        <h3 class="portfolio-info-title">{{ $portfolio->title }}</h3>
                        @if ($portfolio->category)
                            <div class="portfolio-info-category">{{ $portfolio->category }}</div>
                        @endif
                    </div>
                </a>
            </div>
        </div>
    @endforeach
</div>

<style>
    /* ====== تصميم معرض الأعمال ====== */
    .portfolio-grid {
        margin: 0 -15px;
    }

    .portfolio-item {
        padding: 15px;
        transition: all 0.4s ease;
    }

    .portfolio-card {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        margin-bottom: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        background-color: #ffffff;
        height: 100%;
    }

    .portfolio-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .portfolio-card-link {
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .portfolio-image {
        position: relative;
        height: 240px;
        overflow: hidden;
    }

    .portfolio-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .portfolio-card:hover .portfolio-image img {
        transform: scale(1.1);
    }

    .portfolio-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(64, 71, 112, 0.9), rgba(64, 71, 112, 0.6));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.4s ease;
    }

    .portfolio-card:hover .portfolio-overlay {
        opacity: 1;
    }

    .portfolio-overlay-content {
        text-align: center;
        color: white;
        padding: 20px;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.4s ease 0.1s;
    }

    .portfolio-card:hover .portfolio-overlay-content {
        transform: translateY(0);
        opacity: 1;
    }

    .portfolio-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .portfolio-category {
        font-size: 14px;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.9);
        display: inline-block;
        padding: 5px 15px;
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 50px;
    }

    .portfolio-button {
        display: inline-block;
        padding: 10px 25px;
        background-color: white;
        color: #404770;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid white;
    }

    .portfolio-button:hover {
        background-color: transparent;
        color: white;
    }

    .portfolio-button i {
        margin-left: 5px;
        transition: transform 0.3s ease;
    }

    .portfolio-card:hover .portfolio-button i {
        transform: translateX(-5px);
    }

    .portfolio-info {
        padding: 20px;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .portfolio-info-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #404770;
        transition: all 0.3s ease;
    }

    .portfolio-info-category {
        font-size: 14px;
        color: #777;
        display: flex;
        align-items: center;
    }

    .portfolio-info-category:before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        background: linear-gradient(135deg, #404770, #e9a134);
        margin-left: 8px;
        border-radius: 50%;
    }

    @media (max-width: 991.98px) {
        .portfolio-image {
            height: 220px;
        }

        .portfolio-title {
            font-size: 18px;
        }
    }

    @media (max-width: 767.98px) {
        .portfolio-image {
            height: 200px;
        }

        .portfolio-overlay-content {
            padding: 15px;
        }
    }
</style>
