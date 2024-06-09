<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create new client') }}
        </h2>
    </x-slot>
    <div class="container mx-auto p-4">
        <div class="card">
            <form action="{{ route('admin.tenants.store') }}" method="POST" class=" p-6 rounded shadow-md" novalidate>
                @csrf
                <div class="mt-3">
                    <x-input-label for="email" :value="__('Email')" :required='true'/>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mt-3">
                    <x-input-label for="name" :value="__('Name')" :required='true'/>
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mt-3">
                    <x-input-label for="password" :value="__('Password')" :required='true'/>
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="mt-3">
                    <div class="flex items-center">
                        <x-input-label for="domain" :value="__('Domain')" :required='true'/>
                        <div x-data="{ showTooltip: false }" @mouseover="showTooltip = true" @mouseleave="showTooltip = false" class="mx-4 relative inline-block">
                            <i class="fas fa-exclamation-circle text-white text-lg cursor-pointer"></i>
                            <div x-show="showTooltip" class="absolute z-10 bg-black text-white text-xs rounded py-1 px-2 bottom-full left-1/2 -translate-x-1/2 transform whitespace-nowrap tooltip">
                                {{ __('If your domain name is ABC the domain will be abc.quizzes.com.') }}
                            </div>
                        </div>
                    </div>
                    <x-text-input id="domain" class="block mt-1 w-full" type="text" name="domain" :value="old('domain')" required />
                    <x-input-error :messages="$errors->get('domain')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Create new client') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
