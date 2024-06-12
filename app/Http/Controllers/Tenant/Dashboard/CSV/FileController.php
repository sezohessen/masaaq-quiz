<?php

namespace App\Http\Controllers\Tenant\Dashboard\CSV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $files = Storage::disk('public')->files('exports');
        if ($files && $request->filled('download')) {
            return $this->downloadFile($request->input('download'));
        }
        return view('tenant_dashboard.dashboard.csv.index', compact('files'));
    }
    private function downloadFile($fileName)
    {
        try {
            $filePath = 'exports/' . $fileName;
            // Check if the file exists in the specified path
            if (Storage::disk('public')->exists($filePath)) {
                // Download the file
                return Storage::disk('public')->download($filePath);
            } else {
                return redirect()->back()->with('error', 'File not found.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while downloading the file.');
        }
    }
}
