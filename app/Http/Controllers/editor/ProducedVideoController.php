<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\ContentPlan;
use App\Models\ProducedVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProducedVideoController extends Controller
{
    public function create(ContentPlan $content)
    {
        // Izinkan upload jika:
        // - Baru selesai review plan (done)
        // - Atau sedang revisi video
        if (!in_array($content->status, ['done', 'video_revision'])) {
            abort(403);
        }

        return view('editor.video.index', compact('content'));
    }

    public function store(Request $request, ContentPlan $content)
    {
        if (!in_array($content->status, ['done', 'video_revision'])) {
            abort(403);
        }

        $request->validate([
            'video' => 'required|mimes:mp4,mov,avi|max:51200',
            'notes' => 'nullable|string',
        ], [
            'video.mimes' => 'file harus berformat mp4, mov, atau avi.',
            'video.max' => 'ukuran file melebihi batas maksimal.',
        ]);

        $path = $request->file('video')->store('produced_videos', 'public');

        // Jika sudah ada video sebelumnya → update
        if ($content->producedVideo) {

            // Hapus file lama (opsional tapi bagus)
            if (Storage::disk('public')->exists($content->producedVideo->video_path)) {
                Storage::disk('public')->delete($content->producedVideo->video_path);
            }

            $content->producedVideo->update([
                'video_path' => $path,
                'notes' => $request->notes,
                'uploaded_at' => now(),
            ]);

        } else {

            ProducedVideo::create([
                'content_plan_id' => $content->id,
                'video_path' => $path,
                'notes' => $request->notes,
                'uploaded_at' => now(),
            ]);
        }

        // Setelah upload / revisi → kembali ke status video_uploaded
        $content->update([
            'status' => 'video_uploaded',
        ]);

        return redirect()
            ->route('editor.contents.index')
            ->with('success', 'Video berhasil diupload');
    }
}
