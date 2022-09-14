<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MobileApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobileAppController extends Controller
{
    public function index()
    {
        $driverApps = MobileApp::where('type', 2)->latest()->limit(6)->get();
        $salesrepApps = MobileApp::where('type', 1)->latest()->limit(6)->get();

        return view('admin.mobile-app.index', compact('driverApps', 'salesrepApps'));
    }

    public function create($type)
    {
        $version = MobileApp::where('type', $type)->max('version') + 0.1;

        return view('admin.mobile-app.create', compact('version', 'type'));
    }

    public function store(Request $request)
    {
        $path = $request->get('type') == 1 ? 'mobile-apps/salesrep' : 'mobile-apps/driver';
        $name = $request->get('version').'/'.$request->file('app')->getClientOriginalName();

        $mobileApp = new MobileApp();
        $mobileApp->type = $request->get('type');
        $mobileApp->version = $request->get('version');
        $mobileApp->comment = $request->get('comment');
        $mobileApp->path = Storage::disk('public')->putFileAs($path, $request->file('app'), $name);
        $mobileApp->save();

        return redirect()->route('admin.mobile-app.index');
    }

    public function delete(MobileApp $mobileApp)
    {
        Storage::disk('public')->delete($mobileApp->path);
        $mobileApp->delete();

        return redirect()->back();
    }

    public function download(MobileApp $mobileApp)
    {
        return Storage::disk('public')->download($mobileApp->path, 'app.apk', [
            'Content-Type' => 'application/vnd.android.package-archive',
            'Content-Disposition' => 'attachment; filename="android.apk"',
        ]);
    }
}
