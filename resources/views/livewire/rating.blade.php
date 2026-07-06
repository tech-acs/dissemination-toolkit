<div class="flex flex-col justify-end" x-data="{ hoveredRating: @entangle($hoveredRating) }">
    @auth
        @if(!$ratingModel->rated)
            <div class="mt-1 flex justify-end">
                <div class="flex flex-auto gap-1">
                    @foreach($possibleRatings as $index => $rating)
                        <div wire:key="{{ $rating['value'] }}"
                             wire:click="saveRating({{ $rating['value'] }})"
                             x-on:mouseover="hoveredRating = {{ $index }}"
                             x-on:mouseout="hoveredRating = -1"
                             class="h-6 cursor-pointer basis-1/6 {{ $rating['isSelected'] ? 'bg-indigo-600' : 'bg-gray-200' }} flex justify-center"
                             :class="{'bg-indigo-500': hoveredRating >= {{ $index}} }">
                            <span class="text-white">{{$index + 1}}</span>
                        </div>
                    @endforeach
                    <div class="h-6 basis-1/6 flex items-center">
                        <p class="text-xs font-medium text-indigo-600">
                            {{$selectedRate}}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        @if($ratingModel->rated)
            <div class="flex justify-end">
                <div class="flex flex-auto gap-1">
                    @foreach($possibleRatings as $index => $rating)
                        <div
                            class="basis-1/6 {{ $rating['isSelected'] ? 'bg-indigo-600 drop-shadow-lg' : 'bg-indigo-200 shadow-inner' }} flex justify-center">
                            <span class="text-white">{{$index + 1}}</span>
                        </div>
                    @endforeach
                    <div class="h-6 basis-1/6 flex items-center">
                        <p class="text-xs font-medium text-gray-500">
                            {{$selectedRate}}
                        </p>
                    </div>
                </div>
            </div>
        @endif

    @endauth
</div>

