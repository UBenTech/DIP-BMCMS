<footer class="bg-base-200 pt-12 pb-6 px-4 mt-12 print:hidden">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
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
</footer>
<script>
    if (typeof lucide !== 'undefined') { lucide.createIcons(); }
    window.addEventListener('load', () => { if (typeof lucide !== 'undefined') { lucide.createIcons(); } });
</script>
</body>
</html>