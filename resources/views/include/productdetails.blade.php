@extends('welcome')
@section('content')
    <!-- nav down Section -->

    <!-- nav down Section -->
    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Shop</a></li>
                <li class="divider"></li>
                <li class="current">Asgaard sofa</li>
            </ul>
        </div>
    </div>

    <div class="container my-5">
        <div class="row product-page-card rounded-4 p-4">
            <div class="col-lg-5 p-3 d-flex justify-content-center">
                <div class="card product-card border-0 rounded-4">
                    {{-- استخدام صورة المنتج الديناميكية --}}
                    <img src="{{ asset('image/products/' . $product->image) }}" class="card-img-top rounded-4"
                        alt="{{ $product->name_en }}" />
                </div>
            </div>

            <div class="col-lg-7 p-3 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    {{-- اسم المنتج --}}
                    <h1 class="product-title">{{ $product->name_en }}</h1>
                </div>

                {{-- سعر المنتج (يجب أن يتم تعديله بناءً على المدة المختارة عبر JS) --}}
                <h2 class="product-price" id="current-price">
                    Rs. {{ number_format($product->durations->first()->price ?? 0, 2) }}
                </h2>

                {{-- جزء التقييم (ثابت هنا لأغراض العرض) --}}
                <div class="d-flex align-items-center mb-4">
                    <span class="text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </span>
                    <span class="ms-2 customer-reviews">1 Customer Review</span>
                </div>

                <p class="product-description mb-4">
                    {{ $product->long_description_en }}
                </p>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf

                    {{-- حقل مخفي لتمرير معرف المنتج --}}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <h5 class="duration-title mb-2">Duration</h5>
                    <div class="d-flex duration-options-container flex-wrap mb-4" role="group"
                        aria-label="Duration options">
                        {{-- عرض المدد المتاحة --}}
                        @foreach ($product->durations as $duration)
                            <input type="radio" id="duration-{{ $duration->id }}" name="duration_id"
                                value="{{ $duration->id }}" data-price="{{ $duration->price }}" required
                                class="d-none duration-radio" @if ($loop->first) checked @endif>
                            <label for="duration-{{ $duration->id }}"
                                class="btn btn-outline-secondary duration-option @if ($loop->first) active @endif">
                                {{ $duration->months }} months
                            </label>
                        @endforeach
                    </div>

                    <div class="d-flex align-items-center justify-content-start mb-4 gap-2 mt-5">
                        {{-- محدد الكمية --}}
                        <div class="input-group custom-quantity-selector">
                            <button class="btn custom-quantity-btn" type="button" data-action="decrement">-</button>
                            <input type="text" name="quantity" class="form-control text-center custom-quantity-input"
                                value="1" min="1" readonly />
                            <button class="btn custom-quantity-btn" type="button" data-action="increment">+</button>
                        </div>

                        {{-- زر الإرسال (الذي يرسل النموذج) --}}
                        <button class="btn custom-add-to-cart-btn" type="submit">Add To Cart</button>
                    </div>
                </form>
                {{-- =================================== --}}

                <hr />

                <div class="product-meta mt-4">
                    <p><strong>Product Code:</strong> {{ $product->id ?? 'N/A' }}</p>
                    <p><strong>Category:</strong> {{ $product->category->name_en ?? 'N/A' }}</p>
                    {{-- ... (جزء المشاركة) ... --}}
                </div>
            </div>
        </div>
    </div>




    <div class="tab-buttons">
        <button class="tab-button active" onclick="showContent('descriptionContent', event)">
            Description
        </button>
        <button class="tab-button" onclick="showContent('reviewsContent', event)">
            Reviews
        </button>
    </div>
    <div class="container">
        <div id="descriptionContent" class="tab-content active">
            <p>
                Embodying the raw, wayward spirit of rock 'n' roll, the Kilburn
                portable active stereo speaker takes the unmistakable look and sound
                of Marshall, unplugs the chords, and takes the show on the road.
            </p>
            <p>
                Weighing in under 7 pounds, the Kilburn is a lightweight piece of
                vintage styled engineering. Setting the bar as one of the loudest
                speakers in its class, the Kilburn is a compact, stout-hearted hero
                with a well-balanced audio which boasts a clear midrange and extended
                highs for a sound that is both articulate and pronounced. The analogue
                knobs allow you to fine tune the controls to your personal preferences
                while the guitar-influenced leather strap enables easy and stylish
                travel.
            </p>
        </div>

        <div id="reviewsContent" class="tab-content">
            <div class="add-comment-box">
                <div class="user-avatar">
                    <img src="../image/Ellipse3.png" alt="User Avatar" class="avatar-img" />
                </div>
                <div class="comment-input-area">
                    <input type="text" placeholder="Add a comment..." class="comment-input" />
                    <button class="post-button">Post</button>
                </div>
            </div>

            <div class="swiper myReviewsSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="review-section">
                            <div class="review-header">
                                <img src="../image/Ellipse3.png" alt="User Image" class="user-image" />
                                <div class="user-info">
                                    <h4>Armen Sargsyan</h4>
                                    <div class="rating">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                </div>
                                <p class="review-date">1 month ago</p>
                            </div>
                            <div class="review-body">
                                <p>
                                    Embodying the raw, wayward spirit of rock 'n' roll, the
                                    Kilburn portable active stereo speaker takes the
                                    unmistakable look and sound of Marshall, unplugs the chords,
                                    and takes the show on the road.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-section">
                            <div class="review-header">
                                <img src="../image/Ellipse3.png" alt="User Image" class="user-image" />
                                <div class="user-info">
                                    <h4>Amira Khaled</h4>
                                    <div class="rating">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                </div>
                                <p class="review-date">3 weeks ago</p>
                            </div>
                            <div class="review-body">
                                <p>
                                    The product quality is excellent and the design is very
                                    stylish. I highly recommend it!
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="review-section">
                            <div class="review-header">
                                <img src="../image/Ellipse3.png" alt="User Image" class="user-image" />
                                <div class="user-info">
                                    <h4>Ahmed Gamal</h4>
                                    <div class="rating">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                    </div>
                                </div>
                                <p class="review-date">1 week ago</p>
                            </div>
                            <div class="review-body">
                                <p>
                                    This is the best item I've ever bought. It's truly amazing
                                    and the sound quality is top-notch.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination reviews-pagination"></div>
            </div>
        </div>
    </div>

    <!-- card -->
    <div class="pro-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Products</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-3">
                    <div class="pro-card">
                        <img src="../image/card1.jpg" class="img-fluid" alt="Syltherine" />

                        <span class="pro-badge pro-badge-new">New</span>
                        <span class="pro-badge pro-badge-discount">-30%</span>

                        <div class="pro-overlay">
                            <div class="pro-hover-menu">
                                <button class="btn pro-add-to-cart">Add to cart</button>
                                <div class="pro-btn-actions">
                                    <button class="btn pro-btn-icon">
                                        <i class="fas fa-share-alt"></i>Share
                                    </button>
                                    <button class="btn pro-btn-icon">
                                        <i class="far fa-heart"></i>Like
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="pro-content">
                            <div class="pro-title">Syltherine</div>
                            <div class="pro-description">Stylish cafe chair</div>
                            <div class="pro-price-group">
                                <span class="pro-price-new">Rp 2.500.000</span>
                                <span class="pro-price-old">Rp 3.500.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="pro-card">
                        <img src="../image/card1.jpg" class="img-fluid" alt="Lolito" />
                        <span class="pro-badge pro-badge-new">New</span>
                        <div class="pro-overlay">
                            <div class="pro-hover-menu">
                                <button class="btn pro-add-to-cart">Add to cart</button>
                                <div class="pro-btn-actions">
                                    <button class="btn pro-btn-icon">
                                        <i class="fas fa-share-alt"></i>Share
                                    </button>
                                    <button class="btn pro-btn-icon">
                                        <i class="far fa-heart"></i>Like
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pro-content">
                            <div class="pro-title">Lolito</div>
                            <div class="pro-description">Luxury big sofa</div>
                            <div class="pro-price-group">
                                <span class="pro-price-new">Rp 7.000.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="pro-card">
                        <img src="../image/card1.jpg" class="img-fluid" alt="Product 3" />
                        <span class="pro-badge pro-badge-discount">-20%</span>
                        <div class="pro-overlay">
                            <div class="pro-hover-menu">
                                <button class="btn pro-add-to-cart">Add to cart</button>
                                <div class="pro-btn-actions">
                                    <button class="btn pro-btn-icon">
                                        <i class="fas fa-share-alt"></i>Share
                                    </button>
                                    <button class="btn pro-btn-icon">
                                        <i class="far fa-heart"></i>Like
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pro-content">
                            <div class="pro-title">Product 3</div>
                            <div class="pro-description">Short description here</div>
                            <div class="pro-price-group">
                                <span class="pro-price-new">Rp 1.200.000</span>
                                <span class="pro-price-old">Rp 1.500.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="pro-card">
                        <img src="../image/card1.jpg" class="img-fluid" alt="Product 4" />
                        <div class="pro-overlay">
                            <div class="pro-hover-menu">
                                <button class="btn pro-add-to-cart">Add to cart</button>
                                <div class="pro-btn-actions">
                                    <button class="btn pro-btn-icon">
                                        <i class="fas fa-share-alt"></i>Share
                                    </button>
                                    <button class="btn pro-btn-icon">
                                        <i class="far fa-heart"></i>Like
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pro-content">
                            <div class="pro-title">Product 4</div>
                            <div class="pro-description">Another cool item</div>
                            <div class="pro-price-group">
                                <span class="pro-price-new">Rp 5.000.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="pro-card">
                        <img src="../image/card1.jpg" class="img-fluid" alt="Product 5" />
                        <span class="pro-badge pro-badge-new">New</span>
                        <div class="pro-overlay">
                            <div class="pro-hover-menu">
                                <button class="btn pro-add-to-cart">Add to cart</button>
                                <div class="pro-btn-actions">
                                    <button class="btn pro-btn-icon">
                                        <i class="fas fa-share-alt"></i>Share
                                    </button>
                                    <button class="btn pro-btn-icon">
                                        <i class="far fa-heart"></i>Like
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pro-content">
                            <div class="pro-title">Product 5</div>
                            <div class="pro-description">Cool desk lamp</div>
                            <div class="pro-price-group">
                                <span class="pro-price-new">Rp 350.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="pro-card">
                        <img src="../image/card1.jpg" class="img-fluid" alt="Product 6" />
                        <div class="pro-overlay">
                            <div class="pro-hover-menu">
                                <button class="btn pro-add-to-cart">Add to cart</button>
                                <div class="pro-btn-actions">
                                    <button class="btn pro-btn-icon">
                                        <i class="fas fa-share-alt"></i>Share
                                    </button>
                                    <button class="btn pro-btn-icon">
                                        <i class="far fa-heart"></i>Like
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pro-content">
                            <div class="pro-title">Product 6</div>
                            <div class="pro-description">Stylish mug</div>
                            <div class="pro-price-group">
                                <span class="pro-price-new">Rp 150.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="pro-card">
                        <img src="../image/card1.jpg" class="img-fluid" alt="Product 7" />
                        <div class="pro-overlay">
                            <div class="pro-hover-menu">
                                <button class="btn pro-add-to-cart">Add to cart</button>
                                <div class="pro-btn-actions">
                                    <button class="btn pro-btn-icon">
                                        <i class="fas fa-share-alt"></i>Share
                                    </button>
                                    <button class="btn pro-btn-icon">
                                        <i class="far fa-heart"></i>Like
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pro-content">
                            <div class="pro-title">Product 7</div>
                            <div class="pro-description">Another stylish item</div>
                            <div class="pro-price-group">
                                <span class="pro-price-new">Rp 2.000.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="pro-card">
                        <img src="../image/card1.jpg" class="img-fluid" alt="Product 8" />
                        <span class="pro-badge pro-badge-new">New</span>
                        <span class="pro-badge pro-badge-discount">-50%</span>
                        <div class="pro-overlay">
                            <div class="pro-hover-menu">
                                <button class="btn pro-add-to-cart">Add to cart</button>
                                <div class="pro-btn-actions">
                                    <button class="btn pro-btn-icon">
                                        <i class="fas fa-share-alt"></i>Share
                                    </button>
                                    <button class="btn pro-btn-icon">
                                        <i class="far fa-heart"></i>Like
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pro-content">
                            <div class="pro-title">Product 8</div>
                            <div class="pro-description">A nice product</div>
                            <div class="pro-price-group">
                                <span class="pro-price-new">Rp 450.000</span>
                                <span class="pro-price-old">Rp 900.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <button class="btn pro-show-more-btn">Show More</button>
            </div>
        </div>
    </div>
@endsection
