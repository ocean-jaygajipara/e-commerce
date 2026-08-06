@extends('layouts.storefront')

@section('title', 'Ocean Ecom - Luxury E-Commerce Home')

@section('content')
    <!-- Hero Banner with CTA -->
    <div class="hero-slider">
        <div class="hero-slide" style="background-image: linear-gradient(90deg, rgba(10,10,11,0.9) 0%, rgba(10,10,11,0.4) 100%), url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1400&auto=format&fit=crop');">
            <div class="hero-content">
                <span style="color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem;">SUMMER COLLECTION 2026</span>
                <h1 style="margin-top: 0.5rem;">Aesthetic distinction.</h1>
                <p>Curated minimalist design meets premium quality. Discover new collections of luxury accessories, streetwear, and lifestyle gadgets.</p>
                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('shop') }}" class="btn btn-primary">Shop Collection</a>
                    <a href="{{ route('about') }}" class="btn btn-outline" style="color: white; border-color: white; background: rgba(255,255,255,0.05);">Our Philosophy</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Categories -->
    <div class="category-section">
        <div class="section-title">
            <span>Shop By Categories</span>
            <a href="{{ route('shop') }}">View All Categories &rarr;</a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
            @php
                $dbCategories = \App\Models\Category::all();
            @endphp
            @foreach($dbCategories as $cat)
                <a href="{{ route('category', $cat->slug) }}" style="text-decoration: none; color: inherit;">
                    <div class="glass" style="border-radius: var(--radius-md); padding: 1.5rem; text-align: center; border: 1px solid var(--border-color); transition: var(--transition); cursor: pointer;" onmouseover="this.style.borderColor='var(--primary)';" onmouseout="this.style.borderColor='var(--border-color)';">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">{{ $cat->icon }}</div>
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $cat->name }}</h3>
                        <p style="color: var(--text-secondary); font-size: 0.85rem;">{{ $cat->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Flash Sale Section with Countdown -->
    <div class="flash-sale-wrapper">
        <div class="flash-left">
            <span style="color: var(--primary); font-weight: 700; font-size: 0.9rem; letter-spacing: 2px;">DON'T MISS OUT</span>
            <h2>Limited Edition Flash Sale</h2>
            <p style="opacity: 0.8; max-width: 500px;">Save up to 40% on select high-end watches, premium acoustics, and tailored collections. Only for a short window.</p>
            <div class="countdown-box">
                <div class="countdown-unit">
                    <div id="hours">08</div>
                    <div>Hours</div>
                </div>
                <div class="countdown-unit">
                    <div id="minutes">45</div>
                    <div>Mins</div>
                </div>
                <div class="countdown-unit">
                    <div id="seconds">30</div>
                    <div>Secs</div>
                </div>
            </div>
        </div>
        <div class="flash-right">
            <a href="{{ route('offers') }}" class="btn btn-primary" style="background: white; color: black; font-weight: 700; padding: 1rem 2.5rem;">Explore Flash Deals</a>
        </div>
    </div>

    <!-- Featured collections & Promotional banners -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 4rem;">
        <div style="border-radius: var(--radius-lg); overflow: hidden; height: 350px; background-image: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.8) 100%), url('https://images.unsplash.com/photo-1556906781-9a412961c28c?w=700&auto=format&fit=crop'); background-size: cover; background-position: center; display: flex; flex-direction: column; justify-content: flex-end; padding: 2.5rem; color: white;">
            <span style="font-weight: 700; color: var(--primary); font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase;">AURA ACCENTS</span>
            <h3 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem;">Modern Leather Bags</h3>
            <p style="opacity: 0.9; margin-bottom: 1rem; font-size: 0.95rem;">Premium Italian tanned duffles, backpacks, and cases.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary" style="width: fit-content; padding: 0.6rem 1.5rem; font-size: 0.85rem;">Discover Collection</a>
        </div>
        <div style="border-radius: var(--radius-lg); overflow: hidden; height: 350px; background-image: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.8) 100%), url('https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=700&auto=format&fit=crop'); background-size: cover; background-position: center; display: flex; flex-direction: column; justify-content: flex-end; padding: 2.5rem; color: white;">
            <span style="font-weight: 700; color: var(--primary); font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase;">FIT & SOUND</span>
            <h3 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem;">Active Lifestyle Wear</h3>
            <p style="opacity: 0.9; margin-bottom: 1rem; font-size: 0.95rem;">Experience high-grade acoustics with sweat-proof sport audio.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary" style="width: fit-content; padding: 0.6rem 1.5rem; font-size: 0.85rem;">Discover Collection</a>
        </div>
    </div>

    <!-- Trending products & Best sellers -->
    <div class="category-section">
        <div class="section-title">
            <span>Trending Products</span>
            <div style="display: flex; gap: 0.5rem;">
                <button class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem; background: var(--dark-grey); color: var(--white);">New Arrivals</button>
                <button class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Best Sellers</button>
            </div>
        </div>
        <div class="grid-container">
            @php
                $dbProducts = \App\Models\Product::orderBy('created_at', 'desc')->get();
            @endphp
            @foreach($dbProducts as $item)
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
                        <div class="product-rating">
                            ★★★★★ <span>({{ $item->reviews_count }})</span>
                        </div>
                        <div class="product-footer">
                            <span class="product-price">₹{{ number_format($item->price, 2) }}</span>
                            <button class="add-to-cart-btn" onclick="addToCart({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->price }}, '{{ $item->img }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Top Brands -->
    <div class="category-section">
        <div class="section-title">
            <span>Premium Partners</span>
            <a href="{{ route('brand') }}">All Brands &rarr;</a>
        </div>
        <div class="brand-grid">
            <a href="{{ route('brand') }}" class="brand-card" style="text-decoration:none;" title="Nike">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:55px; height:55px; color: var(--text-primary);"><path d="M21 6.5c-2.3 1.8-6.9 5.3-11.2 8.7-2.2 1.8-4.4 3.7-6.2 5.5-.3.3-.6.1-.5-.2.9-2.3 3.9-7.7 8.3-11.7C15 5.5 19 4.3 20.8 4.5c.3 0 .4.2.2.4z"/></svg>
            </a>
            <a href="{{ route('brand') }}" class="brand-card" style="text-decoration:none;" title="Zara">
                <span style="font-family:'Times New Roman', serif; font-size:2rem; letter-spacing:6px; font-weight:bold; color:var(--text-primary);">ZARA</span>
            </a>
            <a href="{{ route('brand') }}" class="brand-card" style="text-decoration:none;" title="Apple">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:34px; height:34px; color: var(--text-primary);"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 4.17c.66-.81 1.11-1.93.99-3.06-1 .04-2.2.67-2.92 1.5-.62.71-1.16 1.86-1.02 2.97 1.11.09 2.25-.57 2.95-1.41z"/></svg>
            </a>
            <a href="{{ route('brand') }}" class="brand-card" style="text-decoration:none;" title="Chrono Lab">
                <div style="display:flex; align-items:center; gap:0.5rem; color:var(--text-primary);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:28px; height:28px;"><circle cx="12" cy="12" r="9"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span style="font-size:0.95rem; font-weight:800; letter-spacing:1px;">CHRONO</span>
                </div>
            </a>
            <a href="{{ route('brand') }}" class="brand-card" style="text-decoration:none;" title="Sony">
                <span style="font-family:'Courier New', monospace; font-size:1.8rem; font-weight:bold; letter-spacing:1px; color:var(--text-primary);">SONY</span>
            </a>
            <a href="{{ route('brand') }}" class="brand-card" style="text-decoration:none;" title="Bounty Luxury">
                <div style="display:flex; align-items:center; gap:0.5rem; color:var(--text-primary);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:28px; height:28px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span style="font-size:0.95rem; font-weight:800; letter-spacing:1px;">BOUNTY</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Customer Testimonials -->
    <div class="category-section">
        <div class="section-title">
            <span>Customer Testimonials</span>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px solid var(--border-color);">
                <div style="font-size: 1.5rem; color: var(--primary); margin-bottom: 1rem;">★★★★★</div>
                <p style="font-size: 0.95rem; font-style: italic; line-height: 1.6; color: var(--text-primary); margin-bottom: 1.5rem;">"The attention to detail and packaging was stunning. Truly feels like a luxury experience, and delivery was exceptionally fast."</p>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #ddd; overflow:hidden;"><img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
                    <div>
                        <h4 style="font-size: 0.95rem; font-weight: 700;">Eleanor Vance</h4>
                        <span style="font-size: 0.8rem; color: var(--text-secondary);">Verified Buyer</span>
                    </div>
                </div>
            </div>
            <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px solid var(--border-color);">
                <div style="font-size: 1.5rem; color: var(--primary); margin-bottom: 1rem;">★★★★★</div>
                <p style="font-size: 0.95rem; font-style: italic; line-height: 1.6; color: var(--text-primary); margin-bottom: 1.5rem;">"Outstanding client service. Had a sizing query and got a live response in 2 mins. The leather backpack feels incredibly premium."</p>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #ddd; overflow:hidden;"><img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
                    <div>
                        <h4 style="font-size: 0.95rem; font-weight: 700;">Julian Sterling</h4>
                        <span style="font-size: 0.8rem; color: var(--text-secondary);">Collector</span>
                    </div>
                </div>
            </div>
            <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px solid var(--border-color);">
                <div style="font-size: 1.5rem; color: var(--primary); margin-bottom: 1rem;">★★★★★</div>
                <p style="font-size: 0.95rem; font-style: italic; line-height: 1.6; color: var(--text-primary); margin-bottom: 1.5rem;">"The smart watch has changed my day-to-day productivity. Elegant, simple, clean. Battery lasts nearly 6 days."</p>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #ddd; overflow:hidden;"><img src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=100&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
                    <div>
                        <h4 style="font-size: 0.95rem; font-weight: 700;">Marcus Brody</h4>
                        <span style="font-size: 0.8rem; color: var(--text-secondary);">Aesthetic Architect</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Section -->
    <div class="category-section" style="margin-bottom: 5rem;">
        <div class="section-title">
            <span>Aesthetic Insights</span>
            <a href="{{ route('blog') }}">Read Blog &rarr;</a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            <div style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color);">
                <div style="height: 200px; overflow: hidden;"><img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
                <div style="padding: 1.5rem;">
                    <span style="font-size: 0.8rem; color: var(--primary); font-weight: 700;">CULTURE</span>
                    <h3 style="font-size: 1.2rem; font-weight: 700; margin: 0.5rem 0;"><a href="{{ route('blog.details', 'minimalist-wardrobe') }}" style="color:inherit; text-decoration:none;">The Architecture of a Minimalist Wardrobe</a></h3>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5;">How to downsize your wardrobe without losing elegance or personality.</p>
                </div>
            </div>
            <div style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color);">
                <div style="height: 200px; overflow: hidden;"><img src="https://images.unsplash.com/photo-1479064555552-3ef4979f8908?w=400&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
                <div style="padding: 1.5rem;">
                    <span style="font-size: 0.8rem; color: var(--primary); font-weight: 700;">DESIGN</span>
                    <h3 style="font-size: 1.2rem; font-weight: 700; margin: 0.5rem 0;"><a href="{{ route('blog.details', 'luxury-acoustics') }}" style="color:inherit; text-decoration:none;">Why Luxury Acoustics Redefine Interior Beauty</a></h3>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5;">Integrating sound design into clean contemporary space setups.</p>
                </div>
            </div>
            <div style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color);">
                <div style="height: 200px; overflow: hidden;"><img src="https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=400&auto=format&fit=crop" style="width:100%; height:100%; object-fit:cover;"></div>
                <div style="padding: 1.5rem;">
                    <span style="font-size: 0.8rem; color: var(--primary); font-weight: 700;">HOROLOGY</span>
                    <h3 style="font-size: 1.2rem; font-weight: 700; margin: 0.5rem 0;"><a href="{{ route('blog.details', 'smartwatch-horology') }}" style="color:inherit; text-decoration:none;">The Fine Line Between Tech & Fine Watchmaking</a></h3>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5;">Discover how modern chronometers capture watchmaking heritage.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
