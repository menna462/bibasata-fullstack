@extends('index')

@section('content')
    <div class="container contact my-5">
        <div class="row align-items-center">
            <!-- FAQ Section (Left) -->
            <div class="col-md-6">
                <h2 class="mb-4">{{ __('language.contact.faq_title') }}</h2>
                <div id="faqAccordion">
                    <!-- FAQ 1 -->
                    <div class="faq-item">
                        <p>
                            <a data-toggle="collapse" class="text-reset text-decoration-none" href="#collapsone"
                                role="button" aria-expanded="false" aria-controls="collapsone">
                                {{ __('language.contact.faq_q1_title') }}
                            </a>
                        </p>
                        <div class="collapse" id="collapsone" data-parent="#faqAccordion">
                            <div class="card card-body">
                                {{ __('language.contact.faq_q1_answer') }}
                            </div>
                        </div>
                    </div>
                    <hr />

                    <!-- FAQ 2 -->
                    <div class="faq-item">
                        <p>
                            <a data-toggle="collapse" class="text-reset text-decoration-none" href="#collapstwo"
                                role="button" aria-expanded="false" aria-controls="collapstwo">
                                {{ __('language.contact.faq_q2_title') }}
                            </a>
                        </p>
                        <div class="collapse" id="collapstwo" data-parent="#faqAccordion">
                            <div class="card card-body">
                                {{ __('language.contact.faq_q2_answer') }}
                            </div>
                        </div>
                    </div>
                    <hr />

                    <!-- FAQ 3 -->
                    <div class="faq-item">
                        <p>
                            <a data-toggle="collapse" class="text-reset text-decoration-none" href="#collapsthree"
                                role="button" aria-expanded="false" aria-controls="collapsthree">
                                {{ __('language.contact.faq_q3_title') }}
                            </a>
                        </p>
                        <div class="collapse" id="collapsthree" data-parent="#faqAccordion">
                            <div class="card card-body">
                                {{ __('language.contact.faq_q3_answer') }}
                            </div>
                        </div>
                    </div>
                    <hr />
                </div>
            </div>

            <!-- Contact Form Section (Right) -->
            <div class="col-md-6">
                <h2 class="mb-4">{{ __('language.contact.form_title') }}</h2>
                <form action="{{ route('contact.send') }}" method="POST">
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

                    {{-- ✅ أخطاء التحقق من البيانات --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name">{{ __('language.contact.name_label') }}</label>
                        <input type="text" name="name" class="form-control form-control-lg" id="name"
                            value="{{ old('name') }}" placeholder="{{ __('language.contact.name_placeholder') }}"
                            required />
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('language.contact.email_label') }}</label>
                        <input type="email" name="email" class="form-control form-control-lg" id="email"
                            value="{{ old('email') }}" placeholder="{{ __('language.contact.email_placeholder') }}"
                            required />
                    </div>
                    <div class="form-group">
                        <label for="phone">{{ __('language.contact.phone_label') }}</label>
                        <input type="text" name="phone" class="form-control form-control-lg" id="phone"
                            value="{{ old('phone') }}" placeholder="{{ __('language.contact.phone_placeholder') }}" />
                    </div>
                    <div class="form-group">
                        <label for="message">{{ __('language.contact.message_label') }}</label>
                        <textarea name="message" class="form-control form-control-lg" id="message" rows="5"
                            placeholder="{{ __('language.contact.message_placeholder') }}" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mb-5"
                        style="background-color: #28a745; color: white;">
                        {{ __('language.contact.send_message_button') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
