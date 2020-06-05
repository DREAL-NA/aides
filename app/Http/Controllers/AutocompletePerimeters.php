<?php

namespace App\Http\Controllers;

use App\Perimeter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AutocompletePerimeters extends Controller
{

    private static $_cachekey = 'autocomplete/perimeters/';

    public static function autocomplete(Request $request)
    {
        $query = $request->get('query');
        if ($query)
        {
            if (Cache::has(AutocompletePerimeters::$_cachekey . $query))
            {
                return Cache::get(AutocompletePerimeters::$_cachekey . $query);
            }
            else
            {
                // Retrieve from the cache, but if don't exist in cache, add it.
                $perimeters = Cache::rememberForever(AutocompletePerimeters::$_cachekey . $query, function() use($query)
                {
                    return Perimeter::where([
                        ['name', 'LIKE', "%{$query}%"],
                        ['type', '<>', 'Commune']
                    ])->take(5)->get();
                });
                return $perimeters;
            }
        }
        else
        {
            return [];
        } 
    }
}
