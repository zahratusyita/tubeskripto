@props(['eyebrow', 'title', 'description' => null])

<div class="admin-page-header animate-fade-in-up">
    <div>
        <p class="admin-eyebrow">{{ $eyebrow }}</p>
        <h1 class="admin-title">{{ $title }}</h1>
        @if ($description)
            <p class="admin-description">{{ $description }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="admin-header-actions">
            {{ $actions }}
        </div>
    @endisset
</div>
