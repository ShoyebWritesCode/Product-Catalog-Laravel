<x-guest-layout>
    <div class="w-full max-w-md mx-auto mt-10">
        <!-- Tab Navigation -->
        <div class="flex mb-4">
            <button id="user-tab" class="flex-1 py-2 text-center bg-indigo-600 text-white font-semibold"
                onclick="showTab('user')">
                {{ __('User Login') }}
            </button>
            <button id="admin-tab" class="flex-1 py-2 text-center bg-gray-200 font-semibold" onclick="showTab('admin')">
                {{ __('Admin Login') }}
            </button>
        </div>

        <!-- User Login Form -->
        <div id="user-form">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Admin Login Form -->
        <div id="admin-form" class="hidden">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('adminlogin') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showTab(tab) {
            document.getElementById('user-tab').classList.remove('bg-indigo-600', 'text-white');
            document.getElementById('user-tab').classList.add('bg-gray-200', 'text-gray-700');
            document.getElementById('admin-tab').classList.remove('bg-indigo-600', 'text-white');
            document.getElementById('admin-tab').classList.add('bg-gray-200', 'text-gray-700');

            document.getElementById('user-form').classList.add('hidden');
            document.getElementById('admin-form').classList.add('hidden');

            if (tab === 'user') {
                document.getElementById('user-tab').classList.remove('bg-gray-200', 'text-gray-700');
                document.getElementById('user-tab').classList.add('bg-indigo-600', 'text-white');
                document.getElementById('user-form').classList.remove('hidden');
            } else {
                document.getElementById('admin-tab').classList.remove('bg-gray-200', 'text-gray-700');
                document.getElementById('admin-tab').classList.add('bg-indigo-600', 'text-white');
                document.getElementById('admin-form').classList.remove('hidden');
            }
        }

        // Show user login form by default
        showTab('user');
    </script>
</x-guest-layout>
