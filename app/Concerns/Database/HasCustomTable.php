<?php

namespace App\Concerns\Database;

trait HasCustomTable
{
    /**
     * Setup the model for a custom table.
     */
    protected function setupCustomTable(): void
    {
        $this->setKeyType('string');

        $this->setIncrementing(false);
    }
}
