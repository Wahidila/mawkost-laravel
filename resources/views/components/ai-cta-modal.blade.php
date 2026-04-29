<div id="aiCtaModal" class="ai-cta-modal" style="display: none;">
    <div class="ai-cta-modal-overlay" onclick="closeAiCtaModal()"></div>
    <div class="ai-cta-modal-content">
        <button class="ai-cta-modal-close" onclick="closeAiCtaModal()" aria-label="Tutup">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <div class="blog-cta-ai" style="margin: 0;">
            <div class="blog-cta-glow"></div>
            <div class="blog-cta-particles">
                <span></span><span></span><span></span><span></span><span></span>
            </div>
            <div class="blog-cta-icon">
                <i class="fa-solid fa-robot"></i>
                <div class="blog-cta-pulse"></div>
            </div>
            <h4>Cari Kost dengan AI</h4>
            <p>Sesuai kebutuhanmu — kota, budget, tipe, fasilitas. Tanya langsung!</p>
            <a href="{{ route('chat.index') }}" class="blog-cta-btn">
                <span class="blog-cta-btn-text"><i class="fa-solid fa-wand-magic-sparkles"></i> Konsultasi AI</span>
                <span class="blog-cta-btn-arrow"><i class="fa-solid fa-arrow-right"></i></span>
            </a>
            <div class="blog-cta-badge">
                <i class="fa-solid fa-bolt"></i> Gratis
            </div>
        </div>
    </div>
</div>

<style>
.ai-cta-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: aiModalFadeIn 0.3s ease;
}

@keyframes aiModalFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.ai-cta-modal-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
}

.ai-cta-modal-content {
    position: relative;
    max-width: 420px;
    width: 90%;
    animation: aiModalSlideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes aiModalSlideUp {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.ai-cta-modal-close {
    position: absolute;
    top: -12px;
    right: -12px;
    width: 36px;
    height: 36px;
    background: #fff;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.2s ease;
    z-index: 10;
}

.ai-cta-modal-close:hover {
    background: var(--primary-dark);
    color: #fff;
    transform: rotate(90deg) scale(1.1);
}

.ai-cta-modal-close i {
    font-size: 1.1rem;
}

.ai-cta-modal .blog-cta-ai {
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}
</style>

<script>
function showAiCtaModal() {
    const modal = document.getElementById('aiCtaModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeAiCtaModal() {
    const modal = document.getElementById('aiCtaModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        localStorage.setItem('mawkost_ai_cta_dismissed', 'true');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const dismissed = localStorage.getItem('mawkost_ai_cta_dismissed');
    
    if (!dismissed) {
        setTimeout(showAiCtaModal, 3000);
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAiCtaModal();
    }
});
</script>
