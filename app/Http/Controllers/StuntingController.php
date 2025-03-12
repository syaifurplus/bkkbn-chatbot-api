<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StuntingData;

class StuntingController extends Controller {
    
    // Get National Overview
    public function nationalOverview(Request $request) {
        $year = $request->input('year', date('Y'));
        $stuntingRate = StuntingData::where('year', $year)->avg('stunting_rate');

        $message = "Angka stunting nasional tahun $year adalah " . number_format($stuntingRate, 2) . "%.";

        return response()->json([
            "fulfillmentText" => $message
        ]);
    }

    // Get Data by Region
    public function byRegion(Request $request) {
        $province = $request->input('province');
        $district = $request->input('district');
        $year = $request->input('year', date('Y'));

        $query = StuntingData::where('year', $year)->where('province', $province);
        if ($district) $query->where('district', $district);

        $data = $query->first();

        if (!$data) {
            return response()->json([
                "fulfillmentText" => "Maaf, saya tidak menemukan data stunting untuk wilayah tersebut."
            ]);
        }

        $message = "Angka stunting di " . ($district ? "$district, " : "") . "$province tahun $year adalah " . number_format($data->stunting_rate, 2) . "%.";

        return response()->json([
            "fulfillmentText" => $message,
            "outputContexts" => [
                [
                    "name" => "projects/{PROJECT_ID}/agent/sessions/{SESSION_ID}/contexts/stunting_by_region",
                    "lifespanCount" => 2,
                    "parameters" => [
                        "province" => $province,
                        "district" => $district,
                        "year" => $year
                    ]
                ]
            ]
        ]);
    }

    // Get Trend Data
    public function trend(Request $request) {
        $province = $request->input('province');
        $years = StuntingData::where('province', $province)
            ->orderBy('year', 'asc')
            ->get(['year', 'stunting_rate']);

        if ($years->isEmpty()) {
            return response()->json([
                "fulfillmentText" => "Saya tidak menemukan data tren stunting untuk $province."
            ]);
        }

        $trendMessage = "Berikut tren stunting di $province: ";
        foreach ($years as $year) {
            $trendMessage .= "\n- Tahun " . $year->year . ": " . number_format($year->stunting_rate, 2) . "%";
        }

        return response()->json([
            "fulfillmentText" => $trendMessage
        ]);
    }

    // Get Real-time Data
    public function realtime() {
        $latestData = StuntingData::orderBy('year', 'desc')->first();

        if (!$latestData) {
            return response()->json([
                "fulfillmentText" => "Data stunting real-time belum tersedia saat ini."
            ]);
        }

        return response()->json([
            "fulfillmentText" => "Angka stunting terbaru di " . $latestData->province . " adalah " . number_format($latestData->stunting_rate, 2) . "% (tahun " . $latestData->year . ")."
        ]);
    }

    // Get Target Data
    public function target(Request $request) {
        $province = $request->input('province');
        $year = $request->input('year', date('Y'));

        $data = StuntingData::where('year', $year)->where('province', $province)->first(['target_rate']);

        if (!$data) {
            return response()->json([
                "fulfillmentText" => "Saya tidak menemukan target penurunan stunting untuk $province di tahun $year."
            ]);
        }

        return response()->json([
            "fulfillmentText" => "Target penurunan angka stunting di $province untuk tahun $year adalah " . number_format($data->target_rate, 2) . "%."
        ]);
    }
}
