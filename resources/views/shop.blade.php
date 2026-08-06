@extends('layouts.storefront')

@section('title', 'Shop Premium - VELOX')

@section('content')
<div style="display: flex; gap: 2.5rem; margin-top: 2rem;">
    <!-- Sidebar Filters -->
    <aside style="width: 300px; flex-shrink: 0;">
        <div class="glass" style="border-radius: var(--radius-md); padding: 1.75rem; border: 1px solid var(--border-color);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.2rem; font-weight: 700;">Filters</h3>
                <a href="javascript:void(0)" onclick="resetAllFilters()" style="font-size: 0.85rem; color: var(--primary); text-decoration: none; font-weight: 700;">Clear All</a>
            </div>

            <!-- Categories Filter -->
            <div style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.25rem;">
                <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 0.75rem;">Categories</h4>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    @foreach(\App\Models\Category::all() as $cat)
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                            <input type="checkbox" style="accent-color: var(--primary);"> {{ $cat->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Brand Filter -->
            <div style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.25rem;">
                <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 0.75rem;">Brands</h4>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" style="accent-color: var(--primary);"> Apple
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" style="accent-color: var(--primary);"> Zara
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" style="accent-color: var(--primary);"> Chrono Lab
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" style="accent-color: var(--primary);"> Nike
                    </label>
                </div>
            </div>

            <!-- Price Filter Slider -->
            <div style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.25rem;">
                <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 0.75rem;">Price Range</h4>
                <input id="price-slider" type="range" min="100" max="100000" value="100000" style="width: 100%; accent-color: var(--primary); cursor: pointer;" oninput="document.getElementById('price-val').innerText = '₹' + this.value">
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-secondary); margin-top: 0.5rem; margin-bottom: 0.75rem;">
                    <span>Min: ₹100</span>
                    <span id="price-val" style="font-weight: 700; color: var(--text-primary);">₹100000</span>
                    <span>Max: ₹1,00,000</span>
                </div>
                <button type="button" onclick="applyPriceFilter()" class="btn btn-primary" style="width: 100%; padding: 0.5rem 1.25rem; font-size: 0.85rem; font-weight: 700; border-radius: var(--radius-sm); cursor: pointer;">Apply Filter</button>
            </div>

            <!-- Rating Filter -->
            <div style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.25rem;">
                <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 0.75rem;">Rating</h4>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="radio" name="rating-filter" style="accent-color: var(--primary);"> 5 Stars (★★★★★)
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="radio" name="rating-filter" style="accent-color: var(--primary);"> 4 Stars & Up (★★★★☆)
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="radio" name="rating-filter" style="accent-color: var(--primary);"> 3 Stars & Up (★★★☆☆)
                    </label>
                </div>
            </div>

            <!-- Color Filter -->
            <div style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.25rem;">
                <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 0.75rem;">Color</h4>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #000; border: 2px solid var(--primary); cursor: pointer; position: relative;"></div>
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #fff; border: 1px solid var(--border-color); cursor: pointer;"></div>
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #FF6B00; cursor: pointer;"></div>
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #1D4ED8; cursor: pointer;"></div>
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #15803D; cursor: pointer;"></div>
                </div>
            </div>

            <!-- Size Filter -->
            <div>
                <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 0.75rem;">Size</h4>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <span style="border: 1px solid var(--border-color); padding: 0.4rem 0.8rem; border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 600; cursor: pointer;">S</span>
                    <span style="border: 1px solid var(--text-primary); padding: 0.4rem 0.8rem; border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 600; cursor: pointer; background: var(--text-primary); color: var(--white);">M</span>
                    <span style="border: 1px solid var(--border-color); padding: 0.4rem 0.8rem; border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 600; cursor: pointer;">L</span>
                    <span style="border: 1px solid var(--border-color); padding: 0.4rem 0.8rem; border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 600; cursor: pointer;">XL</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Products Content Grid Area -->
    <div style="flex-grow: 1;">
        <!-- Top controls (Grid/List View, Sorting, Count) -->
        <div class="glass" style="border-radius: var(--radius-md); padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid var(--border-color); margin-bottom: 2rem;">
            <div id="shop-results-counter" style="font-size: 0.95rem; color: var(--text-secondary);">Showing 1–8 of 24 premium products</div>
            
            <div style="display: flex; gap: 1.5rem; align-items: center;">


                <!-- Sorting Dropdown -->
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 0.9rem; color: var(--text-secondary);">Sort By:</span>
                    <select style="padding: 0.5rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--white); color: var(--text-primary); font-size: 0.9rem; outline: none; cursor: pointer;">
                        <option>Featured</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest arrivals</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid Container -->
        <div style="position: relative;">
            <div id="shop-loader" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; min-height: 300px; background: rgba(255,255,255,0.7); z-index: 100; justify-content: center; align-items: center; border-radius: var(--radius-md);">
                <div style="width: 45px; height: 45px; border: 4px solid var(--border-color); border-top: 4px solid var(--primary); border-radius: 50%; animation: spin 1s linear infinite;"></div>
            </div>
            <style>
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style>
            <div id="shop-product-grid" class="grid-container">
                <!-- Mock Product Cards -->
                @php
                    $dbProducts = \App\Models\Product::orderBy('created_at', 'desc')->get();
                @endphp
                @foreach ($dbProducts as $item)
                <div class="product-card" data-price="{{ $item->price }}">
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

        <!-- Pagination Controls -->
        <div id="shop-pagination-container" style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 4rem;">
            <!-- Rendered dynamically -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>


    function applyPriceFilter() {
        const loader = document.getElementById('shop-loader');
        const sliderVal = document.getElementById('price-slider').value;
        if(loader) loader.style.display = 'flex';
        
        setTimeout(() => {
            if(loader) loader.style.display = 'none';
            currentMaxPrice = parseFloat(sliderVal);
            currentPage = 1;
            filterAndPaginate();
        }, 600); // Premium loading spinner delay
    }

    function resetAllFilters() {
        const checkboxes = document.querySelectorAll('aside input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = false);

        const radios = document.querySelectorAll('aside input[type="radio"]');
        radios.forEach(r => r.checked = false);

        const slider = document.getElementById('price-slider');
        if (slider) {
            slider.value = 100000;
            document.getElementById('price-val').innerText = '₹100000';
        }
        applyPriceFilter();
    }

    // Dynamic Pagination State & Logic
    let currentPage = 1;
    const itemsPerPage = 100;
    let currentMaxPrice = 100000;

    function filterAndPaginate() {
        const cards = document.querySelectorAll('#shop-product-grid .product-card');
        
        // 1. Filter cards by price limit
        const matchingCards = [];
        cards.forEach(card => {
            const price = parseFloat(card.getAttribute('data-price'));
            if (price <= currentMaxPrice) {
                matchingCards.push(card);
            } else {
                card.style.display = 'none';
            }
        });

        // 2. Calculate Page Limits
        const totalMatching = matchingCards.length;
        const totalPages = Math.ceil(totalMatching / itemsPerPage) || 1;
        currentPage = Math.min(currentPage, totalPages);

        matchingCards.forEach((card, index) => {
            const startIdx = (currentPage - 1) * itemsPerPage;
            const endIdx = currentPage * itemsPerPage - 1;
            if (index >= startIdx && index <= endIdx) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

        // 3. Update top counter
        const counterText = document.getElementById('shop-results-counter');
        if (counterText) {
            const startItem = totalMatching === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
            const endItem = Math.min(currentPage * itemsPerPage, totalMatching);
            counterText.innerText = `Showing ${startItem}–${endItem} of ${totalMatching} premium products`;
        }

        // 4. Rebuild Pagination buttons
        const pagContainer = document.getElementById('shop-pagination-container');
        if (pagContainer) {
            let pagHtml = '';
            
            // Prev Button
            pagHtml += `<button class="btn btn-outline" style="padding: 0.5rem 1rem;" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})">&larr; Prev</button>`;
            
            // Page Buttons
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    pagHtml += `<button class="btn btn-outline" style="padding: 0.5rem 1rem; background: var(--text-primary); color: var(--white); border-color: var(--text-primary);">${i}</button>`;
                } else {
                    pagHtml += `<button class="btn btn-outline" style="padding: 0.5rem 1rem;" onclick="goToPage(${i})">${i}</button>`;
                }
            }
            
            // Next Button
            pagHtml += `<button class="btn btn-outline" style="padding: 0.5rem 1rem;" ${currentPage === totalPages ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})">Next &rarr;</button>`;
            
            pagContainer.innerHTML = pagHtml;
        }
    }

    window.goToPage = function(pageNumber) {
        currentPage = pageNumber;
        filterAndPaginate();
        document.getElementById('shop-product-grid').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Initialize pagination on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        filterAndPaginate();
    });
</script>
@endsection
