<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    protected $availableLangs = ['en', 'fr', 'ar'];

    /**
     * Switch the application language
     *
     * @param string $lang Language code (en, fr, ar)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($lang)
    { $available = ['en', 'fr', 'ar'];
        if (in_array($lang, $available)) {
            Session::put('locale', $lang);
            App::setLocale($lang);
        }

        return redirect()->back();
    }

    /**
     * Test the application locale
     *
     * @return array
     */
    public function testLocale()
    {
        $locale = session('locale', config('app.fallback_locale', 'en'));
        App::setLocale($locale);

        return [
            'app_locale' => App::getLocale(),
            'session_locale' => session('locale'),
            'direction' => session('direction'),
            'locale_applied' => __('messages.home'),
            'debug' => [
                'default_locale' => config('app.locale'),
                'fallback_locale' => config('app.fallback_locale'),
                'all_session' => session()->all()
            ]
        ];
    }
}
