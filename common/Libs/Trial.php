<?php

namespace Common\Libs;

use Common\Libs\Attributes\WillReturnZeroValue;

class Trial
{
    #[WillReturnZeroValue]
    public function show()
    {
        return true;
    }
}
