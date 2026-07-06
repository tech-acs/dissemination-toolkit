<nav class="pb-4 border-b">
    <ol role="list" class="space-y-4 md:flex md:space-x-8 md:space-y-0">
        @foreach( $steps as $index => $label )
            <li class="md:flex-1">
                <div class="{{ $index <= $currentStep ? 'border-indigo-600 text-indigo-600' : 'border-gray-200 text-gray-400' }} group flex flex-col border-l-4 py-2 pl-4 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4">
                    <span>
                        <span class="font-medium border-r border-gray-300 p-1 pr-2 mr-2 fill-current">{{ $loop->iteration }}</span> {{ $label }}
                        @if( $index < $currentStep )
                            {{-- Checkmark --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 " viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <path d="M5 12l5 5l10 -10"></path>
                            </svg>
                        @endif
                    </span>
                </div>
            </li>
        @endforeach
    </ol>
</nav>
