<?php

if (!function_exists('categoryTypeFa')) {
    function categoryTypeFa($type)
    {
        return [
            'person' => 'اشخاص',
            'product' => 'کالا',
            'service' => 'خدمات',
        ][$type] ?? $type;
    }
}
