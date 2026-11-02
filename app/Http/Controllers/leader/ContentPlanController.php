<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\ContentPlan;
use App\Models\Asset;
use Illuminate\Http\Request;

class ContentPlanController extends Controller
{
    public function index()
    {
        $contents = ContentPlan::with(['asset','editorContent','producedVideo'])
            ->latest()
            ->get();

        return view('leader.contents.index', compact('contents'));
    }

    public function create()
    {
        $assets = Asset::latest()->get();
        return view('leader.contents.create', compact('assets'));
    }

    public function show(ContentPlan $content)
    {
        $content->load([
            'asset',
            'editorContent.user',
            'producedVideo'
        ]);

        return view('leader.contents.show', compact('content'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'posting_date' => 'required|date',
            'pillar' => 'required',
            'topic' => 'required',
            'asset_id' => 'nullable|exists:assets,id',
            'notes_for_creator' => 'nullable',
        ]);

        ContentPlan::create([
            'posting_date' => $request->posting_date,
            'pillar' => $request->pillar,
            'topic' => $request->topic,
            'asset_id' => $request->asset_id,
            'notes_for_creator' => $request->notes_for_creator,
            'status' => 'assigned',
            'approved' => null,
        ]);

        return redirect()->route('leader.contents.index');
    }

    public function edit(ContentPlan $content)
    {
        if ($content->editorContent) {
            abort(403, 'Konten sudah dikerjakan editor');
        }

        $assets = Asset::latest()->get();
        return view('leader.contents.edit', compact('content','assets'));
    }

    public function update(Request $request, ContentPlan $content)
    {
        if ($content->editorContent) {
            abort(403, 'Konten sudah dikerjakan editor');
        }

        $content->update($request->only([
            'posting_date',
            'pillar',
            'topic',
            'asset_id',
            'notes_for_creator',
        ]));

        return redirect()->route('leader.contents.index');
    }

    public function destroy(ContentPlan $content)
    {
        if ($content->editorContent) {
            abort(403, 'Konten sudah dikerjakan editor');
        }

        $content->delete();
        return redirect()->route('leader.contents.index');
    }

    /* =====================================================
       REVIEW KONTEN
    ===================================================== */

    public function reviewForm(ContentPlan $content)
    {
        // Boleh review kalau sedang dikerjakan atau revisi
        if (!in_array($content->status, ['on_progress', 'revision'])) {
            abort(403);
        }

        return view('leader.contents.review', compact('content'));
    }

    public function review(Request $request, ContentPlan $content)
    {
        if (!in_array($content->status, ['on_progress', 'revision'])) {
            abort(403);
        }

        $request->validate([
            'approved' => 'required|boolean',
            'revision_notes' => 'nullable|required_if:approved,0',
        ], [
            'revision_notes.required_if' => 'Revision Notes wajib diisi jika memilih revisi.',
        ]);

        if ($request->approved) {

            $content->update([
                'approved' => true,
                'status' => 'done',
                'revision_notes' => null,
            ]);

        } else {

            $content->update([
                'approved' => false,
                'status' => 'revision',
                'revision_notes' => $request->revision_notes,
            ]);
        }

        return redirect()->route('leader.contents.index')
            ->with('success','Review konten berhasil');
    }

    /* =====================================================
       REVIEW VIDEO
    ===================================================== */

    public function reviewVideoForm(ContentPlan $content)
    {
        // Boleh review kalau video baru upload atau revisi video
        if (!in_array($content->status, ['video_uploaded', 'video_revision'])) {
            abort(403);
        }

        return view('leader.contents.review-video', compact('content'));
    }

    public function reviewVideo(Request $request, ContentPlan $content)
    {
        if (!in_array($content->status, ['video_uploaded', 'video_revision'])) {
            abort(403);
        }

        $request->validate([
            'approved' => 'required|boolean',
            'video_revision_notes' => 'nullable|required_if:approved,0',
        ], [
            'video_revision_notes.required_if' => 'Video Revision Notes wajib diisi jika memilih revisi.',
        ]);

        if ($request->approved) {

            $content->update([
                'status' => 'published',
                'video_revision_notes' => null,
            ]);

        } else {

            $content->update([
                'status' => 'video_revision',
                'video_revision_notes' => $request->video_revision_notes,
            ]);
        }

        return redirect()->route('leader.contents.index')
            ->with('success','Review video berhasil');
    }
}
