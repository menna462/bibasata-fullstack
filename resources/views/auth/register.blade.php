<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل حساب جديد</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" />
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
            <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">إنشاء حساب جديد</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 mb-2">الاسم الكامل</label>
                    <input type="text" id="name" name="name" :value="old('name')" required autofocus
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 mb-2">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                {{-- Phone --}}
                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 mb-2">رقم الهاتف</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                        required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                    @error('phone_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                {{-- Password --}}
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 mb-2">كلمة السر</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 mb-2">تأكيد كلمة السر</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                </div>
                {{-- Submit --}}
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring">
                        تسجيل حساب
                    </button>
                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline text-sm">
                        لديك حساب بالفعل؟ تسجيل دخول
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
