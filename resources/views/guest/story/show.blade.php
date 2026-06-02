@push('styles')
    @vite(['resources/css/grid.css'])
@endpush

<x-guest-layout>
    <div class="container mx-auto flex-grow">
        @include('dissemination::partials.nav')
        <style>
            {!! $story->css !!}
        </style>
        @vite('resources/css/map.css')
        <article class="p-4 rounded-md ring-1 mb-8">
            <x-dissemination::guest-header :content="$story" />
            @if($story->is_filterable)
                <livewire:area-filter />
            @else
                <livewire:i-need-alpine />
            @endif
            @php
                $_blocks = json_decode($story->html, true);
            @endphp

            @if (is_array($_blocks))
                <div class="pt-10 space-y-6">
                    @foreach($_blocks as $_block)
                        @switch($_block['type'] ?? '')
                            @case('text')
                                <div class="prose prose-indigo max-w-none">
                                    {!! $_block['data']['content'] ?? '' !!}
                                </div>
                                @break

                            @case('image')
                                @php
                                    $_align = $_block['data']['alignment'] ?? 'center';
                                    $_wrapperClass = match($_align) {
                                        'left' => 'flex flex-col items-start',
                                        'right' => 'flex flex-col items-end',
                                        'default' => 'flex flex-col items-center',
                                    };
                                    $_captionAlign = match($_align) {
                                        'left' => 'text-left',
                                        'right' => 'text-right',
                                        'full' => '',
                                        default => 'text-center',
                                    };
                                @endphp
                                <figure class="my-6">
                                    <div class="{{ $_wrapperClass }}">
                                        <img src="{{ asset($_block['data']['src'] ?? '') }}" alt="{{ $_block['data']['caption'] ?? '' }}" class="rounded max-w-full{{ $_align === 'full' ? ' w-full' : '' }}" />
                                        @if(!empty($_block['data']['caption']))
                                            <figcaption class="text-sm text-gray-500 mt-2 {{ $_captionAlign }}">{{ $_block['data']['caption'] }}</figcaption>
                                        @endif
                                    </div>
                                </figure>
                                @break

                            @case('two-column')
                                <div class="grid grid-cols-2 gap-4 my-6">
                                    <div>
                                        @foreach($_block['data']['left'] ?? [] as $_child)
                                            @switch($_child['type'] ?? '')
                                                @case('text')
                                                    <div class="prose prose-indigo max-w-none">
                                                        {!! $_child['data']['content'] ?? '' !!}
                                                    </div>
                                                    @break
                                                @case('image')
                                                    @php
                                                        $_childAlign = $_child['data']['alignment'] ?? 'center';
                                                        $_childWrapper = match($_childAlign) {
                                                            'left' => 'flex flex-col items-start',
                                                            'right' => 'flex flex-col items-end',
                                                            'default' => 'flex flex-col items-center',
                                                        };
                                                        $_childCaptionAlign = match($_childAlign) {
                                                            'left' => 'text-left',
                                                            'right' => 'text-right',
                                                            'full' => '',
                                                            default => 'text-center',
                                                        };
                                                    @endphp
                                                    <figure class="my-4">
                                                        <div class="{{ $_childWrapper }}">
                                                            <img src="{{ asset($_child['data']['src'] ?? '') }}" alt="{{ $_child['data']['caption'] ?? '' }}" class="rounded max-w-full{{ $_childAlign === 'full' ? ' w-full' : '' }}" />
                                                            @if(!empty($_child['data']['caption']))
                                                                <figcaption class="text-sm text-gray-500 mt-2 {{ $_childCaptionAlign }}">{{ $_child['data']['caption'] }}</figcaption>
                                                            @endif
                                                        </div>
                                                    </figure>
                                                    @break
                                                @case('visualization')
                                                    @php
                                                        $_viz = \Uneca\DisseminationToolkit\Models\Visualization::find($_child['data']['viz_id'] ?? null);
                                                    @endphp
                                                    @if($_viz)
                                                        @php
                                                            $_vizId = 'viz-' . $_viz->id . uniqid('', true);
                                                            $_init = match($_viz->type) {
                                                                'Chart', 'Scorecard' => "new PlotlyChart('{$_vizId}')",
                                                                'Map' => "new LeafletMap('{$_vizId}')",
                                                                default => "new AgGridTable('{$_vizId}')",
                                                            };
                                                        @endphp
                                                        <div class="{{ $_viz->type }} my-4" id="{{ $_vizId }}" viz-id="{{ $_viz->id }}" type="{{ $_viz->type }}" x-init="{{ $_init }}"></div>
                                                    @endif
                                                    @break
                                        @endswitch
                                    @endforeach
                                </div>
                                <div>
                                    @foreach($_block['data']['right'] ?? [] as $_child)
                                        @switch($_child['type'] ?? '')
                                            @case('text')
                                                <div class="prose prose-indigo max-w-none">
                                                    {!! $_child['data']['content'] ?? '' !!}
                                                </div>
                                                @break
                                            @case('image')
                                                @php
                                                    $_childAlign = $_child['data']['alignment'] ?? 'center';
                                                    $_childWrapper = match($_childAlign) {
                                                        'left' => 'flex flex-col items-start',
                                                        'right' => 'flex flex-col items-end',
                                                        'default' => 'flex flex-col items-center',
                                                    };
                                                    $_childCaptionAlign = match($_childAlign) {
                                                        'left' => 'text-left',
                                                        'right' => 'text-right',
                                                        'full' => '',
                                                        default => 'text-center',
                                                    };
                                                @endphp
                                                <figure class="my-4">
                                                    <div class="{{ $_childWrapper }}">
                                                        <img src="{{ asset($_child['data']['src'] ?? '') }}" alt="{{ $_child['data']['caption'] ?? '' }}" class="rounded max-w-full{{ $_childAlign === 'full' ? ' w-full' : '' }}" />
                                                        @if(!empty($_child['data']['caption']))
                                                            <figcaption class="text-sm text-gray-500 mt-2 {{ $_childCaptionAlign }}">{{ $_child['data']['caption'] }}</figcaption>
                                                        @endif
                                                    </div>
                                                </figure>
                                                @break
                                            @case('visualization')
                                                @php
                                                    $_viz = \Uneca\DisseminationToolkit\Models\Visualization::find($_child['data']['viz_id'] ?? null);
                                                @endphp
                                                @if($_viz)
                                                    @php
                                                        $_vizId = 'viz-' . $_viz->id . uniqid('', true);
                                                        $_init = match($_viz->type) {
                                                            'Chart', 'Scorecard' => "new PlotlyChart('{$_vizId}')",
                                                            'Map' => "new LeafletMap('{$_vizId}')",
                                                            default => "new AgGridTable('{$_vizId}')",
                                                        };
                                                    @endphp
                                                    <div class="{{ $_viz->type }} my-4" id="{{ $_vizId }}" viz-id="{{ $_viz->id }}" type="{{ $_viz->type }}" x-init="{{ $_init }}"></div>
                                                @endif
                                                @break
                                        @endswitch
                                    @endforeach
                                </div>
                                </div>
                                @break

                            @case('visualization')
                                @php
                                    $_viz = \Uneca\DisseminationToolkit\Models\Visualization::find($_block['data']['viz_id'] ?? null);
                                @endphp
                                @if($_viz)
                                    @php
                                        $_vizId = 'viz-' . $_viz->id . uniqid('', true);
                                        $_init = match($_viz->type) {
                                            'Chart', 'Scorecard' => "new PlotlyChart('{$_vizId}')",
                                            'Map' => "new LeafletMap('{$_vizId}')",
                                            default => "new AgGridTable('{$_vizId}')",
                                        };
                                    @endphp
                                    <div class="{{ $_viz->type }} my-6" id="{{ $_vizId }}" viz-id="{{ $_viz->id }}" type="{{ $_viz->type }}" x-init="{{ $_init }}"></div>
                                @endif
                                @break
                        @endswitch
                    @endforeach
                </div>
            @else
                <div class="pt-10">
                    {!! Blade::render($story->html) !!}
                </div>
            @endif
            <x-dissemination-reviews :subject="$story" />
        </article>
    </div>
    <div class="container mx-auto">
        @include('dissemination::partials.footer')
    </div>
    @include('dissemination::partials.footer-end')

</x-guest-layout>
