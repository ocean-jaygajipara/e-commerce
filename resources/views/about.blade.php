@extends('layouts.storefront')

@section('title', 'Our Story - VELOX')

@section('content')
<div style="margin-top: 2rem;">
    <!-- Headline Section -->
    <div style="text-align: center; max-width: 700px; margin: 0 auto 5rem;">
        <span style="font-weight: 700; color: var(--primary); font-size: 0.85rem; letter-spacing: 2px; text-transform: uppercase;">EST. 2026</span>
        <h1 style="font-size: 3rem; font-weight: 850; margin-top: 0.5rem; margin-bottom: 1.5rem;">Curation of Luxury Aesthetics</h1>
        <p style="color: var(--text-secondary); font-size: 1.1rem; line-height: 1.6;">Velox was founded to address a clear gap in modern e-commerce: the synergy between pure minimalist design, uncompromising technical material selection, and modern digital ease.</p>
    </div>

    <!-- Image + Story grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-bottom: 5rem;">
        <div style="border-radius: var(--radius-lg); overflow: hidden; height: 400px;">
            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&auto=format&fit=crop" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div>
            <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1.5rem;">Our Mission & Vision</h2>
            <div style="display: flex; flex-direction: column; gap: 1.5rem; color: var(--text-secondary); line-height: 1.6;">
                <p><strong>Mission:</strong> To empower clients worldwide to elevate their day-to-day lifestyle by presenting meticulously designed physical assets that provide absolute durability and aesthetic distinction.</p>
                <p><strong>Vision:</strong> To serve as the premier global destination for luxury minimalist design, continually pushing the boundaries of styling details and client satisfaction.</p>
            </div>
        </div>
    </div>

    <!-- Team Grid -->
    <div style="margin-bottom: 5rem;">
        <h2 style="font-size: 2rem; font-weight: 800; text-align: center; margin-bottom: 3rem;">Creative Leadership</h2>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2.5rem;">
            <div style="text-align: center;">
                <div style="width: 180px; height: 180px; border-radius: 50%; overflow: hidden; margin: 0 auto 1.5rem;"><img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
                <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.25rem;">Aria Sterling</h4>
                <span style="color: var(--primary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Co-Founder & Chief Designer</span>
            </div>
            <div style="text-align: center;">
                <div style="width: 180px; height: 180px; border-radius: 50%; overflow: hidden; margin: 0 auto 1.5rem;"><img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
                <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.25rem;">Julian Sterling</h4>
                <span style="color: var(--primary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Co-Founder & Operations</span>
            </div>
            <div style="text-align: center;">
                <div style="width: 180px; height: 180px; border-radius: 50%; overflow: hidden; margin: 0 auto 1.5rem;"><img src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=300&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
                <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.25rem;">Marcus Brody</h4>
                <span style="color: var(--primary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Head Horology Curator</span>
            </div>
        </div>
    </div>
</div>
@endsection
