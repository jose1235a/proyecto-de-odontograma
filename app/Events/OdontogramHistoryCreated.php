<?php

namespace App\Events;

use App\Models\OdontogramHistory;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OdontogramHistoryCreated
{
    use Dispatchable, SerializesModels;

    public OdontogramHistory $odontogramHistory;

    public function __construct(OdontogramHistory $odontogramHistory)
    {
        $this->odontogramHistory = $odontogramHistory;
    }
}