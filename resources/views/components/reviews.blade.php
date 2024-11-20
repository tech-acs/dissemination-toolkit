@if( $subject->is_reviewable )
    <div x-data="{open: false}" x-cloak class="border-t py-6">

        <div x-show="! open" x-on:click="open = !open" class="flex justify-center">
            <div class="text-center space-y-3">
                <p class="text-sm">{{ __('Share your thoughts with other users and read theirs') }}</p>
                <button type="button" class="rounded-full bg-white px-3.5 py-2 text-base font-medium text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    {{ __('Show') }}
                </button>
            </div>
        </div>

        <div x-show="open" class="grid grid-cols-4 gap-x-16 px-4">

            <!-- Reviews -->
            <div class="col-span-2">
                <h3 class="text-2xl font-bold mb-6">{{ __('User reviews') }}</h3>

                <div class="pt-4">
                    @foreach($reviews ?? [] as $review)

                        <article>
                            <div class="flex items-center mb-4">
                                <div class="font-medium dark:text-white">
                                    <p>
                                        <span class="text-lg">{{ $review->reviewer->name }}</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400">Joined on {{ $review->reviewer->joined_on }}</span>
                                    </p>
                                </div>
                            </div>

                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $review->headline }}</h3>
                            <div class="flex justify-between">
                                <x-dissemination::rating-star-display :rating="$review->rating" />
                                <div class="mb-5 text-sm text-gray-500 dark:text-gray-400"><p>{{ __("Reviewed on") }} {{ $review->reviewed_on }}</p></div>
                            </div>
                            <div class="text-sm mb-2">
                                {!! str($review->detailed_review)->markdown() !!}
                            </div>
                            {{--<a href="#" class="block mb-5 text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Read more</a>--}}
                        </article>

                    @endforeach
                </div>
            </div>

            <!-- Review Form -->
            <div class="col-span-2">
                <h3 class="text-2xl font-bold">{{ __("Write a review") }}</h3>
                @auth
                    <livewire:review-form :subject="$subject"/>

                @elseguest
                    <p class="py-8">{{ __('Share your thoughts with other users') }}</p>
                    <div>
                        <a href="{{ route('login') }}" class="flex w-1/2 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign-in to review</a>
                    </div>
                @endauth

            </div>

        </div>
    </div>
@endif
