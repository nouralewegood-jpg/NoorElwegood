@if (isset($featuredPortfolios) && $featuredPortfolios->count() > 0)
    <!-- بداية قسم الأعمال المميزة -->
    <section id="featured-works" class="portfolio section light-background">
        <div class="container section-title" data-aos="fade-up">
            <h2>أعمالنا المميزة</h2>
            <p>نماذج من أعمالنا المتميزة في مجال التصميم الداخلي والديكور</p>
        </div>
        <div class="container">
            <div class="row g-4 justify-content-center" data-aos="fade-up" data-aos-delay="100">
                @foreach ($featuredPortfolios as $portfolio)
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="portfolio-item mb-30">
                            <div class="portfolio-img">
                                <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" class="img-fluid">
                                <div class="portfolio-overlay">
                                    <div class="portfolio-content">
                                        <h3 class="portfolio-title">{{ $portfolio->title }}</h3>
                                        @if ($portfolio->category)
                                            <p class="portfolio-category">{{ $portfolio->category }}</p>
                                        @endif
                                        <a href="{{ route('portfolio.show', $portfolio->id) }}"
                                            class="portfolio-button">المزيد من التفاصيل</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12 text-center mt-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('portfolio.index') }}" class="btn btn-primary">عرض جميع الأعمال</a>
                </div>
            </div>
        </div>
    </section>
    <!-- نهاية قسم الأعمال المميزة -->
@endif
