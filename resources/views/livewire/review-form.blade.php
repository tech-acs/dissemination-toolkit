<div x-cloak x-data="rater()" class="relative">
    <div x-show="reviewed" class="absolute bg-gray-50/50 w-full h-full"></div>
    <div class="flex justify-between pt-8">
        <label class="text-lg">Your overall rating</label>
        <div class="flex items-center mb-1 text-gray-50 stroke-stone-500 cursor-pointer space-x-1 rtl:space-x-reverse" x-ref="starBag" @mouseleave="if (! rated) position = 0">
            <svg class="size-5" :class="position >= 1 ? 'text-amber-400' : ''" data-index="1" x-ref="star-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="size-5" :class="position >= 2 ? 'text-amber-400' : ''" data-index="2" x-ref="star-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="size-5" :class="position >= 3 ? 'text-amber-400' : ''" data-index="3" x-ref="star-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="size-5" :class="position >= 4 ? 'text-amber-400' : ''" data-index="4" x-ref="star-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
            <svg class="size-5" :class="position >= 5 ? 'text-amber-400' : ''" data-index="5" x-ref="star-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
        </div>

    </div>
    <x-input-error for="rating" class="mt-2" />
    <form wire:submit="rate" class="pt-6">
        <div class="space-y-4">
            <div>
                <input name="headline" wire:model="headline" placeholder="Your review headline" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <x-input-error for="headline" class="mt-2" />
            </div>
            <div>
                {{--<x-easy-mde name="detailedReview" wire:model="detailedReview" placeholder="Your detailed review"></x-easy-mde>--}}
                <textarea name="detailedReview" wire:model="detailedReview" rows="6" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                <x-input-error for="detailedReview" class="mt-2" />
            </div>
            <div>
                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit review</button>
            </div>
        </div>
        <div class="text-xs text-gray-500 pt-4 flex justify-end">
            We will notify you as soon as your review is processed.
        </div>
    </form>

    <script>
        function rater() {
            return {
                reviewed: @json($alreadyReviewed),
                rated: false,
                position: 0,
                init() {
                    this.$refs.starBag.addEventListener('mouseover', (event) => {
                        if (! this.rated && event.target.tagName === 'svg') {
                            this.position = event.target.dataset['index'];
                        }
                    });
                    this.$refs.starBag.addEventListener('click', (event) => {
                        if (['path', 'svg'].includes(event.target.tagName)) {
                            this.rated = true
                            //this.$refs.rating.value = this.position
                            this.$wire.rating = this.position
                        }
                    });
                },
            }
        }
    </script>
</div>
