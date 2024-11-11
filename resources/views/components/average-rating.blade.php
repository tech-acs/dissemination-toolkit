@props([
    'averageRating' => 0
    ])

<div x-data="{ averageRating: {{ $averageRating }}, totalRating: {{ \App\Enums\RatingEnum::getTotalRating() }}, ratingColor: '{{ \App\Enums\RatingEnum::getRatingColor($averageRating) }}' }"
     x-cloak class="ml-4 border-l border-gray-300 ">
    <div class="flex justify-start gap-1 max-w-sm">
        <div class="w-full h-4 inline-flex justify-end">
            <span class="flex-shrink-0">{{__('Average rating:')}}</span>
        </div>
        <div class="w-full h-4">
            <div class="flex gap-1 justify-start">
                <template x-for="i in totalRating">
                    <div class="h-4 flex-1"
                         :class="{ [ratingColor]: i <= averageRating, 'bg-gray-200': i > averageRating }"></div>
                </template>
            </div>
        </div>
        <div  class="h-4 text-xs px-1 w-full">
            {{ \App\Enums\RatingEnum::getRatingLabel($averageRating) }}
        </div>
    </div>

</div>
