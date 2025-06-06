<?php // Ensure this debug echo is visible if footer is included
    // echo ""; 
?>
    </div> <footer class="bg-neutral border-t border-neutral-light mt-auto py-12 md:py-16 text-slate-400 print:hidden">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                         <i data-lucide="cpu" class="w-7 h-7 text-secondary"></i>
                        <span class="font-display text-xl font-semibold text-secondary"><?php echo SITE_NAME; ?></span>
                    </div>
                    <p class="text-sm mb-4"><?php echo SITE_TAGLINE; ?>. We provide cutting-edge IT services to help your business thrive.</p>
                     <div class="flex space-x-3 mt-4">
                        <a href="#" aria-label="Facebook" class="text-slate-500 hover:text-secondary transition-colors"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                        <a href="#" aria-label="Twitter" class="text-slate-500 hover:text-secondary transition-colors"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                        <a href="#" aria-label="LinkedIn" class="text-slate-500 hover:text-secondary transition-colors"><i data-lucide="linkedin" class="w-5 h-5"></i></a>
                        <a href="#" aria-label="Instagram" class="text-slate-500 hover:text-secondary transition-colors"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                    </div>
                </div>
                <div>
                    <h5 class="text-base font-semibold text-slate-200 mb-4">Quick Links</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo rtrim(BASE_URL, '/'); ?>/" class="hover:text-secondary transition-colors">Home</a></li>
                        <li><a href="<?php echo rtrim(BASE_URL, '/') . '/about'; ?>" class="hover:text-secondary transition-colors">About Us</a></li>
                        <li><a href="<?php echo rtrim(BASE_URL, '/') . '/services_overview'; ?>" class="hover:text-secondary transition-colors">Services</a></li>
                        <li><a href="<?php echo rtrim(BASE_URL, '/') . '/blog'; ?>" class="hover:text-secondary transition-colors">Blog</a></li>
                        <li><a href="<?php echo rtrim(BASE_URL, '/') . '/contact'; ?>" class="hover:text-secondary transition-colors">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                     <h5 class="text-base font-semibold text-slate-200 mb-4">Our Services</h5>
                     <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo rtrim(BASE_URL, '/') . '/webDev'; ?>" class="hover:text-secondary transition-colors">Web Development</a></li>
                        <li><a href="<?php echo rtrim(BASE_URL, '/') . '/software'; ?>" class="hover:text-secondary transition-colors">Software Solutions</a></li>
                        <li><a href="<?php echo rtrim(BASE_URL, '/') . '/cloud'; ?>" class="hover:text-secondary transition-colors">Cloud & DevOps</a></li>
                        <li><a href="<?php echo rtrim(BASE_URL, '/') . '/cybersecurity'; ?>" class="hover:text-secondary transition-colors">Cybersecurity</a></li>
                    </ul>
                </div>
                 <div>
                    <h5 class="text-base font-semibold text-slate-200 mb-4">Legal</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo rtrim(BASE_URL, '/') . '/privacy'; ?>" class="hover:text-secondary transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-secondary transition-colors">Terms of Service</a></li> 
                    </ul>
                </div>
            </div>
            <div class="border-t border-neutral-light pt-8 text-center text-sm">
                <p><?php echo str_replace('{year}', date("Y"), FOOTER_COPYRIGHT); ?></p>
                <p class="mt-1 text-xs text-slate-500">A Project by <?php echo SITE_NAME; ?>.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Initialize Lucide Icons after DOM is ready
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        } else {
            // Fallback or retry if lucide was loaded asynchronously and not ready immediately
            window.addEventListener('load', () => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                } else {
                    console.warn("Lucide script still not loaded after window load.");
                }
            });
        }

        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuIconOpen = document.getElementById('mobileMenuIconOpen');
        const mobileMenuIconClose = document.getElementById('mobileMenuIconClose');

        if (mobileMenuButton && mobileMenu && mobileMenuIconOpen && mobileMenuIconClose) {
            mobileMenuButton.addEventListener('click', () => {
                const isMenuOpen = !mobileMenu.classList.contains('hidden');
                
                // Toggle menu visibility with animation
                if (isMenuOpen) {
                    mobileMenu.style.maxHeight = '0'; // For CSS transition
                    // Wait for transition to finish before adding hidden
                    setTimeout(() => {
                         if (mobileMenu.style.maxHeight === '0px') { // Check if it wasn't opened again quickly
                            mobileMenu.classList.add('hidden');
                         }
                    }, 500); // Match CSS transition duration
                } else {
                    mobileMenu.classList.remove('hidden');
                    // Force reflow to enable transition
                    // No, setting maxHeight directly will trigger transition if CSS is set up for it.
                    mobileMenu.style.maxHeight = mobileMenu.scrollHeight + "px"; 
                }
                
                mobileMenuIconOpen.classList.toggle('hidden', !isMenuOpen);
                mobileMenuIconClose.classList.toggle('hidden', isMenuOpen);
                mobileMenuButton.setAttribute('aria-expanded', isMenuOpen ? 'false' : 'true');
            });
        } else {
            console.warn("Mobile menu elements not found for JS toggle. Check IDs: mobileMenuButton, mobileMenu, mobileMenuIconOpen, mobileMenuIconClose");
        }
        
        // Smooth scroll for # links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                if (this.getAttribute('href').length > 1 && this.hash !== "") { 
                    e.preventDefault();
                    const targetElement = document.querySelector(this.hash);
                    if(targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        });
    </script>
    <script src="<?php echo BASE_URL; ?>js/script.js"></script> 
</body>
</html>
```

**Key Changes in these "v8" (Header) and "v3.4" (Footer) versions:**

* **`includes/header.php` (v8):**
    * Changed the main `<nav>` tag to `<header id="mainNav"...>` for better semantics, as it's the primary site header.
    * **Mobile Menu HTML:** The `div` with `id="mobileMenu"` is now placed directly after the main `nav`'s closing `</div>` but *inside* the `<header>` tag. This is a common pattern. It has `md:hidden` so it's hidden on medium screens and up, and `hidden` by default (to be toggled by JS).
    * **Mobile Menu Button:** The button with `id="mobileMenuButton"` and its icons (`mobileMenuIconOpen`, `mobileMenuIconClose`) are within a `md:hidden` div, so they only show on smaller screens.
    * **Mega Menu Hover:** The `mega-menu-container` now uses `opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none group-hover:pointer-events-auto`. This ensures the hover area is more tied to the parent "Services" button (the `group`) and uses opacity for a smoother transition. The `pointer-events` ensure it doesn't block clicks when hidden.
    * **Lucide Script:** Changed `lucide.min.js` to just `lucide` for the `unpkg` CDN, as `lucide.createIcons()` is the standard call.
* **`includes/footer.php` (v3.4):**
    * **Mobile Menu JavaScript:**
        * The JavaScript now correctly targets `mobileMenuButton`, `mobileMenu`, `mobileMenuIconOpen`, and `mobileMenuIconClose`.
        * It toggles the `hidden` class on `mobileMenu`.
        * It also toggles the `hidden` class on `mobileMenuIconOpen` and `mobileMenuIconClose` to switch between hamburger and 'X'.
        * Added `aria-expanded` attribute toggling for accessibility.
        * Added a CSS transition for `max-height` on the `.mobile-menu` class (in `header.php` style block) and the JS now animates this `max-height` for a slide-down/up effect.
    * **Lucide Initialization:** Moved `lucide.createIcons()` to be called after the DOM is loaded or even on `window.load` as a fallback to ensure all `data-lucide` attributes are present.

**After replacing these two files on your server:**

1.  **Clear your browser cache very thoroughly** (Ctrl+F5 or Cmd+Shift+R).
2.  **Test your public site on a mobile device or by shrinking your desktop browser window.**
    * **Mobile Menu:** Does the hamburger icon appear? Does it toggle the menu with a smooth animation? Do the icons switch correctly?
    * **Desktop Mega Menu:** Hover over "Services." Does the mega menu appear only when hovering the "Services" text/button and not a wide area around it? Is the transition smooth?
    * **Footer:** Is it visible?
3.  **Check the Browser Developer Console (F12)** for any JavaScript errors or the `console.warn` messages from the footer script.

This new header structure and JavaScript should provide a much more reliable and animated mobile menu experience, and a more controlled hover for the desktop mega me