<?php

namespace App\Http\Services\Auth\Tenant;
use App\Actions\CreateTenantAction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TenantService
{
    public function create($request)
    {
        return view('auth.tenant.create');
    }
    public function store($request)
    {
        return $this->createClient($request);
    }
    public function createClient($request)
    {
        DB::beginTransaction();
        try {
            $user = User::create($this->request_data($request));
            $user->assignRole(User::CLIENT_ROLE);
            DB::commit();
            $this->createSubdomain($user,$request->domain);
            $user->update(['domain_name' => $request->domain]);
            return redirect()->back()->with('success',__('Client has been created successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            logger($e->getMessage());//TODO: integrate with sentry or something like that
            return redirect()->back()->with('error',__('Something went wrong.'));
        }
    }
    public function createSubdomain($user,$domain)
    {
        return (new CreateTenantAction)
        (
            domain: $domain,
            user: $user,
        );
    }
    public function request_data($request)
    {
        $data = $request->only(['email','name']);
        $data['password'] = createPassword($request->password);
        return $data;
    }
}
