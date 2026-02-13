<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Mcamara\LaravelLocalization\Exceptions\SupportedLocalesNotDefined;
use Mcamara\LaravelLocalization\Exceptions\UnsupportedLocaleException;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageController extends Controller
{
    /**
     * @param string $locale
     * @return RedirectResponse
     * @throws SupportedLocalesNotDefined
     * @throws UnsupportedLocaleException
     */
    public function switch(string $locale): RedirectResponse
    {
        $supported = array_keys(LaravelLocalization::getSupportedLocales());

        if (!in_array($locale, $supported)) {
            $locale = config('app.locale');
        }

        $url = LaravelLocalization::getLocalizedURL($locale, url()->previous());

        return redirect($url);
    }
}
