@extends('layouts.storefront')

@section('title', 'Contact Us - Ocean Ecom')

@section('content')
<div style="margin-top: 2rem;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 1rem; text-align: center;">Get in Touch</h1>
    <p style="color: var(--text-secondary); text-align: center; max-width: 600px; margin: 0 auto 3rem; line-height: 1.5;">Have a inquiry regarding custom orders, luxury sizing, or shipping updates? Our concierge team is here to assist.</p>

    <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 4rem; margin-bottom: 4rem;">
        <!-- Left: Details & Map -->
        <div>
            <div class="glass" style="border-radius: var(--radius-md); padding: 2rem; border: 1px solid var(--border-color); margin-bottom: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Ocean Ecom Flagship Store</h3>
                <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1rem;">
                    📍 123 Luxury Promenade, Beverly Hills, CA 90210<br>
                    📞 +1 (310) 555-8900<br>
                    ✉️ concierge@oceanecom.com
                </p>
                <h4 style="font-weight: 700; font-size: 0.95rem; margin-bottom: 0.5rem; margin-top: 1.5rem;">Hours of Operation</h4>
                <p style="color: var(--text-secondary); font-size: 0.9rem;">Monday - Saturday: 10:00 AM - 8:00 PM<br>Sunday: 12:00 PM - 6:00 PM</p>
            </div>

            <!-- Mock Google Map visual widget -->
            <div style="border-radius: var(--radius-md); overflow: hidden; height: 250px; border: 1px solid var(--border-color); background: #eee; position: relative;">
                <div style="position: absolute; inset:0; background: url('https://images.unsplash.com/photo-1524661135-423995f22d0b?w=600&auto=format&fit=crop') center/cover; filter: grayscale(1) contrast(1.2);"></div>
                <div class="glass" style="position: absolute; bottom: 1rem; left: 1rem; right: 1rem; padding: 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 700; text-align: center;">
                    📍 Beverly Hills Flagship Map
                </div>
            </div>
        </div>

        <!-- Right: Contact Form -->
        <div class="glass" style="border-radius: var(--radius-md); padding: 3rem; border: 1px solid var(--border-color);">
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem;">Send a Message</h3>
            <form onsubmit="event.preventDefault(); alert('Message sent to our concierge team!'); this.reset();" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Your Name</label>
                    <input type="text" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Email Address</label>
                    <input type="email" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.5rem; color:var(--text-secondary);">Message Inquiry</label>
                    <textarea rows="5" required style="width:100%; padding:0.75rem; border-radius:var(--radius-sm); border:1px solid var(--border-color); background:var(--white); color:var(--text-primary); outline:none; resize:none; font-family:inherit;"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 1rem;">Submit Inquiry</button>
            </form>
        </div>
    </div>
</div>
@endsection
