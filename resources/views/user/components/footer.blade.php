<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>World Cup 2030</h3>
                <p>The official ticketing and fan community platform for the 2030 FIFA World Cup.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('games') }}">Games</a></li>
                    <li><a href="{{ route('teams') }}">Teams</a></li>
                    <li><a href="{{ route('forum.index') }}">Community</a></li>
                    <li><a href="{{ route('stadiums') }}">Stadiums</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Support</h3>
                <ul class="footer-links">
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contact</h3>
                <ul class="footer-links contact-links">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Football St, City</li>
                    <li><i class="fas fa-phone"></i> +1 234 567 890</li>
                    <li><i class="fas fa-envelope"></i> info@worldcup2030.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} World Cup 2030. All rights reserved.</p>
        </div>
    </div>
</footer>
