<?php
// admin/footer.php
?>
    </div> <!-- End of Main Content -->
  </div> <!-- End of Flex Container -->

  <!-- Initialize Lucide icons -->
  <script>
    if (typeof lucide !== 'undefined') {
      lucide.createIcons();
    } else {
      window.addEventListener('load', () => {
        if (typeof lucide !== 'undefined') {
          lucide.createIcons();
        }
      });
    }
  </script>
  <script src="<?= BASE_URL; ?>js/script.js"></script>
</body>
</html>
