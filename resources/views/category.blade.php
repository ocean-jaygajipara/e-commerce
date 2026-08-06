@extends('layouts.storefront')

@php
    $cat = \App\Models\Category::where('slug', $slug)->first();
    $catProducts = $cat ? $cat->products : \App\Models\Product::all();
@endphp

@section('title')
    {{ $cat ? $cat->name : 'Category' }} - VELOX
@endsection

@section('content')
<div style="margin-top: 2rem;">
    <!-- Category Hero Banner -->
    <div style="border-radius: var(--radius-lg); height: 260px; background: linear-gradient(135deg, #16161A 0%, #FF6B00 100%); display: flex; flex-direction: column; justify-content: center; padding: 3rem; color: white; margin-bottom: 3rem;">
        <span style="font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 2px;">COLLECTIONS</span>
        <h1 style="font-size: 2.5rem; font-weight: 850; margin-top: 0.5rem; text-transform: uppercase;">{{ $cat ? $cat->name : str_replace('-', ' ', $slug) }}</h1>
        <p style="opacity: 0.8; margin-top: 0.5rem; max-width: 600px;">{{ $cat ? $cat->description : 'Explore premium creations chosen specifically for modern, luxury-centered aesthetics.' }}</p>
    </div>

    <!-- Category Products Grid -->
    <div class="grid-container">
        @if($catProducts->isEmpty())
            <div style="grid-column: span 3; text-align: center; padding: 4rem 0; color: var(--text-secondary);">
                No products are currently available in this category.
            </div>
        @else
            @foreach($catProducts as $item)
                <div class="product-card">
                    <div class="product-img-wrapper">
                        <button class="product-wishlist-btn" onclick="toggleWishlist({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->price }}, '{{ $item->img }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                        </button>
                        <a href="{{ route('product.details', $item->slug) }}">
                            <img src="{{ $item->img }}" alt="{{ $item->name }}">
                        </a>
                    </div>
                    <div class="product-info">
                        <span class="product-brand">{{ $item->brand }}</span>
                        <a href="{{ route('product.details', $item->slug) }}" class="product-title">{{ $item->name }}</a>
                        <div class="product-footer">
                            <span class="product-price">₹{{ number_format($item->price, 2) }}</span>
                            <button class="add-to-cart-btn" onclick="addToCart({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->price }}, '{{ $item->img }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
