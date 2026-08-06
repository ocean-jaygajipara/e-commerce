// Premium E-Commerce Theme Interactive Logic (Vanilla JS)

document.addEventListener('DOMContentLoaded', () => {
    // Theme Toggle Initialization
    const themeBtn = document.querySelector('.theme-toggle');
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(themeBtn, savedTheme);

    if (themeBtn) {
        themeBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(themeBtn, newTheme);
        });
    }

    function updateThemeIcon(btn, theme) {
        if (!btn) return;
        if (theme === 'dark') {
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>`;
        } else {
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>`;
        }
    }

    // Sticky Header Scroll Event
    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Scroll to Top Button
    const scrollTopBtn = document.querySelector('.scroll-to-top');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollTopBtn.classList.add('active');
        } else {
            scrollTopBtn.classList.remove('active');
        }
    });

    if (scrollTopBtn) {
        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Live Search Suggestions Mockup
    const searchInput = document.querySelector('.search-bar');
    const suggestions = document.querySelector('.search-suggestions');
    if (searchInput && suggestions) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            if (query.length > 1) {
                // Populate fake matching items
                suggestions.classList.add('active');
            } else {
                suggestions.classList.remove('active');
            }
        });

        // Hide suggestions on clicking outside
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
                suggestions.classList.remove('active');
            }
        });
    }

    // Cart Drawer Toggle Logic
    const cartToggle = document.querySelectorAll('.cart-toggle-trigger');
    const cartDrawer = document.querySelector('.cart-drawer');
    const overlay = document.querySelector('.cart-drawer-overlay');
    const closeCart = document.querySelector('.close-drawer');

    function openCartDrawer() {
        if (cartDrawer) cartDrawer.classList.add('active');
        if (overlay) overlay.classList.add('active');
    }

    function closeCartDrawer() {
        if (cartDrawer) cartDrawer.classList.remove('active');
        if (overlay) overlay.classList.remove('active');
    }

    cartToggle.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        openCartDrawer();
    }));

    if (closeCart) closeCart.addEventListener('click', closeCartDrawer);
    if (overlay) overlay.addEventListener('click', closeCartDrawer);

    // Wishlist Mock Store
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    const wishlistBadges = document.querySelectorAll('.wishlist-badge');

    function updateWishlistBadge() {
        wishlistBadges.forEach(badge => {
            badge.innerText = wishlist.length;
            badge.style.display = wishlist.length > 0 ? 'flex' : 'none';
        });
    }
    updateWishlistBadge();

    window.toggleWishlist = function(id, name, price, img) {
        const index = wishlist.findIndex(item => item.id === id);
        if (index === -1) {
            wishlist.push({ id, name, price, img });
            showToast(`${name} added to Wishlist`);
        } else {
            wishlist.splice(index, 1);
            showToast(`${name} removed from Wishlist`);
        }
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        updateWishlistBadge();
        // Trigger page re-render if we are on wishlist sections
        if (window.renderWishlistPage) window.renderWishlistPage();
    };

    // Cart Mock Store
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartBadges = document.querySelectorAll('.cart-badge');

    function updateCartBadge() {
        const totalItems = cart.reduce((total, item) => total + item.qty, 0);
        cartBadges.forEach(badge => {
            badge.innerText = totalItems;
            badge.style.display = totalItems > 0 ? 'flex' : 'none';
        });
    }
    updateCartBadge();

    window.productStocks = [];
    fetch('/api/products/stock')
        .then(res => res.json())
        .then(data => {
            window.productStocks = data;
        })
        .catch(err => console.log('Error fetching product stocks:', err));

    window.addToCart = function(id, name, price, img, qty = 1) {
        const prod = window.productStocks.find(p => p.id === id);
        let maxStock = prod ? prod.stock : 999;
        
        let colorName = null;
        const matches = name.match(/\(([^)]+)\)/);
        if (matches) {
            colorName = matches[1].trim();
        }
        if (prod && prod.colors && prod.colors.length > 0 && colorName) {
            const variant = prod.colors.find(c => c.name && c.name.toLowerCase() === colorName.toLowerCase());
            if (variant) {
                maxStock = variant.stock;
            }
        }

        const existingItem = cart.find(item => item.id === id && item.name === name);
        const currentQty = existingItem ? existingItem.qty : 0;
        if (currentQty + qty > maxStock) {
            showToast(`Cannot add more. Only ${maxStock} units left in stock!`, 'error');
            return;
        }

        if (existingItem) {
            existingItem.qty += qty;
        } else {
            cart.push({ id, name, price, img, qty });
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartBadge();
        renderCartDrawer();
        openCartDrawer();
        showToast(`${name} added to Cart`);
        if (window.renderCartPage) window.renderCartPage();
    };

    window.updateQty = function(id, delta, name = null) {
        const item = cart.find(item => item.id === id && (!name || item.name === name));
        if (item) {
            const prod = window.productStocks.find(p => p.id === id);
            let maxStock = prod ? prod.stock : 999;
            
            let colorName = null;
            const matches = item.name.match(/\(([^)]+)\)/);
            if (matches) {
                colorName = matches[1].trim();
            }
            if (prod && prod.colors && prod.colors.length > 0 && colorName) {
                const variant = prod.colors.find(c => c.name && c.name.toLowerCase() === colorName.toLowerCase());
                if (variant) {
                    maxStock = variant.stock;
                }
            }

            if (delta > 0 && item.qty + delta > maxStock) {
                showToast(`Cannot add more. Only ${maxStock} units left in stock!`, 'error');
                return;
            }

            item.qty += delta;
            if (item.qty <= 0) {
                cart = cart.filter(i => !(i.id === id && (!name || i.name === name)));
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartBadge();
            renderCartDrawer();
            if (window.renderCartPage) window.renderCartPage();
        }
    };

    window.removeFromCart = function(id, name = null) {
        cart = cart.filter(i => !(i.id === id && (!name || i.name === name)));
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartBadge();
        renderCartDrawer();
        showToast("Item removed from Cart");
        if (window.renderCartPage) window.renderCartPage();
    };

    function renderCartDrawer() {
        const drawerList = document.querySelector('.cart-drawer-list');
        const drawerSubtotal = document.getElementById('drawer-subtotal');
        if (!drawerList) return;

        if (cart.length === 0) {
            drawerList.innerHTML = `
                <div style="text-align: center; padding: 3rem 0; color: var(--text-secondary);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem; opacity: 0.5;"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                    <p>Your cart is empty.</p>
                </div>
            `;
            if (drawerSubtotal) drawerSubtotal.innerText = '₹0.00';
            return;
        }

        let total = 0;
        drawerList.innerHTML = cart.map(item => {
            const sub = item.price * item.qty;
            total += sub;
            const safeName = item.name.replace(/'/g, "\\'");
            
            let colorBadge = '';
            const matches = item.name.match(/\(([^)]+)\)/);
            let displayName = item.name;
            if (matches) {
                const colorVal = matches[1].trim();
                const prod = window.productStocks.find(p => p.id === item.id);
                let hexColor = '#ccc';
                if (prod && prod.colors) {
                    const foundColor = prod.colors.find(c => c.name && c.name.toLowerCase() === colorVal.toLowerCase());
                    if (foundColor) {
                        hexColor = foundColor.code;
                    }
                }
                displayName = item.name.replace(/\([^)]+\)/, '').trim();
                colorBadge = `<div style="display:flex; align-items:center; gap:0.5rem; margin-top:0.25rem;"><span style="width:12px; height:12px; border-radius:50%; background:${hexColor}; border:1px solid var(--border-color); display:inline-block;"></span><span style="font-size:0.8rem; color:var(--text-secondary); font-weight:600;">${colorVal}</span></div>`;
            }

            return `
                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
                    <img src="${item.img}" style="width: 70px; height: 70px; border-radius: var(--radius-sm); object-fit: cover;">
                    <div style="flex-grow: 1;">
                        <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 0.25rem;">${displayName}</h4>
                        ${colorBadge}
                        <p style="color: var(--primary); font-weight: 700; font-size: 0.9rem; margin-top: 0.25rem; margin-bottom: 0.5rem;">₹${item.price.toFixed(2)}</p>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <button onclick="updateQty(${item.id}, -1, '${safeName}')" style="border: 1px solid var(--border-color); background: none; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; border-radius: 4px; color: var(--text-primary);">-</button>
                            <span style="font-size: 0.9rem; font-weight: 600;">${item.qty}</span>
                            <button onclick="updateQty(${item.id}, 1, '${safeName}')" style="border: 1px solid var(--border-color); background: none; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; border-radius: 4px; color: var(--text-primary);">+</button>
                        </div>
                    </div>
                    <button onclick="removeFromCart(${item.id}, '${safeName}')" style="border: none; background: none; color: var(--text-secondary); cursor: pointer; font-size: 0.9rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </button>
                </div>
            `;
        }).join('');

        if (drawerSubtotal) drawerSubtotal.innerText = `₹${total.toFixed(2)}`;
    }
    renderCartDrawer();

    // Flash Sale Countdown Logic
    const timerElement = document.querySelector('.countdown-box');
    if (timerElement) {
        let hrs = 8, mins = 45, secs = 30;
        setInterval(() => {
            secs--;
            if (secs < 0) {
                secs = 59;
                mins--;
                if (mins < 0) {
                    mins = 59;
                    hrs--;
                }
            }
            const hrsText = document.getElementById('hours');
            const minsText = document.getElementById('minutes');
            const secsText = document.getElementById('seconds');
            if (hrsText) hrsText.innerText = String(hrs).padStart(2, '0');
            if (minsText) minsText.innerText = String(mins).padStart(2, '0');
            if (secsText) secsText.innerText = String(secs).padStart(2, '0');
        }, 1000);
    }

    // Toast Notifier
    window.showToast = function(message, type = 'success') {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.style.cssText = `
                position: fixed;
                top: 2rem;
                right: 2rem;
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
                z-index: 99999;
                pointer-events: none;
            `;
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.style.pointerEvents = 'auto';
        
        let color = '#10B981'; // Green
        let title = 'Success';
        let iconBg = '#d1fae5';
        let iconColor = '#065f46';
        let iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>`;
        
        if (type === 'error') {
            color = '#EF4444'; // Red
            title = 'Error';
            iconBg = '#fee2e2';
            iconColor = '#991b1b';
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`;
        } else if (type === 'info') {
            color = '#3B82F6'; // Blue
            title = 'Info';
            iconBg = '#dbeafe';
            iconColor = '#1e3a8a';
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>`;
        }

        toast.style.cssText = `
            width: 350px;
            background: #ffffff;
            color: #1f2937;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border-left: 6px solid ${color};
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            padding: 0.9rem 1.1rem 0.9rem 0.9rem;
            transform: translateX(120%);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        `;

        toast.innerHTML = `
            <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                <div style="background: ${iconBg}; color: ${iconColor}; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    ${iconSvg}
                </div>
                <div style="flex-grow: 1; padding-top: 1px;">
                    <div style="font-weight: 700; font-size: 0.9rem; color: #111827; margin-bottom: 0.15rem;">${title}</div>
                    <div style="font-size: 0.85rem; color: #4b5563; line-height: 1.4;">${message}</div>
                </div>
                <button class="toast-close-btn" style="border: none; background: none; color: #9ca3af; cursor: pointer; padding: 2px; display: flex; align-items: center; justify-content: center; transition: color 0.2s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#9ca3af'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: rgba(0,0,0,0.03);">
                <div class="toast-progress" style="width: 100%; height: 100%; background: ${color}; transform-origin: left; animation: toastProgressAnim 3s linear forwards;"></div>
            </div>
            <style>
                @keyframes toastProgressAnim {
                    to { transform: scaleX(0); }
                }
            </style>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
            toast.style.opacity = '1';
        }, 50);

        const closeBtn = toast.querySelector('.toast-close-btn');
        const dismissToast = () => {
            toast.style.transform = 'translateX(120%)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 400);
        };

        closeBtn.addEventListener('click', dismissToast);

        let autoDismissTimeout = setTimeout(dismissToast, 3000);
        
        toast.addEventListener('mouseenter', () => {
            clearTimeout(autoDismissTimeout);
            const progress = toast.querySelector('.toast-progress');
            if (progress) progress.style.animationPlayState = 'paused';
        });

        toast.addEventListener('mouseleave', () => {
            autoDismissTimeout = setTimeout(dismissToast, 1500);
            const progress = toast.querySelector('.toast-progress');
            if (progress) progress.style.animationPlayState = 'running';
        });
    };
});
