<style>
    /* Main Container - ALWAYS VISIBLE */
    .floating-menu-container {
        position: fixed;
        bottom: 30px;
        left: 30px;
        z-index: 1000;
        opacity: 1;
        visibility: visible;
    }

    /* Main Toggle Button */
    .main-toggle-btn {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: #005b94;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        border: none;
        cursor: pointer;
        position: relative;
        animation: mainPulse 3s ease-in-out infinite;
        user-select: none;
        pointer-events: auto;
    }

    @keyframes mainPulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .main-toggle-btn i {
        font-size: 1.8rem;
    }

    .floating-menu-container:hover .main-toggle-btn {
        background: #005b94;
        animation: none;
    }
    
    /* Visual indicator when menu is locked (closed) */
    .floating-menu-container.menu-locked .main-toggle-btn {
        background: #003d66;
        opacity: 0.7;
    }
    
    .floating-menu-container.menu-locked .main-toggle-btn:hover {
        background: #005b94;
        opacity: 1;
    }

    /* Menu Items Container */
    .menu-items {
        position: absolute;
        bottom: 70px;
        left: 0;
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding-bottom: 25px;
        opacity: 1;
        visibility: hidden;
        pointer-events: none;
    }

    /* Show menu on hover (only if not locked) */
    .floating-menu-container:hover .menu-items {
        visibility: visible !important;
        pointer-events: all !important;
    }
    
    /* Hide menu when locked (clicked to close) */
    .floating-menu-container.menu-locked .menu-items {
        visibility: hidden !important;
        pointer-events: none !important;
    }
    
    .floating-menu-container.menu-locked:hover .menu-items {
        visibility: hidden !important;
        pointer-events: none !important;
    }

    /* Individual Menu Item */
    .menu-item {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0;
    }

    /* Show menu items on hover */
    .floating-menu-container:hover .menu-item {
        opacity: 1 !important;
    }
    
    /* Hide menu items when locked */
    .floating-menu-container.menu-locked .menu-item {
        opacity: 0 !important;
    }
    
    .floating-menu-container.menu-locked:hover .menu-item {
        opacity: 0 !important;
    }

    /* Extended hover area for submenu */
    .menu-item.has-submenu {
        padding-right: 250px;
    }

    /* Menu Button */
    .menu-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        border: none;
        cursor: default;
        text-decoration: none;
        user-select: none;
    }
    
    /* Links should show pointer cursor */
    a.menu-btn {
        cursor: pointer;
    }

    .menu-btn i {
        font-size: 1.5rem;
    }

    /* Make loan button images white */
    .loan-insurance-btn img,
    .loan-repayment-btn img {
        filter: brightness(0) invert(1);
    }

    /* Button Colors */
    .loan-insurance-btn {
        background: linear-gradient(135deg, #0c1f38 0%, #1a3d5c 100%);
    }

    .loan-insurance-btn:hover {
        background: linear-gradient(135deg, #1a3d5c 0%, #0c1f38 100%);
    }

    .loan-repayment-btn {
        background: linear-gradient(135deg, #005b94 0%, #0077b6 100%);
    }

    .loan-repayment-btn:hover {
        background: linear-gradient(135deg, #0077b6 0%, #005b94 100%);
    }

    .call-center-btn {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    .call-center-btn:hover {
        background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
    }

    .social-media-btn {
        background: linear-gradient(135deg, #004a75 0%, #005b94 100%);
    }

    .social-media-btn:hover {
        background: linear-gradient(135deg, #005b94 0%, #004a75 100%);
    }

    /* Menu Label */
    .menu-label {
        background: rgba(0, 0, 0, 0.85);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        position: absolute;
        left: 75px;
    }

    .menu-item:hover .menu-label {
        opacity: 1;
        visibility: visible;
    }

    /* Social Icons Container */
    .social-icons-container {
        position: absolute;
        left: 70px;
        top: 0;
        display: flex;
        gap: 10px;
        align-items: center;
        opacity: 1;
        visibility: hidden;
        pointer-events: none;
        padding-left: 10px;
        padding-right: 10px;
        height: 60px;
    }

    /* Show social icons on hover */
    .menu-item.has-submenu:hover .social-icons-container {
        visibility: visible !important;
        pointer-events: all !important;
    }

    /* Social Button */
    .social-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        opacity: 0;
    }

    /* Show social icons on hover */
    .menu-item.has-submenu:hover .social-btn {
        opacity: 1 !important;
    }

    .social-btn i,
    .social-btn svg {
        font-size: 1.2rem;
    }

    /* Social Button Colors */
    .youtube-btn {
        background: linear-gradient(135deg, #FF0000, #CC0000);
    }

    .twitter-btn {
        background: linear-gradient(135deg, #1DA1F2, #0d8bd9);
    }

    .instagram-btn {
        background: linear-gradient(135deg, #E4405F, #C13584);
    }

    .facebook-btn {
        background: linear-gradient(135deg, #1877F2, #166fe5);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .floating-menu-container {
            bottom: 20px;
            left: 20px;
        }

        .main-toggle-btn {
            width: 60px;
            height: 60px;
        }

        .main-toggle-btn i {
            font-size: 1.5rem;
        }

        .menu-btn {
            width: 55px;
            height: 55px;
        }

        .social-btn {
            width: 40px;
            height: 40px;
        }

        .menu-label {
            display: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        * {
            animation: none !important;
        }
    }
</style>


<div class="floating-menu-container" id="floatingMenu">
    <!-- Expandable Menu Items (appear on hover above main button) -->
    <div class="menu-items">
        <!-- Loan Insurance -->
        <div class="menu-item">
            <a href="{{ route('loanapplication.applicationlink') }}" class="menu-btn loan-insurance-btn" aria-label="Loan Insurance">
                <img src="{{ asset('images/static_files/loanissuance.png') }}" alt="Loan Issuance" style="width: 35px; height: 35px; object-fit: contain;">
            </a>
            <span class="menu-label">Loan Insurance</span>
        </div>

        <!-- Loan Repayment -->
        <div class="menu-item">
            <a href="{{ route('loanrepayment.repaymentlink') }}" class="menu-btn loan-repayment-btn" aria-label="Loan Repayment">
                <img src="{{ asset('images/static_files/loanrepayment.png') }}" alt="Loan Repayment" style="width: 35px; height: 35px; object-fit: contain;">
            </a>
            <span class="menu-label">Loan Repayment</span>
        </div>

        <!-- Call Center -->
        <div class="menu-item">
            <a href="{{ config('links.heslb_systems.call_center') }}" target="_blank" rel="noopener noreferrer" class="menu-btn call-center-btn" aria-label="Call Center">
                <i class="fas fa-phone-alt"></i>
            </a>
            <span class="menu-label">Call Center</span>
        </div>

        <!-- Social Media with Submenu -->
        <div class="menu-item has-submenu">
            <div class="menu-btn social-media-btn" aria-label="Social Media" role="button" tabindex="0">
                <i class="fas fa-share-alt"></i>
            </div>
            
            <div class="social-icons-container">
                <a href="{{ config('links.social_media.youtube') }}" target="_blank" rel="noopener noreferrer" class="social-btn youtube-btn" aria-label="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
                
                <a href="{{ config('links.social_media.twitter') }}" target="_blank" rel="noopener noreferrer" class="social-btn twitter-btn" aria-label="Twitter/X">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a>
                
                <a href="{{ config('links.social_media.instagram') }}" target="_blank" rel="noopener noreferrer" class="social-btn instagram-btn" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                
                <a href="{{ config('links.social_media.facebook') }}" target="_blank" rel="noopener noreferrer" class="social-btn facebook-btn" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Toggle Button -->
    <div class="main-toggle-btn" aria-label="Quick Links Menu" role="button" tabindex="0">
        <i class="fas fa-user-graduate"></i>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainBtn = document.querySelector('.main-toggle-btn');
        const floatingMenu = document.getElementById('floatingMenu');
        
        if (!mainBtn || !floatingMenu) return;

        let isMenuLocked = false;
        let isMenuOpen = false;
        
        const handleToggle = function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle menu open/close
            isMenuOpen = !isMenuOpen;
            
            if (isMenuOpen) {
                floatingMenu.classList.remove('menu-locked');
            } else {
                floatingMenu.classList.add('menu-locked');
            }
            
            return false;
        };
        
        // Use only touchend for mobile (more reliable than touchstart)
        mainBtn.addEventListener('click', handleToggle);
        mainBtn.addEventListener('touchend', handleToggle);
    });
</script>