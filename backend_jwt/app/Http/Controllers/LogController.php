<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Loguser;

class LogController extends Controller
{
    public function getUserLoginLogs(Request $request)
    {
        return Loguser::paginate();
    }
}
