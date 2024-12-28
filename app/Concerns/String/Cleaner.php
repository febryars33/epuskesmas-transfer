<?php

namespace App\Concerns\String;

use App\Helpers\String\Cleaner\Common;

trait Cleaner
{
    public function clean()
    {
        return new Common;
    }
}
