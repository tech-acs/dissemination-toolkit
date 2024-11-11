<div class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <div class="flex flex-col gap-6 px-6">

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-multi-lang-input id="name" name="name" type="text" value="{{ old('name', $organization->name ?? null) }}" />
                    <x-input-error for="name" class="mt-2" />
                </div>
                <div>
                    <x-label for="slogan" value="{{ __('Slogan') }}" />
                    <x-multi-lang-input id="slogan" name="slogan" type="text" value="{{ old('slogan', $organization->slogan ?? null) }}" />
                    <x-input-error for="slogan" class="mt-2" />
                </div>

                <div>
                    <x-label for="website" value="{{ __('Website') }}" />
                    <x-input class="w-full" id="website" name="website" type="text" value="{{ old('name', $organization->website ?? null) }}" />
                    <x-input-error for="website" class="mt-2" />
                </div>
                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input class="w-full" id="email" name="email" type="text" value="{{ old('email', $organization->email ?? null) }}" />
                    <x-input-error for="email" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-label for="logo" value="{{ __('Logo') }}" />
                    <x-input id="logo" name="logo" type="file" value="{{ old('logo', $organization->logo_path ?? null) }}"
                             class="mt-1 block border border-gray-300 rounded-md shadow-sm focus:outline-none file:border-0 file:overflow-hidden file:p-2" />
                    <x-input-error for="logo" class="mt-2" />
                </div>
                <div>
                    <div class="h-24 w-auto bg-gray-50 border-2 border-dashed border-gray-200 relative">
                        <div class="w-full h-full flex justify-center">
                            @if(isset($organization->logo_path))
                                <img id="logo-preview" src="{{ asset(empty($org?->logo_path) ? 'images/placeholder-logo.png' : $org->logo_path) }}" alt="Current Logo" class="border-2 ">
                            @else
                                <p class="flex items-center text-gray-600 mt-2">Upload logo with aspect ratio  16 / 9</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <div>
                <x-label for="blurb" value="{{ __('Introduction') }}" class="inline" /><x-locale-display />
                {{--<x-textarea name="blurb" rows="3"></x-textarea>--}}
                <x-easy-mde name="blurb">{{ old('blurb', $organization->blurb ?? null) }}</x-easy-mde>
                <x-input-error for="blurb" class="mt-2" />
            </div>
            <x-label for="logo_path" value="{{ __('Social Media') }}" />
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-label for="twitter" value="{{ __('Twitter') }}" />
                    <x-input class="w-full" id="twitter" name="twitter" type="text" value="{{ old('twitter', $organization->social_media['twitter'] ?? null) }}" />
                    <x-input-error for="twitter" class="mt-2" />
                </div>
                <div>
                    <x-label for="facebook" value="{{ __('Facebook') }}" />
                    <x-input class="w-full" id="facebook" name="facebook" type="text" value="{{ old('facebook', $organization->social_media['facebook'] ?? null) }}" />
                    <x-input-error for="facebook" class="mt-2" />
                </div>
                <div>
                    <x-label for="instagram" value="{{ __('Instagram') }}" />
                    <x-input class="w-full" id="instagram" name="instagram" type="text" value="{{ old('instagram', $organization->social_media['instagram'] ?? null) }}" />
                    <x-input-error for="instagram" class="mt-2" />
                </div>
                <div>
                    <x-label for="facebook" value="{{ __('Linkedin') }}" />
                    <x-input class="w-full" id="facebook" name="facebook" type="text" value="{{ old('facebook', $organization->social_media['facebook'] ?? null) }}" />
                    <x-input-error for="facebook" class="mt-2" />
                </div>
            </div>
            <div class="w-1/2">
                <x-label for="address" value="{{ __('Address') }}" class="inline" /><x-locale-display />
                {{--<x-textarea name="address" rows="3" class="">{{ old('address', $organization->address ?? null) }}</x-textarea>--}}
                <x-easy-mde name="address">{{ old('address', $organization->address ?? null) }}</x-easy-mde>
                <x-input-error for="address" class="mt-2" />
            </div>
        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-secondary-button class="mr-2"><a href="{{ route('manage.organization.edit') }}">{{ __('Cancel') }}</a></x-secondary-button>
        <x-button>
            {{ __('Submit') }}
        </x-button>
    </div>
</div>
