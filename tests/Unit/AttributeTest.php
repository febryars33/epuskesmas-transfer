<?php

namespace Tests\Unit;

use Common\Libs\Attributes\WillReturnZeroValue;
use Common\Libs\Trial;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    #[WillReturnZeroValue(1)]
    public function test_example(): void
    {
        $trial = new Trial;
        dd($trial->show());
        // $this->assertTrue(true);
    }
}
