@extends('layouts.storefront')

@section('title', 'Legal Documents - VELOX')

@section('content')
<div style="max-width: 900px; margin: 3rem auto;">
    <!-- Tabs Header -->
    <div class="glass" style="border-radius: var(--radius-md) var(--radius-md) 0 0; border: 1px solid var(--border-color); display: flex;">
        <button id="legal-tab-btn-privacy" class="legal-tab-btn" onclick="showLegalTab('privacy')" style="flex-grow: 1; padding: 1.25rem; font-weight: 700; border: none; background: none; cursor: pointer; border-bottom: 3px solid var(--primary); color: var(--text-primary);">Privacy Policy</button>
        <button id="legal-tab-btn-terms" class="legal-tab-btn" onclick="showLegalTab('terms')" style="flex-grow: 1; padding: 1.25rem; font-weight: 600; border: none; background: none; cursor: pointer; border-bottom: 3px solid transparent; color: var(--text-secondary);">Terms & Conditions</button>
        <button id="legal-tab-btn-returns" class="legal-tab-btn" onclick="showLegalTab('returns')" style="flex-grow: 1; padding: 1.25rem; font-weight: 600; border: none; background: none; cursor: pointer; border-bottom: 3px solid transparent; color: var(--text-secondary);">Return & Refund</button>
    </div>

    <!-- Tabs Body -->
    <div class="glass" style="border-radius: 0 0 var(--radius-md) var(--radius-md); border: 1px solid var(--border-color); border-top: none; padding: 3rem; line-height: 1.8; color: var(--text-primary);">
        
        <!-- Privacy Policy -->
        <div id="legal-privacy" class="legal-content-pane">
            <h2 style="font-size: 1.5rem; font-weight: 850; margin-bottom: 1rem;">Privacy Policy</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.5rem; font-size: 0.95rem;">Last updated: August 5, 2026</p>
            <p style="margin-bottom: 1.5rem;">At Velox, we take your personal privacy seriously. We collect, store, and utilize essential customer metrics (shipping addresses, cookies, VIP login sessions) solely to deliver a tailored shopping experience.</p>
            <p>Your details are encrypted using secure sockets layer technology and are never shared with unauthorized external entities.</p>
        </div>

        <!-- Terms & Conditions -->
        <div id="legal-terms" class="legal-content-pane" style="display: none;">
            <h2 style="font-size: 1.5rem; font-weight: 850; margin-bottom: 1rem;">Terms & Conditions</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.5rem; font-size: 0.95rem;">Last updated: August 5, 2026</p>
            <p style="margin-bottom: 1.5rem;">By browsing or purchasing from VELOX, you agree to comply with our commercial terms: item custom duties are the responsibility of the purchaser, and returns must satisfy our structural hygiene requirements.</p>
        </div>

        <!-- Return & Refund -->
        <div id="legal-returns" class="legal-content-pane" style="display: none;">
            <h2 style="font-size: 1.5rem; font-weight: 850; margin-bottom: 1rem;">Return & Refund Policy</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.5rem; font-size: 0.95rem;">Last updated: August 5, 2026</p>
            <p style="margin-bottom: 1.5rem;">We guarantee a full refund or exchange within 30 days of receiving your package. Returns must be processed in their original luxury boxing. Refund processing takes between 5-7 business days once validated by our concierge department.</p>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function showLegalTab(paneId) {
        document.querySelectorAll('.legal-content-pane').forEach(pane => pane.style.display = 'none');
        document.querySelectorAll('.legal-tab-btn').forEach(btn => {
            btn.style.color = 'var(--text-secondary)';
            btn.style.borderBottomColor = 'transparent';
        });

        const activePane = document.getElementById('legal-' + paneId);
        if(activePane) activePane.style.display = 'block';

        const activeBtn = document.getElementById('legal-tab-btn-' + paneId);
        if(activeBtn) {
            activeBtn.style.color = 'var(--text-primary)';
            activeBtn.style.borderBottomColor = 'var(--primary)';
        }
    }

    // Auto load tab parameter
    const legalTabParam = "{{ $tab }}";
    if (legalTabParam) {
        showLegalTab(legalTabParam);
    }
</script>
@endsection
