                @if (Route::has('login'))
                    <div class="login-register-container mr-3">
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="login-register-button">
                                    <span class="login-link">{{ __('language.logout') }}</span>
                                </button>
                            </form>
                        @else
                            <button class="login-register-button">
                                <a href="{{ route('login') }}" class="login-link">{{ __('language.login') }}</a> /
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="register-link">{{ __('language.register') }}</a>
                                @endif
                            </button>
                        @endauth
                    </div>
                @endif
