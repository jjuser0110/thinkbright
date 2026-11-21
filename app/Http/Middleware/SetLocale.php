<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /** Languages offered in the top-bar switcher (code => label). */
    public const LOCALES = [
        'en' => 'English',
        'zh_CN' => '中文',
        'ms' => 'Bahasa Melayu',
    ];

    public function handle(Request $request, Closure $next)
    {
        $locale = $request->session()->get('locale');

        if ($locale && array_key_exists($locale, self::LOCALES)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
