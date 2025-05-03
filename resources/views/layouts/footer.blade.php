<!-- Footer -->

<footer class="azid-footer">
    <div class="footer-container">
        <!-- Logo -->
        <div class="footer-logo">
            <img src="{{ asset('images/logo-azidcar.png') }}" alt="AZIDCAR">
        </div>
        <!-- Visit Us -->
        <div class="footer-block">
            <h3>Visit Us</h3>
            <ul>
                <li><i class="fa-solid fa-mobile-screen-button"></i> +212 660614204</li>
                <li><i class="fa-solid fa-phone"></i> 05 05 05 05 05</li>
                <li><i class="fa-solid fa-envelope"></i> contact@azidcar.com</li>
                <li><i class="fa-solid fa-location-dot"></i> Fès, Centre Ville</li>
            </ul>
        </div>
        <!-- Quick Links -->
        <div class="footer-block">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="#">Liste des voitures</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Contactez-nous</a></li>
            </ul>
        </div>
        <!-- Newsletter -->
        <div class="footer-block footer-newsletter">
            <h3>Newsletter</h3>
            <p>Stay up to date with our latest news, receive exclusive deals, and more.</p>
            <form>
                <input type="email" placeholder="Enter your email">
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </div>
    <div class="footer-copyright">
        Copyright {{ date('Y') }} AZIDCAR
    </div>
</footer>
