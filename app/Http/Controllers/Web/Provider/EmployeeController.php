<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = $request->user()->serviceProvider->employees()->latest()->get();

        return view('provider.employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string'],
            'job_title' => ['nullable', 'string'],
        ]);

        $request->user()->serviceProvider->employees()->create($data);

        return back()->with('status', 'Employee added.');
    }

    public function destroy(\App\Models\ProviderEmployee $employee, Request $request)
    {
        abort_unless($employee->service_provider_id === $request->user()->serviceProvider->id, 403);
        $employee->delete();

        return back()->with('status', 'Employee removed.');
    }
}
