<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\MobileApp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MobileAppController extends Controller
{
    function index()
    {

        $driverApps = MobileApp::where('type',2)->latest()->limit(6)->get();
        $salesrepApps = MobileApp::where('type',1)->latest()->limit(6)->get();
        return view('admin.mobile-app.index',compact('driverApps','salesrepApps'));
    }
    function create($type)
    {
        $version = MobileApp::where('type',$type)->max('version') + 0.1;
        return view('admin.mobile-app.create',compact('version','type'));
    }
    function store(Request $request)
    {
        $mobileApp = new MobileApp();
        $mobileApp->type = $request->get('type');
        $mobileApp->version = $request->get('version');
        $mobileApp->comment = $request->get('comment');
        $mobileApp->path = Storage::disk('public')
            ->putFileAs('mobile-apps',$request->file('app'),$request->get('version').'/'.$request->file('app')->getClientOriginalName());
        $mobileApp->save();
        return redirect()->route('admin.mobile-app.index');

    }

    function delete(MobileApp $mobileApp)
    {
        Storage::disk('public')->delete($mobileApp->path);
        $mobileApp->delete();

        return redirect()->back();
    }
    function download(MobileApp $mobileApp)
    {
        return Storage::disk('public')->download($mobileApp->path);
    }

}
