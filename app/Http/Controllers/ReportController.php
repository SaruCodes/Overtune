<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store($type, $id)
    {
        $modelMap = [
            'comments' => \App\Models\Comment::class,
            'reviews' => \App\Models\Review::class,
        ];

        if (!isset($modelMap[$type])) {
            return response()->json(['message' => 'Tipo de contenido no válido.'], 400);
        }

        $model = $modelMap[$type]::findOrFail($id);
        $alreadyReported = $model->reports()->where('user_id', auth()->id())->exists();

        if ($alreadyReported) {
            return response()->json(['message' => 'Ya reportaste este contenido.'], 409);
        }

        $model->reports()->create([
            'user_id' => auth()->id()
        ]);

        return response()->json(['message' => 'Reporte enviado con éxito.']);
    }

}

