@extends('layouts.storefront')

@section('title', 'Aesthetic Insights Blog - VELOX')

@section('content')
<div style="margin-top: 2rem;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 1rem; text-align: center;">Velox Insights Blog</h1>
    <p style="color: var(--text-secondary); text-align: center; max-width: 600px; margin: 0 auto 3rem; line-height: 1.5;">Delve into minimalist design principles, lifestyle architectures, and the heritage of fine accessories design.</p>

    <!-- Articles Grid -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2.5rem; margin-bottom: 5rem;">
        <div style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color); display: flex; flex-direction: column; background: var(--white);">
            <div style="height: 220px; overflow: hidden;"><img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
            <div style="padding: 1.75rem; display: flex; flex-direction: column; flex-grow: 1;">
                <span style="font-size: 0.8rem; color: var(--primary); font-weight: 700; text-transform: uppercase;">CULTURE</span>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0.5rem 0;"><a href="{{ route('blog.details', 'minimalist-wardrobe') }}" style="color:inherit; text-decoration:none;">The Architecture of a Minimalist Wardrobe</a></h3>
                <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5; margin-bottom: 1.5rem;">How to downsize your wardrobe without losing elegance or personality.</p>
                <a href="{{ route('blog.details', 'minimalist-wardrobe') }}" style="margin-top: auto; color: var(--primary); text-decoration: none; font-weight: 700; font-size: 0.9rem;">Read Article &rarr;</a>
            </div>
        </div>

        <div style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color); display: flex; flex-direction: column; background: var(--white);">
            <div style="height: 220px; overflow: hidden;"><img src="https://images.unsplash.com/photo-1479064555552-3ef4979f8908?w=400&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
            <div style="padding: 1.75rem; display: flex; flex-direction: column; flex-grow: 1;">
                <span style="font-size: 0.8rem; color: var(--primary); font-weight: 700; text-transform: uppercase;">DESIGN</span>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0.5rem 0;"><a href="{{ route('blog.details', 'luxury-acoustics') }}" style="color:inherit; text-decoration:none;">Why Luxury Acoustics Redefine Interior Beauty</a></h3>
                <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5; margin-bottom: 1.5rem;">Integrating sound design into clean contemporary space setups.</p>
                <a href="{{ route('blog.details', 'luxury-acoustics') }}" style="margin-top: auto; color: var(--primary); text-decoration: none; font-weight: 700; font-size: 0.9rem;">Read Article &rarr;</a>
            </div>
        </div>

        <div style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color); display: flex; flex-direction: column; background: var(--white);">
            <div style="height: 220px; overflow: hidden;"><img src="https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=400&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
            <div style="padding: 1.75rem; display: flex; flex-direction: column; flex-grow: 1;">
                <span style="font-size: 0.8rem; color: var(--primary); font-weight: 700; text-transform: uppercase;">HOROLOGY</span>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0.5rem 0;"><a href="{{ route('blog.details', 'smartwatch-horology') }}" style="color:inherit; text-decoration:none;">The Fine Line Between Tech & Fine Watchmaking</a></h3>
                <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5; margin-bottom: 1.5rem;">Discover how modern chronometers capture watchmaking heritage.</p>
                <a href="{{ route('blog.details', 'smartwatch-horology') }}" style="margin-top: auto; color: var(--primary); text-decoration: none; font-weight: 700; font-size: 0.9rem;">Read Article &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endsection
