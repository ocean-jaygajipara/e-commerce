@extends('layouts.storefront')

@section('title', 'Read Insights - VELOX')

@section('content')
<div style="max-width: 800px; margin: 3rem auto;">
    <div style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 1.5rem;">
        <a href="{{ route('home') }}" style="color: inherit; text-decoration: none;">Home</a> /
        <a href="{{ route('blog') }}" style="color: inherit; text-decoration: none;">Blog</a> /
        <span style="color: var(--text-primary); font-weight: 600;">{{ str_replace('-', ' ', $slug) }}</span>
    </div>

    <span style="font-size: 0.85rem; color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">VIP FEATURE ARTICLE</span>
    <h1 style="font-size: 3rem; font-weight: 850; line-height: 1.2; margin-top: 0.5rem; margin-bottom: 1.5rem;">The Architecture of a Minimalist Wardrobe</h1>
    
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 3rem; color: var(--text-secondary); font-size: 0.9rem;">
        <span>By Admin Curator</span>
        <span>•</span>
        <span>August 5, 2026</span>
        <span>•</span>
        <span>5 min read</span>
    </div>

    <!-- Article Header Image -->
    <div style="border-radius: var(--radius-lg); overflow: hidden; height: 400px; margin-bottom: 3rem;">
        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=900&auto=format&fit=crop" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    <div style="font-size: 1.15rem; line-height: 1.8; color: var(--text-primary);">
        <p style="margin-bottom: 1.5rem;">A minimalist wardrobe isn't about restriction; it's about freedom. By choosing objects characterized by visual simplicity, high functionality, and robust physical durability, you curate a daily routine that values distinction over quantity.</p>
        
        <h3 style="font-size: 1.5rem; font-weight: 800; margin: 2rem 0 1rem;">1. Select Colors Strategically</h3>
        <p style="margin-bottom: 1.5rem;">Begin with neutrals: black, off-white, and select muted grey tones. Add an intentional pop of expression, such as a premium sunset orange accent. This allows you to mix and match elements seamlessly without feeling visually repetitive.</p>

        <h3 style="font-size: 1.5rem; font-weight: 800; margin: 2rem 0 1rem;">2. Invest in Material Integrity</h3>
        <p style="margin-bottom: 1.5rem;">A single Italian tanned leather duffle or double-layered combed cotton jersey will outlast half a dozen cheaper substitutes. When building your collection, look for stitching detail, metal zipper quality, and structural layout.</p>
    </div>
</div>
@endsection
