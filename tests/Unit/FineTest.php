<?php

namespace Tests\Unit;

use Tests\TestCase;

class FineTest extends TestCase
{
    
    public function test_fine_is_calculated_correctly()
    {
        $finePerDay  = 50;
        $overdueDays = 3;

        $fine = $overdueDays * $finePerDay;

        $this->assertEquals(150, $fine);
    }

    
    public function test_no_fine_when_returned_on_time()
    {
        $finePerDay  = 50;
        $overdueDays = 0;

        $fine = $overdueDays * $finePerDay;

        $this->assertEquals(0, $fine);
    }

   
    public function test_fine_is_never_negative()
    {
        $finePerDay  = 50;
        $overdueDays = 0;

        $fine = $overdueDays * $finePerDay;

        $this->assertGreaterThanOrEqual(0, $fine);
    }
}