<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryLog;

class ICTController extends Controller
{
    public function index()
    {
        return view('ict.dashboard');
    }

    public function events()
    {
        $data = InventoryLog::all();

        return response()->json($data->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->item_name . ' - ' . $item->borrower,
                'start' => $item->out_date,
                'end' => $item->return_date,
            ];
        }));
    }

    public function store(Request $request)
    {
        InventoryLog::create([
            'item_name' => $request->item_name,
            'borrower' => $request->borrower,
            'department' => $request->department,
            'position' => $request->position,
            'purpose' => $request->purpose,
            'out_date' => $request->out_date,
            'return_date' => $request->return_date,
        ]);

        return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
        InventoryLog::findOrFail($id)->delete();

        return response()->json(['status' => 'deleted']);
    }
}