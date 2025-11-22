@props(['image', 'title', 'description'])

<div class="card">
    <div class="card-image">
        <img src="{{ $image }}" alt="{{ $title }}">
    </div>
    <div class="card-content">
        <h3 class="card-title">{{ $title }}</h3>
        <p class="card-description">{{ $description }}</p>
    </div>
</div>