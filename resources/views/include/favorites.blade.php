@extends('welcome')

@section('content')
    <div class="shop">
        <div class="shop-contan">
            <h1>Wishlist</h1>
            <p>
                Home <span> <i class="fas fa-chevron-left"></i></span> Wishlist
            </p>
        </div>
    </div>

    {{-- رسائل تأكيد أو خطأ --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($favorites->isEmpty())
        <p class="text-center my-5">You haven't added any items to your favorites yet.</p>
    @else
        {{-- شريط الفلترة --}}
        <div class="filter-bar row justify-content-center text-center">
            <div class="left-section col-12 col-md-6 d-flex justify-content-center align-items-center mb-3 mb-md-0">
                <div class="filter-dropdown dropdown me-3">
                    <button class="filter-option dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-sliders-h"></i>
                        <span>Filter</span>
                    </button>
                    <ul class="filter-dropdown-menu dropdown-menu">
                        <li><a class="dropdown-item" href="#">Category 1</a></li>
                        <li><a class="dropdown-item" href="#">Category 2</a></li>
                        <li><a class="dropdown-item" href="#">Category 3</a></li>
                    </ul>
                </div>
                <div class="vertical-divider"></div>
                <span class="results-text ms-3">Showing {{ $favorites->firstItem() }} -
                    {{ $favorites->lastItem() }} of {{ $favorites->total() }} results</span>
            </div>

            <div class="right-section col-12 col-md-6 d-flex justify-content-center align-items-center">
                <p class="show-button mb-0 me-2">Show</p>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $favorites->perPage() }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#">10</a></li>
                        <li><a class="dropdown-item" href="#">16</a></li>
                        <li><a class="dropdown-item" href="#">32</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- المنتجات --}}
        <div class="card-shop">
            <div class="container">
                <div class="row g-4 justify-content-center mt-4" id="favorites-list">
                    @foreach ($favorites as $favorite)
                        @if ($favorite->favoritable)
                            <div class="col-6 col-md-3" data-card-id="{{ $favorite->favoritable->id }}"
                                data-card-type="{{ Str::lower(class_basename($favorite->favoritable_type)) }}">
                                <div class="pro-card">
                                    {{-- الصورة --}}
                                    <img src="{{ asset('image/products/' . $favorite->favoritable->image) }}"
                                        class="img-fluid" alt="{{ $favorite->favoritable->name }}" />

                                    {{-- بادجات --}}
                                    @if ($favorite->favoritable_type === 'App\Models\Product')
                                        <span class="pro-badge pro-badge-new">Product</span>
                                    @elseif($favorite->favoritable_type === 'App\Models\Bundle')
                                        <span class="pro-badge pro-badge-new">Bundle</span>
                                    @endif

                                    {{-- Overlay --}}
                                    <div class="pro-overlay">
                                        <div class="pro-hover-menu">
                                            <a href="{{ $favorite->favoritable_type === 'App\Models\Product'
                                                ? route('product.details', ['id' => $favorite->favoritable->id])
                                                : route('bundle.details', ['id' => $favorite->favoritable->id]) }}"
                                                class="btn pro-add-to-cart">
                                                View Details
                                            </a>
                                            <div class="pro-btn-actions">
                                                <button type="button" class="btn pro-btn-icon remove-from-favorites-btn"
                                                    data-favoritable-id="{{ $favorite->favoritable->id }}"
                                                    data-favoritable-type="{{ Str::lower(class_basename($favorite->favoritable_type)) }}">
                                                    <i class="far fa-heart"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- المحتوى --}}
                                    <div class="pro-content">
                                        <div class="pro-title">{{ $favorite->favoritable->name }}</div>
                                        <div class="pro-description">
                                            {{ Str::limit($favorite->favoritable->description, 50) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $favorites->links() }}
                </div>
            </div>
        </div>
    @endif

    {{-- نفس سكريبت الإزالة --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.remove-from-favorites-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const button = e.target.closest('button');
                    const favoritableId = button.dataset.favoritableId;
                    const favoritableType = button.dataset.favoritableType;
                    const csrfToken = '{{ csrf_token() }}';
                    const card = button.closest('[data-card-id]');

                    button.disabled = true;
                    button.textContent = 'Removing...';

                    fetch('{{ route('toggle.favorite') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                favoritable_id: favoritableId,
                                favoritable_type: favoritableType
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'removed') {
                                card.remove();
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            alert('Error removing favorite.');
                        })
                        .finally(() => {
                            button.disabled = false;
                            button.textContent = 'Remove';
                        });
                });
            });
        });
    </script>
@endsection
