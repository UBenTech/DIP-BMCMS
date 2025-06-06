<?php
// pages/contact.php
global $site_settings; // Site settings
$contact_email_address = CONTACT_EMAIL; // From settings loaded in index.php

// Retrieve form data from session if validation failed or for success message
$form_data = $_SESSION['contact_form_data'] ?? [];
$form_errors = $_SESSION['contact_form_errors'] ?? [];
$form_success_message = $_SESSION['contact_form_success'] ?? null;

unset($_SESSION['contact_form_data'], $_SESSION['contact_form_errors'], $_SESSION['contact_form_success']);
?>
<div class="bg-neutral-light/30 py-12 md:py-16 animate-fade-in-up">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <header class="text-center mb-12 md:mb-16">
            <h1 class="font-display text-4xl sm:text-5xl font-bold text-slate-100 mb-3">Get In Touch</h1>
            <p class="text-lg text-secondary max-w-xl mx-auto">We'd love to hear from you! Whether you have a question about our services, a project idea, or just want to say hello.</p>
            <span class="section-title-underline"></span>
        </header>

        <?php if ($form_success_message): ?>
            <div class="mb-8 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md shadow-sm text-center" role="alert">
                <?php echo esc_html($form_success_message); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($form_errors)): ?>
            <div class="mb-8 p-4 bg-red-100 text-red-700 border border-red-300 rounded-md shadow-sm" role="alert">
                <p class="font-bold mb-2">Please correct the following errors:</p>
                <ul class="list-disc list-inside">
                    <?php foreach($form_errors as $error): echo "<li>" . esc_html($error) . "</li>"; endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-start">
            <div class="bg-neutral p-6 sm:p-8 rounded-xl shadow-xl">
                <h3 class="font-display text-2xl font-semibold text-secondary mb-6">Send us a Message</h3>
                <form action="<?php echo BASE_URL; ?>actions/contact_process.php" method="POST" class="space-y-5">
                    <?php echo generate_csrf_input(); ?>
                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-slate-300 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="contact_name" id="contact_name" value="<?php echo esc_html($form_data['contact_name'] ?? ''); ?>" required 
                               class="w-full p-3 bg-neutral-lighter border border-neutral-light rounded-md text-slate-200 focus:ring-2 focus:ring-secondary focus:border-secondary transition-colors" placeholder="John Doe">
                    </div>
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-slate-300 mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="contact_email" id="contact_email" value="<?php echo esc_html($form_data['contact_email'] ?? ''); ?>" required
                               class="w-full p-3 bg-neutral-lighter border border-neutral-light rounded-md text-slate-200 focus:ring-2 focus:ring-secondary focus:border-secondary transition-colors" placeholder="you@example.com">
                    </div>
                     <div>
                        <label for="contact_subject" class="block text-sm font-medium text-slate-300 mb-1">Subject</label>
                        <input type="text" name="contact_subject" id="contact_subject" value="<?php echo esc_html($form_data['contact_subject'] ?? ''); ?>"
                               class="w-full p-3 bg-neutral-lighter border border-neutral-light rounded-md text-slate-200 focus:ring-2 focus:ring-secondary focus:border-secondary transition-colors" placeholder="e.g., Project Inquiry">
                    </div>
                    <div>
                        <label for="contact_message" class="block text-sm font-medium text-slate-300 mb-1">Message <span class="text-red-500">*</span></label>
                        <textarea name="contact_message" id="contact_message" rows="5" required
                                  class="w-full p-3 bg-neutral-lighter border border-neutral-light rounded-md text-slate-200 focus:ring-2 focus:ring-secondary focus:border-secondary transition-colors resize-y" placeholder="Your message here..."><?php echo esc_html($form_data['contact_message'] ?? ''); ?></textarea>
                    </div>
                    <div>
                        <button type="submit" name="submit_contact_form" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white bg-secondary hover:bg-opacity-80 rounded-lg shadow-lg transition-colors group">
                            <i data-lucide="send" class="w-5 h-5 mr-2 group-hover:animate-ping-once"></i>Send Message
                        </button>
                    </div>
                </form>
            </div>
            <div class="bg-neutral p-6 sm:p-8 rounded-xl shadow-xl space-y-6 mt-8 md:mt-0">
                 <h3 class="font-display text-2xl font-semibold text-secondary mb-4">Our Contact Details</h3>
                <div class="flex items-start space-x-4 text-slate-300">
                    <i data-lucide="phone-call" class="w-6 h-6 text-secondary mt-1 shrink-0"></i>
                    <div><span class="font-semibold block">Phone:</span>+256 7XX XXX XXX <span class="text-xs text-slate-400">(Mon-Fri, 9am-5pm EAT)</span></div>
                </div>
                <div class="flex items-start space-x-4 text-slate-300">
                    <i data-lucide="mail" class="w-6 h-6 text-secondary mt-1 shrink-0"></i>
                    <div><span class="font-semibold block">Email:</span><a href="mailto:<?php echo esc_html($contact_email_address); ?>" class="hover:text-secondary transition-colors"><?php echo esc_html($contact_email_address); ?></a></div>
                </div>
                <div class="flex items-start space-x-4 text-slate-300">
                    <i data-lucide="map-pin" class="w-6 h-6 text-secondary mt-1 shrink-0"></i>
                    <div><span class="font-semibold block">Address:</span>Innovation Village, Ntinda, Kampala, Uganda <br><span class="text-xs text-slate-400">(Appointments preferred)</span></div>
                </div>
                <div class="h-56 bg-neutral-lighter rounded-md flex items-center justify-center text-slate-500 shadow-inner overflow-hidden mt-6">
                    <img src="https://source.unsplash.com/random/800x400/?kampala,map,office" alt="Map Location Placeholder" class="w-full h-full object-cover" onError="this.style.display='none'; this.parentElement.innerHTML = 'Map loading...';">
                </div>
            </div>
        </div>
    </div>
</div>
<style>.group-hover\:animate-ping-once:hover i { animation: pingOnce 0.8s cubic-bezier(0, 0, 0.2, 1); } @keyframes pingOnce { 75%, 100% { transform: scale(1.3); opacity: 0; } }</style>
