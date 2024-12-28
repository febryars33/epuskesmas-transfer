<?php

namespace App\Helpers\String\Cleaner;

class Common
{
    public function nik(string $string): string
    {
        $space = str_replace(' ', '', $string);

        if (strlen($space) >= 16) {
            return $space;
        }

        return '-';
    }

    public function gender(string $string): string
    {
        $valid = ['Pria', 'Wanita'];

        if (in_array($string, $valid)) {
            if ($string === 'Pria') {
                return '1';
            }

            if ($string === 'Wanita') {
                return '0';
            }
        }

        return '-';
    }

    public function ucwords(string $string): string
    {
        return ucwords(strtolower($string));
    }
}
