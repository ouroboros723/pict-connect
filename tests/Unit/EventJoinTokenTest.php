<?php

namespace Tests\Unit;

use App\Model\EventJoinToken;
use Carbon\Carbon;
use Tests\TestCase;

class EventJoinTokenTest extends TestCase
{
    public function test_unusable_reason_covers_expiry_and_use_limit(): void
    {
        $expired = new EventJoinToken();
        $expired->expired_at = Carbon::now()->subMinute();
        $expired->use_times = 0;
        $this->assertSame('参加コードの有効期限が切れています', $expired->unusableReason());

        $spent = new EventJoinToken();
        $spent->limit_times = 1;
        $spent->use_times = 1;
        $this->assertSame('参加コードの使用回数を超えています', $spent->unusableReason());

        $open = new EventJoinToken();
        $open->use_times = 0;
        $this->assertNull($open->unusableReason());
    }
}
