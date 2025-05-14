<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{

    /**
     * Switch the application language
     *
     * @param string $lang Language code (en, fr, ar)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($lang)
    {
        // Available languages
        $availableLangs = ['en', 'fr', 'ar'];
        
        // Check if the language is supported
        if (in_array($lang, $availableLangs)) {
            // Store selected language in session
            Session::put('locale', $lang);
            
            // Set application locale
            App::setLocale($lang);
            
            // Set the direction for RTL languages (for immediate effect)
            if ($lang === 'ar') {
                Session::put('direction', 'rtl');
            } else {
                Session::put('direction', 'ltr');
            }
        }
        
        // Redirect back to the previous page
        return redirect()->back()->with('language_switched', true);
    }
}
