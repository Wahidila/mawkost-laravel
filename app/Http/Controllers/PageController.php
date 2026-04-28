<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function tentang()
    {
        $teamMembers = TeamMember::orderBy('sort_order')->orderBy('id')->get();
        return view('tentang', compact('teamMembers'));
    }

    public function tos()
    {
        return view('tos');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function refund()
    {
        return view('refund');
    }
}
