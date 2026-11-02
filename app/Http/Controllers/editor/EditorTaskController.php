<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\ContentPlan;

class EditorTaskController extends Controller
{
    /**
     * Riwayat task editor
     */
    public function history()
    {
        $tasks = ContentPlan::with('editorContent')
            ->whereHas('editorContent') // hanya yang sudah dikerjakan editor
            ->orderByDesc('updated_at')
            ->get();

        return view('editor.tasks.index', compact('tasks'));
    }

    /**
     * Detail task editor
     */
    public function show(ContentPlan $contentPlan)
    {
        $contentPlan->load('editorContent', 'asset', 'producedVideo');

        return view('editor.tasks.show', [
            'content' => $contentPlan
        ]);
    }

    /**
     * Cetak laporan mingguan
     */
    public function printReport(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $tasks = ContentPlan::with(['editorContent', 'analytics'])
            ->whereHas('editorContent')
            ->where('status', 'published')
            ->whereBetween('posting_date', [$startDate, $endDate])
            ->orderBy('posting_date', 'asc')
            ->get();

        return view('editor.tasks.print', compact('tasks', 'startDate', 'endDate'));
    }
}
