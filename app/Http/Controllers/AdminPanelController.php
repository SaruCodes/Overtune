<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->get();

        $featuredReviews = Review::where('is_featured_primary', true)
            ->orWhere('is_featured_secondary', true)
            ->get();

        $reviews = Review::with('user', 'album.artist')->latest()->paginate(10);
        $reports = Report::with('user', 'reportable')->latest()->paginate(10);
        return view('admin.panel', compact('users', 'reviews', 'featuredReviews', 'reports'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $this->authorize('manage-content');
        $request->validate([
            'role' => 'required|in:user,editor,admin'
        ]);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Rol de usuario actualizado.');
    }

    public function deleteUser(User $user)
    {
        $this->authorize('manage-content');
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propio usuario.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
    }

    public function toggleFeaturedReview(Request $request, Review $review)
    {
        $this->authorize('manage-content');
        $request->validate([
            'type' => 'required|in:primary,secondary'
        ]);

        if ($request->type === 'primary') {
            Review::where('is_featured_primary', true)->update(['is_featured_primary' => false]);
            $review->is_featured_primary = true;
        } else {
            Review::where('is_featured_secondary', true)->update(['is_featured_secondary' => false]);
            $review->is_featured_secondary = true;
        }

        $review->save();

        return redirect()->back()->with('success', 'Reseña destacada actualizada.');
    }

    public function reports()
    {
        $reports = Report::latest()->paginate(10);

        return view('admin.report', compact('reports'));
    }
    public function deleteContent($id)
    {
        $report = Report::with('reportable')->findOrFail($id);
        $reportable = $report->reportable;

        if ($reportable) {
            $reportable->delete();
        }

        Report::where('reportable_type', get_class($reportable))
            ->where('reportable_id', $reportable->id)
            ->delete();

        return redirect()->back()->with('success', 'Contenido y reportes eliminados.');
    }

    public function markAsSafe($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->back()->with('success', 'Reporte marcado como seguro y eliminado.');
    }


}
