<?php

if (!function_exists('assetV')) {
    function assetV($path)
    {
        return app('url')->asset($path) . '?v=' . config('naaba.version', '1.0.0');
    }
}
