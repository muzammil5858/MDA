<?php

namespace App\Http\Controllers;

use App\Models\PlotHistory;
use Illuminate\Http\Request;

class PlotHistoryController extends Controller
{
    public function store(Request $request, $propertyId)
    {
        $data = $request->validate([
            'name'         => 'nullable|string',
            'id_card'     => 'nullable',
            'challan_no' => 'nullable',
        ]);

        $data['property_id'] = $propertyId;

        $plotHistory = PlotHistory::create($data);

        return response()->json(['status' => 'added', 'data' => $plotHistory]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'         => 'nullable|string',
            'id_card'     => 'nullable',
            'challan_no' => 'nullable',
        ]);

        $plotHistory = PlotHistory::findOrFail($id);
        $plotHistory->update($data);

        return response()->json(['status' => 'updated']);
    }

    public function destroy($id)
    {
        PlotHistory::findOrFail($id)->delete();
        return response()->json(['status' => 'deleted']);
    }
}
