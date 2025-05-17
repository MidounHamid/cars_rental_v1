<div class="language-switcher">
    <div class="language-switcher-trigger">
        <span class="current-language">{{ strtoupper(app()->getLocale()) }}</span>
        <span class="material-symbols-rounded">expand_more</span>
    </div>
    <div class="language-switcher-dropdown">
        @foreach (['en' => 'English', 'fr' => 'Français', 'ar' => 'العربية'] as $locale => $label)
            <form action="{{ route('language.switch', ['lang' => $locale]) }}" method="POST" class="inline-form">
                @csrf
                <button type="submit" class="lang-link {{ app()->getLocale() == $locale ? 'active' : '' }}">
                    {{ $label }}
                </button>
            </form>
        @endforeach
    </div>
</div>

<style>
    .language-switcher {
        position: relative;
    }

    .language-switcher-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        z-index: 50;
    }

    .language-switcher-dropdown.active {
        display: block;
    }

    .inline-form {
        display: block;
        width: 100%;
    }

    .lang-link {
        display: block;
        width: 100%;
        text-align: left;
        padding: 8px 16px;
        background: none;
        border: none;
        cursor: pointer;
    }

    .lang-link:hover {
        background-color: #f3f4f6;
    }

    .lang-link.active {
        background-color: #e5e7eb;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const languageTrigger = document.querySelector('.language-switcher-trigger');
        const languageDropdown = document.querySelector('.language-switcher-dropdown');

        if (languageTrigger && languageDropdown) {
            languageTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                languageDropdown.classList.toggle('active');
            });

            document.addEventListener('click', function(e) {
                if (!languageTrigger.contains(e.target)) {
                    languageDropdown.classList.remove('active');
                }
            });
        }
    });
</script>
