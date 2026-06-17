@props(['for'])
@if ($errors->has($for))
    <span {{ $attributes }}>{{ $errors->first($for) }}</span>
@endif
