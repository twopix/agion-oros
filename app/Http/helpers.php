<?php 

use Illuminate\Http\Request;

if(!function_exists('getLocales'))
{
    function getLocales()
    {
        $translations = config('filament-translations.locals');
        $locals = [];
        foreach ($translations as $key => $value) {
            $locals[] = $key;
        }
        unset($translations);

        return $locals;
    }
}

if(!function_exists('getPrefix'))
{
    function getPrefix()
    {
        $locals = getLocales();
        $segment = Request::capture()->segment(1);
        if(in_array($segment, $locals)) return $segment;
        return '';
    }
}