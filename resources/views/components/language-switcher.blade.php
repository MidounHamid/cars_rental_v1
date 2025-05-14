<div class="language-switcher">
    <div class="language-switcher-trigger">
        <span class="current-language">{{ strtoupper(app()->getLocale()) }}</span>
        <span class="material-symbols-rounded">expand_more</span>
    </div>
    <div class="language-switcher-dropdown">
        <a href="{{ route('language.switch', 'en') }}" class="lang-link {{ app()->getLocale() == 'en' ? 'active' : '' }}">
            English
        </a>
        <a href="{{ route('language.switch', 'fr') }}" class="lang-link {{ app()->getLocale() == 'fr' ? 'active' : '' }}">
            Français
        </a>
        <a href="{{ route('language.switch', 'ar') }}" class="lang-link {{ app()->getLocale() == 'ar' ? 'active' : '' }}">
            العربية
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Language switcher dropdown functionality
        const languageTrigger = document.querySelector('.language-switcher-trigger');
        const languageDropdown = document.querySelector('.language-switcher-dropdown');

        if (languageTrigger && languageDropdown) {
            languageTrigger.addEventListener('click', function (e) {
                e.stopPropagation();
                languageDropdown.classList.toggle('active');
            });

            // Make the language links work without JS
            const langLinks = document.querySelectorAll('.lang-link');
            langLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // We don't need to do anything special here as the links will navigate to the language.switch route
                    // This is just to ensure the dropdown closes after clicking
                    languageDropdown.classList.remove('active');
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!languageTrigger.contains(e.target)) {
                    languageDropdown.classList.remove('active');
                }
            });
        }
    });
</script>
