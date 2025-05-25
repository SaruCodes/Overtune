<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:reviews,id',
            'reason' => 'nullable|string|max:1000',
        ]);

        Report::create([
            'user_id' => auth()->id(),
            'review_id' => $request->review_id,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Reporte enviado con éxito');
    }

}
