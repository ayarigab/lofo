<?php

if (!function_exists('assetV')) {
    function assetV($path)
    {
        return app('url')->asset($path) . '?v=' . config('naaba.version', '1.0.0');
    }
}

if (!function_exists('langShort')) {
    function langShort(){
        $lang = 'en';
        if (app()->getLocale() === 'zh-CN') {
            $lang = 'zh';
        } elseif (app()->getLocale() === 'vi') {
            $lang = 'vn';
        } else {
            $lang = app()->getLocale();
        }
        return $lang;
    }
}
