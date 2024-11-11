<a href="/">
    <img class="h-32" title="{{ $org?->name }}" alt="{{ $org?->name }}" src="{{ asset(empty($org?->logo_path) ? 'images/placeholder-logo.png' : $org->logo_path) }}">
</a>
