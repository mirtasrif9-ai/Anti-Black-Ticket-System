<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-flex">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <div class="footer-links">
                    <a href="index.php#about"><i class="fas fa-chevron-right"></i> About Us</a>
                    <a href="#"><i class="fas fa-chevron-right"></i> Terms & Conditions</a>
                    <a href="#"><i class="fas fa-chevron-right"></i> Privacy Policy</a>
                    <a href="#"><i class="fas fa-chevron-right"></i> FAQs</a>
                    <a href="#"><i class="fas fa-chevron-right"></i> Support</a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Train Categories</h3>
                <div class="footer-links">
                    <?php
                    $sql = "SELECT DISTINCT category FROM trains";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $category = $row['category'];
                            echo '<a href="trains.php?category=' . urlencode($category) . '"><i class="fas fa-train"></i> ' . htmlspecialchars($category) . '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <div class="footer-contact">
                    <p><i class="fas fa-map-marker-alt"></i> Mymensingh Engineering College<br> &nbsp;&nbsp;&nbsp;&nbsp;Mymensingh, Bangladesh</p>
                    <p><i class="fas fa-phone"></i>+880 1968 251125</p>
                    <p><i class="fas fa-envelope"></i> mirtasrif9@gmail.com</p>
                    <div class="social-links">
                        <a href="https://web.facebook.com/mir.tasrif.1" target="_blank" style="margin-right: 30px;"><i class="fab fa-facebook-f"></i></a> 
                        <a href="https://www.instagram.com/mirtasrif/" target="_blank" style="margin-right: 30px;"><i class="fab fa-instagram"></i></a> 
                        <a href="https://www.linkedin.com/in/mir-tasrif-91b0252a4/" target="_blank" style="margin-right: 30px;"><i class="fab fa-linkedin-in"></i></a> 
                        <a href="https://www.fiverr.com/tasreef/" target="_blank"><i class="fa-brands fa-fonticons-fi"></i></a>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Chorolin Tickets - Anti Black Ticket Booking System. All Rights Reserved.</p>
            <p>Designed for better railway experiences</p>
        </div>
    </div>
</footer>
<script src="script/global.js"></script>