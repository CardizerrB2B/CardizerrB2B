<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TestingEvent;

class TestEventController extends Controller
{
    public function testEvent()
    {
        event(new TestingEvent);
        return 'Event has been sent!';
    }
}
