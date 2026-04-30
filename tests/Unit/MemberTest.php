<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_be_created()
    {

        $member = Member::factory()->create();

        $this->assertDatabaseHas('members', [
            'id' => $member->id,
        ]);
    }

    public function test_membership_number_starts_with_mbr()
    {
        $member = Member::factory()->create();

      
        $this->assertStringStartsWith('MBR', $member->membership_no);
    }

    public function test_member_belongs_to_user()
    {
        $member = Member::factory()->create();

      
        $this->assertNotNull($member->user);
    }
}