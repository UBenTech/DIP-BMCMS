<?php // admin/includes/footer.php ?>
            </main> </div> </div> <script>
        lucide.createIcons();

        // Admin Sidebar Toggle for mobile
        const adminSidebarToggle = document.getElementById('adminSidebarToggle');
        const adminSidebar = document.getElementById('adminSidebar');
        if (adminSidebarToggle && adminSidebar) {
            adminSidebarToggle.addEventListener('click', () => {
                adminSidebar.classList.toggle('-translate-x-full');
                // Optional: Add overlay for mobile when sidebar is open
            });
        }
    </script>
    <script src="<?php echo BASE_URL; ?>js/admin_script.js"></script> 
</body>
</html>
