<?php
namespace App\Classes\Theme;

class Web
{
    /**
     * Convert css file path to RTL file
     */
    public static function rtlCssPath($css_path)
    {
        $css_path = substr_replace($css_path, 'css/rtl-', 0 , 4);

        return $css_path;
    }

    /**
     * Prints Google Fonts
     */
    public static function getGoogleFontsInclude()
    {
        if (config('layout.resources.fonts.google.families')) {
            $fonts = config('layout.resources.fonts.google.families');
            echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=' . implode('|', $fonts) . '">';
        }
        echo '';
    }

    // public static function printClasses($scope, $full = true)
    // {
    //     if ($scope == 'body') {
    //         self::$classes[$scope][] = 'page-loading';
    //     }

    //     if (isset(self::$classes[$scope]) && !empty(self::$classes[$scope])) {
    //         $classes = implode(' ', self::$classes[$scope]);
    //         if ($full) {
    //             echo ' class="' . $classes . '" ';
    //         } else {
    //             echo ' ' . $classes . ' ';
    //         }
    //     } else {
    //         echo '';
    //     }
    // }


    /**
     * Initialize theme CSS files
     */
    public static function initThemes()
    {
        $themes = [
            'css/theme.css',
            'css/theme-elements.css',
            'css/theme-blog.css',
            'css/theme-shop.css',

        ];
        return $themes;
    }

    /**
     * Initialize custome theme CSS files
     */
    public static function customThemes()
    {

        $themes = [
            'vendor/rs-plugin/css/settings.css',
            'vendor/rs-plugin/css/layers.css',
            'vendor/rs-plugin/css/navigation.css',
            'vendor/circle-flip-slideshow/css/component.css',
            'css/skins/default.css',
            'css/custom.css',
        ];
        return $themes;
    }


}
