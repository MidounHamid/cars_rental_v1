


<style>
.azid-footer {
    background: #fff;
    padding: 12px 0 0 0;
    font-family: Arial, Helvetica, sans-serif;
}

.azid-footer .footer-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 200px repeat(3, 1fr);
    gap: 60px;
    padding: 0 20px;
    align-items: start;
}

.azid-footer .footer-logo {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding: 0;
}

.azid-footer .footer-logo img {
    height: 80px;
    width: 190px;
    object-fit: contain;
    display: block;
    margin: 0;
}

.azid-footer .footer-block {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.azid-footer h3 {
    color: #b5122b;
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 18px;
    font-family: inherit;
    line-height: 1.2;
}

.azid-footer ul {
    list-style: none;
    padding: 0;
    margin: 0;
    width: 100%;
}

.azid-footer li, .azid-footer p {
    color: #222;
    font-size: 16px;
    margin-bottom: 12px;
    font-family: inherit;
}

.azid-footer .footer-block ul li i {
    color: #b5122b;
    width: 22px;
    display: inline-block;
    text-align: center;
    font-size: 18px;
}

.azid-footer a {
    color: #222;
    text-decoration: none;
    font-size: 16px;
    transition: color 0.2s;
    font-family: inherit;
    font-weight: normal;
}

.azid-footer a:hover {
    color: #b5122b;
    text-decoration: none;
}

.azid-footer .footer-newsletter form {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    margin-top: 12px;
}

.azid-footer .footer-newsletter input[type="email"] {
    flex: 1;
    padding: 10px 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    outline: none;
    font-size: 16px;
    height: 44px;
    box-sizing: border-box;
}

.azid-footer .footer-newsletter button {
    padding: 0 24px;
    height: 44px;
    border: none;
    background: #111827;
    color: #fff;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    font-size: 16px;
    white-space: nowrap;
    transition: background 0.2s;
}

.azid-footer .footer-newsletter button:hover {
    background: #b5122b;
}

.azid-footer .footer-copyright {
    background: #b5122b;
    color: #fff;
    text-align: center;
    padding: 10px 0 8px 0;
    margin-top: 24px;
    font-size: 16px;
    letter-spacing: 0.5px;
}

@media (max-width: 1100px) {
    .azid-footer .footer-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
    }
    
    .azid-footer .footer-logo {
        grid-column: 1 / -1;
        justify-content: center;
        align-items: center;
    }
}

@media (max-width: 640px) {
    .azid-footer .footer-container {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}
</style>

<footer class="azid-footer">
    <div class="footer-container">
        <!-- Logo -->
        <div class="footer-logo">
            <img src="/storage/logos/logo-azidcar.png" alt="AZIDCAR">
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
                <li><a href="{{ route('cars.index') }}">Liste des voitures</a></li>
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
        Copyright © {{ date('Y') }} AZIDCAR
    </div>
</footer> 