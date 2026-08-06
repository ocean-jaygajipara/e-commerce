@extends('layouts.storefront')

@section('title', 'Featured Brands - Ocean Ecom')

@section('content')
<div style="margin-top: 2rem;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 1rem; text-align: center;">Our Partner Brands</h1>
    <p style="color: var(--text-secondary); text-align: center; max-width: 600px; margin: 0 auto 3rem; line-height: 1.5;">We collaborate with visionary designers and world-renowned manufacturers to bring you aesthetic perfection.</p>

    <!-- Brand Grid Showcase -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2.5rem; margin-bottom: 4rem;">
        <!-- Brand 1: Nike Active -->
        <div class="glass" style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color); display: flex; flex-direction: column;">
            <div style="height: 200px; overflow: hidden; position: relative; background: var(--light-grey);">
                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=450&auto=format&fit=crop" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9; transition: var(--transition);" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
            <div style="padding: 2rem; text-align: center; flex-grow: 1; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 50px; height: 50px; color: var(--text-primary); margin-bottom: 1rem;"><path d="M21 6.5c-2.3 1.8-6.9 5.3-11.2 8.7-2.2 1.8-4.4 3.7-6.2 5.5-.3.3-.6.1-.5-.2.9-2.3 3.9-7.7 8.3-11.7C15 5.5 19 4.3 20.8 4.5c.3 0 .4.2.2.4z"/></svg>
                <h3 style="font-weight: 800; font-size: 1.5rem; color: var(--text-primary); margin-bottom: 0.75rem;">NIKE ACTIVE</h3>
                <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.5;">Engineering modern athletic footwear and high-performance garments.</p>
                <a href="{{ route('shop') }}" class="btn btn-outline" style="font-size: 0.85rem; width: 100%; margin-top: auto;">View Brand Products</a>
            </div>
        </div>

        <!-- Brand 2: Chrono Lab -->
        <div class="glass" style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color); display: flex; flex-direction: column;">
            <div style="height: 200px; overflow: hidden; position: relative; background: var(--light-grey);">
                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=450&auto=format&fit=crop" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9; transition: var(--transition);" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
            <div style="padding: 2rem; text-align: center; flex-grow: 1; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-primary); margin-bottom: 1.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 28px; height: 28px;"><circle cx="12" cy="12" r="9"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span style="font-size: 1.1rem; font-weight: 800; letter-spacing: 1px;">CHRONO</span>
                </div>
                <h3 style="font-weight: 800; font-size: 1.5rem; color: var(--text-primary); margin-bottom: 0.75rem;">CHRONO LAB</h3>
                <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.5;">Fine horological complications combined with state of the art smartwatch intelligence.</p>
                <a href="{{ route('shop') }}" class="btn btn-outline" style="font-size: 0.85rem; width: 100%; margin-top: auto;">View Brand Products</a>
            </div>
        </div>

        <!-- Brand 3: Zara Couture -->
        <div class="glass" style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color); display: flex; flex-direction: column;">
            <div style="height: 200px; overflow: hidden; position: relative; background: var(--light-grey);">
                <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?w=450&auto=format&fit=crop" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9; transition: var(--transition);" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
            <div style="padding: 2rem; text-align: center; flex-grow: 1; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <span style="font-family:'Times New Roman', serif; font-size: 1.75rem; letter-spacing: 6px; font-weight: bold; color: var(--text-primary); margin-bottom: 1.25rem; margin-top: 0.25rem; display: block;">ZARA</span>
                <h3 style="font-weight: 800; font-size: 1.5rem; color: var(--text-primary); margin-bottom: 0.75rem;">ZARA COUTURE</h3>
                <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.5;">Premium tailored fabrics, modern outlines, and minimalist fashion statement pieces.</p>
                <a href="{{ route('shop') }}" class="btn btn-outline" style="font-size: 0.85rem; width: 100%; margin-top: auto;">View Brand Products</a>
            </div>
        </div>
    </div>
</div>
@endsection
