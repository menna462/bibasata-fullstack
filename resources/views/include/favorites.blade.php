@extends('index')
@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Your Favorite Items</h1>

        {{-- تم إضافة رسائل تأكيد أو خطأ --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($favorites->isEmpty())
            <p>You haven't added any items to your favorites yet.</p>
        @else
            <div class="row" id="favorites-list">
                @foreach ($favorites as $favorite)
                    @if ($favorite->favoritable)
                        <div class="col-md-4 mb-4" data-card-id="{{ $favorite->favoritable->id }}"
                            data-card-type="{{ Str::lower(class_basename($favorite->favoritable_type)) }}">
                            <div class="card h-100 shadow-sm">
                                @if ($favorite->favoritable_type === 'App\Models\Product')
                                    <img src="{{ asset('image/products/' . $favorite->favoritable->image) }}"
                                        class="card-img-top" alt="{{ $favorite->favoritable->name }}"
                                        style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $favorite->favoritable->name }} <span
                                                class="badge bg-primary">Product</span></h5>
                                        <p class="card-text">{{ Str::limit($favorite->favoritable->description, 100) }}</p>
                                        <a href="{{ route('product.details', ['id' => $favorite->favoritable->id]) }}"
                                            class="btn btn-info btn-sm">View Product</a>

                                    </div>
                                @elseif($favorite->favoritable_type === 'App\Models\Bundle')
                                    <img src="{{ asset('image/products/' . $favorite->favoritable->image) }}"
                                        class="card-img-top" alt="{{ $favorite->favoritable->name }}"
                                        style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $favorite->favoritable->name }} <span
                                                class="badge bg-success">Bundle</span></h5>
                                        <p class="card-text">{{ Str::limit($favorite->favoritable->description, 100) }}</p>
                                        <a href="{{ route('bundle.details', ['id' => $favorite->favoritable->id]) }}"
                                            class="btn btn-info btn-sm">View Bundle</a>
                                    </div>
                                @endif
                                <div class="card-footer bg-transparent border-top-0">
                                    <button type="button"
                                        class="btn btn-outline-danger btn-sm w-100 remove-from-favorites-btn"
                                        data-favoritable-id="{{ $favorite->favoritable->id }}"
                                        data-favoritable-type="{{ Str::lower(class_basename($favorite->favoritable_type)) }}">
                                        Remove from Favorites
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $favorites->links() }} {{-- لعرض روابط الـ Pagination --}}
            </div>
        @endif
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log("DOM content loaded. Attaching event listeners.");

        document.querySelectorAll('.remove-from-favorites-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                console.log("Button clicked!");

                const button = e.target;
                const favoritableId = button.dataset.favoritableId;
                const favoritableType = button.dataset.favoritableType;
                const csrfToken = '{{ csrf_token() }}';
                // يتم البحث عن العنصر الأب الذي يحتوي على attributes data-card-id
                const card = button.closest('[data-card-id]');

                console.log(`Favoritable ID: ${favoritableId}, Favoritable Type: ${favoritableType}`);

                // عرض حالة التحميل
                button.disabled = true;
                button.textContent = 'Removing...';

                // استخدام المسار الصحيح "toggle.favorite"
                fetch('{{ route("toggle.favorite") }}', {
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
                .then(response => {
                    console.log("Received response from server:", response);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Received data:", data);
                    // الكنترولر يعيد حالة 'removed' عند الإزالة
                    if (data.status === 'removed') {
                        // إزالة البطاقة من DOM
                        card.remove();
                        console.log(data.message);
                    } else {
                        console.error("Error from server:", data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    // استخدام رسالة مخصصة بدلاً من alert()
                    // يمكنك استبدالها بمكون Modal
                    alert('An error occurred while removing from favorites. Please check the console for details.');
                })
                .finally(() => {
                    // إعادة تفعيل الزر في حالة حدوث فشل
                    if (card && card.parentNode) {
                        button.disabled = false;
                        button.textContent = 'Remove from Favorites';
                    }
                });
            });
        });
    });
</script>
@endsection

