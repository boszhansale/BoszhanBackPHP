<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CounteragentResource;
use App\Models\Brand;
use App\Models\MobileApp;
use App\Models\MobileAppDownload;
use App\Models\PaymentStatus;
use App\Models\PaymentType;
use App\Models\ReasonRefund;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ListController extends Controller
{
    public function brand(): JsonResponse
    {
        $brands = Brand::with('categories')
            ->where('enabled', 1)
            ->orderBy('sort_position')
            ->get();

        return response()->json($brands);
    }

    public function status(): JsonResponse
    {
        return response()->json(Status::all());
    }

    public function paymentType(): JsonResponse
    {
        return response()->json(PaymentType::all());
    }

    public function paymentStatus(): JsonResponse
    {
        return response()->json(PaymentStatus::all());
    }

    public function counteragent(): JsonResponse
    {
        $counteragents = Auth::user()->counteragents()->with(['priceType', 'paymentType'])->get();

        return response()->json(CounteragentResource::collection($counteragents));
    }

    public function mobileApp(Request $request)
    {
        $app = MobileApp::whereType($request->get('type'))->orderBy('version', 'desc')->firstOrFail();

        return response()->json($app);
    }

    public function mobileAppDownload(Request $request)
    {
        $app = MobileApp::whereType($request->get('type'))->orderBy('version', 'desc')->firstOrFail();
        MobileAppDownload::updateOrCreate([
            'ip' => $request->ip(),
            'mobile_app_id' => $app->id,
        ], [
            'ip' => $request->ip(),
            'mobile_app_id' => $app->id,
        ]);

        return Storage::disk('public')->download($app->path, 'app.apk', [
            'Content-Type' => 'application/vnd.android.package-archive',
            'Content-Disposition' => 'attachment; filename="android.apk"',
        ]);
//       return response()->download(Storage::download($app->path),'app.apk');
    }

    public function reasonRefund(): JsonResponse
    {
        return response()->json(ReasonRefund::all());
    }
}
