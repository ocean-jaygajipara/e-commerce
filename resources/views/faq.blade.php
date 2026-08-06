@extends('layouts.storefront')

@section('title', 'Frequently Asked Questions - VELOX')

@section('content')
<div style="max-width: 800px; margin: 3rem auto;">
    <h1 style="font-size: 2.25rem; font-weight: 800; margin-bottom: 1rem; text-align: center;">Frequently Asked Questions</h1>
    <p style="color: var(--text-secondary); text-align: center; margin-bottom: 3rem;">Clear, concise assistance regarding orders, VIP accounts, and product details.</p>

    <!-- FAQ Accordions -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="glass faq-item" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); overflow: hidden; transition: var(--transition);">
            <div class="faq-question" onclick="toggleFaq(this)" style="padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; cursor: pointer; font-weight: 700; font-size: 1.05rem; user-select: none;">
                How fast is VIP premium delivery?
                <span class="faq-icon" style="transition: var(--transition); font-size: 1.25rem;">+</span>
            </div>
            <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: all 0.3s ease; padding: 0 1.5rem; color: var(--text-secondary); line-height: 1.6; font-size: 0.95rem;">
                <div style="padding-bottom: 1.5rem;">Standard premium shipping takes 2-3 business days. VIP Next-Day Shipping is guaranteed to arrive the following afternoon if placed before 3:00 PM EST.</div>
            </div>
        </div>

        <div class="glass faq-item" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); overflow: hidden; transition: var(--transition);">
            <div class="faq-question" onclick="toggleFaq(this)" style="padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; cursor: pointer; font-weight: 700; font-size: 1.05rem; user-select: none;">
                What is your return & refund policy?
                <span class="faq-icon" style="transition: var(--transition); font-size: 1.25rem;">+</span>
            </div>
            <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: all 0.3s ease; padding: 0 1.5rem; color: var(--text-secondary); line-height: 1.6; font-size: 0.95rem;">
                <div style="padding-bottom: 1.5rem;">We offer complimentary returns on all luxury assets in their original packaging and unworn condition within 30 days of shipment. See our full Return & Refund policy for instructions.</div>
            </div>
        </div>

        <div class="glass faq-item" style="border-radius: var(--radius-md); border: 1px solid var(--border-color); overflow: hidden; transition: var(--transition);">
            <div class="faq-question" onclick="toggleFaq(this)" style="padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; cursor: pointer; font-weight: 700; font-size: 1.05rem; user-select: none;">
                Do your watches come with a structural warranty?
                <span class="faq-icon" style="transition: var(--transition); font-size: 1.25rem;">+</span>
            </div>
            <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: all 0.3s ease; padding: 0 1.5rem; color: var(--text-secondary); line-height: 1.6; font-size: 0.95rem;">
                <div style="padding-bottom: 1.5rem;">Yes, all Chrono Lab horological items carry a 2-year international warranty covering movement components and manufacturer defects. Warranty cards are enclosed in the luxury storage box.</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleFaq(questionElement) {
        const item = questionElement.closest('.faq-item');
        const answer = item.querySelector('.faq-answer');
        const icon = item.querySelector('.faq-icon');

        if (answer.style.maxHeight && answer.style.maxHeight !== '0px') {
            answer.style.maxHeight = '0px';
            icon.innerText = '+';
            icon.style.transform = 'rotate(0deg)';
            item.style.borderColor = 'var(--border-color)';
        } else {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            icon.innerText = '−';
            icon.style.transform = 'rotate(180deg)';
            item.style.borderColor = 'var(--primary)';
        }
    }
</script>
@endsection
