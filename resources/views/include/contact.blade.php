@extends('welcome')

@section('content')

    <div class="shop">
        <div class="shop-contan">
            <h1>{{ __('language.contact.title') }}</h1>
            <p>
                {{ __('language.contact.home') }}
                <span><i class="fas fa-chevron-left"></i></span>
                {{ __('language.contact.subtitle') }}
            </p>
        </div>
    </div>

    <div class="container {{ app()->getLocale() === 'ar' ? 'rtl-links' : '' }}">
        <div class="contact-form-custom-container">
            <h2 class="text-center form-custom-title">{{ __('language.contact.form_title') }}</h2>
            <p class="text-center form-custom-description">
                {!! __('language.contact.form_desc') !!}
            </p>
            <form action="{{ route('contact.send') }}" method="POST" class="form-all">
                @csrf

                {{-- ✅ رسالة النجاح --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ✅ رسالة الخطأ --}}
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- ✅ أخطاء التحقق --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3 custom-input-wrapper">
                    <label for="fullName" class="form-label">{{ __('language.contact.name') }}</label>
                    <input type="text" name="name" class="form-control" id="fullNamze"
                        placeholder="{{ __('language.contact.name_placeholder') }}" value="{{ old('name') }}" required />
                </div>
                <div class="mb-3 custom-input-wrapper">
                    <label for="emailAddress" class="form-label">{{ __('language.contact.email') }}</label>
                    <input type="email" name="email" class="form-control" id="emailAddress"
                        placeholder="{{ __('language.contact.email_placeholder') }}" value="{{ old('email') }}"
                        required />
                </div>
                <div class="mb-3 custom-input-wrapper">
                    <label for="phone" class="form-label">{{ __('language.phone') }}</label>
                    <input type="text" name="phone" class="form-control" id="phone"
                        placeholder="{{ __('language.phone_placeholder') }}" value="{{ old('phone') }}" />
                </div>

                <div class="mb-3 custom-input-wrapper">
                    <label for="subject" class="form-label">{{ __('language.contact.subject') }}</label>
                    <input type="text" name="subject" class="form-control" id="subject"
                        placeholder="{{ __('language.contact.subject_placeholder') }}" value="{{ old('subject') }}" />
                </div>
                <div class="mb-4 custom-input-wrapper">
                    <label for="message" class="form-label">{{ __('language.contact.message') }}</label>
                    <textarea name="message" class="form-control" id="message" rows="5"
                        placeholder="{{ __('language.contact.message_placeholder') }}" required>{{ old('message') }}</textarea>
                </div>
                <div class="custom-input-wrapper">
                    <button type="submit" class="form-custom-btn">{{ __('language.contact.submit') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="green-line">
        <div class="container-fluid">
            <div class="row gx-0">
                <div class="col-lg-3 col-md-6 col-12 part">
                    <div class="img-inderline">
                        <img src="{{ asset('frontend/image/trophy.png') }}" alt="Trophy icon" />
                    </div>
                    <div>
                        <h5>{{ __('language.features.quality.title') }}</h5>
                        <p>{{ __('language.features.quality.desc') }}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 part">
                    <div class="img-inderline">
                        <img src="{{ asset('frontend/image/Vector1.png') }}" alt="Warranty icon" />
                    </div>
                    <div>
                        <h5>{{ __('language.features.warranty.title') }}</h5>
                        <p>{{ __('language.features.warranty.desc') }}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 part">
                    <div class="img-inderline">
                        <img src="{{ asset('frontend/image/Vector2.png') }}" alt="Deals icon" />
                    </div>
                    <div>
                        <h5>{{ __('language.features.deals.title') }}</h5>
                        <p>{{ __('language.features.deals.desc') }}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 part">
                    <div class="img-inderline">
                        <img src="{{ asset('frontend/image/Vector3.png') }}" alt="Support icon" />
                    </div>
                    <div>
                        <h5>{{ __('language.features.support.title') }}</h5>
                        <p>{{ __('language.features.support.desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
