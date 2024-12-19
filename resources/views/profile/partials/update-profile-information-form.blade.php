<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card mx-auto smoky-shadow bg-white">
                <header class="card-header" style="background: #23395d; color: white;">
                    <h3 class="font-medium">
                        {{ __('Update Profile Information') }}
                    </h3>
                </header>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="card-body">
                    @csrf
                    @method('patch')
                    <div class="mb-3">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" value="" class="mt-1 block w-full" autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="email" class="text-black" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button class="w-100">{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'profile-updated')
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
