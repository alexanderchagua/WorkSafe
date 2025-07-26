<?php
// common/footer.php
?>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3><i class="fas fa-shield-alt"></i> WorkSafe</h3>
                <p>Comprehensive system for Safety, Occupational Health and Environment. We protect what matters most for your company.</p>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <p><a href="/worksafe/index.php">Home</a></p>
                <p><a href="/worksafe/index.php?action=Add Personal">Add Staff</a></p>
                <p><a href="/worksafe/index.php?action=Search Personal">Search Staff</a></p>
                <p><a href="/worksafe/index.php?action=Login">Login</a></p>
            </div>
            
            <div class="footer-section">
                <h3>Contact</h3>
                <p><i class="fas fa-map-marker-alt"></i> Av. Seguridad 123, Lima, Peru</p>
                <p><i class="fas fa-phone"></i> +51 (01) 123-4567</p>
                <p><i class="fas fa-envelope"></i> info@worksafe.com</p>
                <p><i class="fas fa-clock"></i> Mon-Fri: 8:00 - 18:00</p>
                <p><i ></i></p>
            </div>
            
            <div class="footer-section">
                <h3>Certifications</h3>
                <p>ISO 45001 - OH&S Management</p>
                <p>ISO 14001 - Environmental Management</p>
                <p>ISO 9001 - Quality Management</p>
                <p>OHSAS 18001 - Safety</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> WorkSafe. All rights reserved.</p>
        </div>
    </footer>
    <!-- Intl Tel Input JS -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.5/build/js/intlTelInput.min.js"></script>
<script>
  const input = document.querySelector("#phone");
  window.intlTelInput(input, {
    initialCountry: "auto",
    geoIpLookup: function(callback) {
      fetch("https://ipapi.co/json")
        .then(res => res.json())
        .then(data => callback(data.country_code))
        .catch(() => callback("us"));
    },
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.5/build/js/utils.js"
  });
</script>

</body>
</html>