@props(['messages'])
@if ($messages)
    <p {{ $attributes->merge(['class' => 'form-error']) }}>
        {{ (is_array($messages) ? ($messages[0] ?? '') : $messages) }}
    </p>
@endif
