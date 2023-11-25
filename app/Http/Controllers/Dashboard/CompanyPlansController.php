<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CompanyPlans;
use Illuminate\Http\Request;

class CompanyPlansController extends Controller
{
    public function __construct()
    {
        $this->middleware(["permission:company_plans_update,guard:admin"])->only(["edit", "update"]);
        $this->middleware(["permission:company_plans_read,guard:admin"])->only("index");
    }

    public function index()
    {
        $plans = CompanyPlans::all();
        return view("dashboard.company_plans.show", ["plans" => $plans]);
    }

    public function edit($id)
    {
        $plan = CompanyPlans::findOrFail($id);
        return view("dashboard.company_plans.edit", compact("plan"));
    }

    public function update(Request $request, $id)
    {
        $plan = CompanyPlans::findOrFail($id);
        $request->validate([
            "property_num" => "required|integer|min:1",
            "special_property_num" => "required|integer|min:1",
            "facebook_ads_num" => "required|integer|min:1",
            "price" => "required|integer|min:1",
            "last_price" => "required|integer|min:1",
            "header_appear_days" => !empty($request->header_appear_days) ? "integer|min:1" : "",
            "slider_appear_days" => !empty($request->slider_appear_days) ? "integer|min:1" : "",
            "youtube_ads_num" => !empty($request->youtube_ads_num) ? "integer|min:1" : "",
            "google_ads_num" => !empty($request->google_ads_num) ? "integer|min:1" : "",
        ]);
        $plan->update([
            "property_num" => $request->property_num,
            "special_property_num" => $request->special_property_num,
            "facebook_ads_num" => $request->facebook_ads_num,
            "price" => $request->price,
            "last_price" => $request->last_price,
            "header_appear_days" => $request->header_appear_days ?? null,
            "slider_appear_days" => $request->slider_appear_days ?? null,
            "youtube_ads_num" => $request->youtube_ads_num ?? null,
            "google_ads_num" => $request->google_ads_num ?? null,
        ]);
        return redirect()->back()->with("success", "تم تعديل بيانات الباقة");
    }
}
