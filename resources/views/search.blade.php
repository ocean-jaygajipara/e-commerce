@extends('layouts.storefront')

@section('title', 'Search - VELOX')

@section('content')
<div style="margin-top: 2rem; max-width: 900px; margin-left: auto; margin-right: auto;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 2rem; text-align: center;">Instant Search</h1>

    <!-- Custom Search Form -->
    <div style="position: relative; margin-bottom: 3rem;">
        <input type="text" placeholder="Search by name, category, or brand..." style="width: 100%; padding: 1.25rem 2rem 1.25rem 3.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: var(--light-grey); color: var(--text-primary); font-size: 1.1rem; outline: none; transition: var(--transition);" oninput="runInstantSearch(this.value)">
        <span style="position: absolute; left: 1.5rem; top: 50%; transform: translateY(-50%); font-size: 1.25rem;">🔍</span>
    </div>

    <!-- Suggested & Trending Searches -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 4rem;">
        <div>
            <h4 style="font-weight: 700; font-size: 1rem; text-transform: uppercase; margin-bottom: 1rem; letter-spacing: 1px;">Trending Searches</h4>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <span style="background: var(--light-grey); padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; cursor: pointer;" onclick="runInstantSearch('Smartwatch')">#Smartwatch</span>
                <span style="background: var(--light-grey); padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; cursor: pointer;" onclick="runInstantSearch('Earbuds')">#Earbuds</span>
                <span style="background: var(--light-grey); padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; cursor: pointer;" onclick="runInstantSearch('Leather Bag')">#LeatherBag</span>
                <span style="background: var(--light-grey); padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; cursor: pointer;" onclick="runInstantSearch('Luxury Outerwear')">#Outerwear</span>
            </div>
        </div>
        <div>
            <h4 style="font-weight: 700; font-size: 1rem; text-transform: uppercase; margin-bottom: 1rem; letter-spacing: 1px;">Recent Searches</h4>
            <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
                <li style="font-size: 0.9rem; color: var(--text-secondary); cursor: pointer;" onclick="runInstantSearch('ANC Headphones')">⏱ ANC Headphones</li>
                <li style="font-size: 0.9rem; color: var(--text-secondary); cursor: pointer;" onclick="runInstantSearch('Minimalist Lighting')">⏱ Minimalist Lighting</li>
            </ul>
        </div>
    </div>

    <!-- Search Results Grid -->
    <div id="search-results-section" style="display: none;">
        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Search Results (<span id="results-count">0</span>)</h3>
        <div id="search-results-grid" class="grid-container">
            <!-- Populated via Javascript -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const mockProducts = [
        { id: 1, name: 'AeroBuds Pro - Wireless ANC Earbuds', price: 149.00, img: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&auto=format&fit=crop', brand: 'Velox Sound' },
        { id: 2, name: 'Titan Chrono Watch', price: 299.00, img: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&auto=format&fit=crop', brand: 'Chrono Lab' },
        { id: 3, name: 'Luna Aromatherapy Diffuser', price: 89.00, img: 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&auto=format&fit=crop', brand: 'Modern Living' },
        { id: 4, name: 'Summit Waterproof Leather Backpack', price: 195.00, img: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&auto=format&fit=crop', brand: 'Summit Leather' }
    ];

    function runInstantSearch(val) {
        const query = val.toLowerCase().trim();
        const resultsSection = document.getElementById('search-results-section');
        const resultsGrid = document.getElementById('search-results-grid');
        const resultsCount = document.getElementById('results-count');

        if(query.length === 0) {
            resultsSection.style.display = 'none';
            return;
        }

        const filtered = mockProducts.filter(item => 
            item.name.toLowerCase().includes(query) || 
            item.brand.toLowerCase().includes(query)
        );

        resultsCount.innerText = filtered.length;
        resultsSection.style.display = 'block';

        if(filtered.length === 0) {
            resultsGrid.innerHTML = `<div style="grid-column: span 3; padding: 4rem 0; text-align: center; color: var(--text-secondary);">No products match your query.</div>`;
            return;
        }

        resultsGrid.innerHTML = filtered.map(item => `
            <div class="product-card">
                <div class="product-img-wrapper">
                    <img src="${item.img}">
                </div>
                <div class="product-info">
                    <span class="product-brand">${item.brand}</span>
                    <a href="/product/${item.id}" class="product-title">${item.name}</a>
                    <div class="product-footer">
                        <span class="product-price">₹${item.price.toFixed(2)}</span>
                    </div>
                </div>
            </div>
        `).join('');
    }
</script>
@endsection
