<?php

namespace App\Http\Controllers\Tenant\Dashboard\Member;
use App\Http\Controllers\Controller;

use App\Models\Member;
use Illuminate\Http\Request;


class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = $this->getMembers($request);
        return view('tenant_dashboard.dashboard.member.index',compact('members'));
    }
    public function getMembers($request)
    {
        return Member::orderBy('id','desc')
        ->whenSearch($request['search'] ?? null)
        ->paginate(config('application.perPage',10));
    }
}
