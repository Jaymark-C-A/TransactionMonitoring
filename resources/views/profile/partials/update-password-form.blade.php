<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card mx-auto smoky-shadow bg-white"> <!-- Added smoky-shadow class for visual effect -->
                <header class="card-header" style="background: #2e3849; color: white;">
                    <h3 class="font-medium">
                        {{ __('Update Password') }}
                    </h3>           
                </header>

                <form method="post" action="{{ route('password.update') }}" class="card-body"> <!-- Directly use card-body class -->
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <!-- Current Password -->
                        <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                        <x-text-input id="update_password_current_password" name="current_password" type="password" 
                                      class="mt-1 block w-full password-field" autocomplete="current-password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>
                    
                    <div class="mb-3">
                        <!-- New Password -->
                        <x-input-label for="update_password_password" :value="__('New Password')" />
                        <x-text-input id="update_password_password" name="password" type="password" 
                                      class="mt-1 block w-full password-field" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>
                    
                    <div class="mb-1">
                        <!-- Confirm Password -->
                        <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                                      class="mt-1 block w-full password-field" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                    
                    <!-- Show Password Toggle -->
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="showPasswordToggle" onclick="togglePasswords()" />
                        <label class="form-check-label" for="showPasswordToggle">Show Passwords</label>
                    </div>
                    

                    <div class="flex items-center gap-4">
                        <x-primary-button class="w-100">{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'password-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript -->
<script>
    function togglePasswords() {
        const passwordFields = document.querySelectorAll('.password-field');
        passwordFields.forEach(field => {
            field.type = field.type === 'password' ? 'text' : 'password';
        });
    }
</script>
