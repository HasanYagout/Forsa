<?php

namespace App\Helpers;

class Location
{
    public static function cities()
    {
        $cities =[
            "Sana'a",
            'Aden',
            'Taiz',
            'Al Hudaydah',
            'Hadhramaut',
            'Ibb',
            'Dhamar',
            'Amran',
            'Abyan',
            'Al Bayda',
            "Sa'dah",
            'Marib',
            'Al Mahwit',
            'Al Mahrah',
            'Al Jawf',
            'Raymah',
            "Al Dhale'e",
            'Socotra',
            'Lahj',
            'Shabwah',
            'Hajjah',
            'Yemen',
            'Multiple Cities',
        ];
         return array_combine($cities, $cities);

    }
}
