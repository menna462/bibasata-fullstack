<section class="section-container section-three">
    <div class="aksam">
        <h1>Main Categories</h1>
    </div>
    <div class="swiper allcard">
        <div class="swiper-wrapper">
            @foreach ($categories as $category)
                <div class="category-wrapper swiper-slide">
                    <div class="section-item">
                        <div class="section-icon">
                            <img src="{{ asset('image/category/' . $category->image) }}" alt="" />
                        </div>
                    </div>
                    <p>{{ $category->name_en }}</p>
                </div>
            @endforeach
        </div>
        <!-- Navigation خاص بالكاتيجوري -->
        <div class="swiper-button-prev categories-prev"></div>
        <div class="swiper-button-next categories-next"></div>
    </div>
</section>
