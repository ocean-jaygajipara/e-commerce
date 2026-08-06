@extends('layouts.storefront')

@section('title', 'Page Not Found - VELOX')

@section('content')
<div style="text-align: center; padding: 6rem 0; max-width: 600px; margin: 0 auto;">
    <span style="font-size: 8rem; font-weight: 800; color: var(--primary); line-height: 1; display: block; margin-bottom: 1rem;">404</span>
    <h1 style="font-size: 2.25rem; font-weight: 850; margin-bottom: 1rem;">Lost in Luxury</h1>
    <p style="color: var(--text-secondary); line-height: 1.6; margin-bottom: 2.5rem;">The showcase collection page or product detail you are looking for has been moved or archived.</p>
    
    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="{{ route('home') }}" class="btn btn-primary">Return Home</a>
        <a href="{{ route('shop') }}" class="btn btn-outline">Explore Shop</a>
    </div>
</div>
@endsection
