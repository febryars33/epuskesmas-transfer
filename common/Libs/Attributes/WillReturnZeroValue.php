<?php

namespace Common\Libs\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class WillReturnZeroValue
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function show()
    {
        return 'show';
    }
}
