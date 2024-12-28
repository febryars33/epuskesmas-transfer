<?php

namespace App\Concerns\Database;

trait Counter
{
    public function getRowTotal()
    {
        return $this->count();
    }
}
