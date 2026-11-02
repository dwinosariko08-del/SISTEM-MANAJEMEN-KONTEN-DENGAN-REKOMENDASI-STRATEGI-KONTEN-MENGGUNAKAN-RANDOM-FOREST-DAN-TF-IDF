<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\ContentPlan;
use App\Models\EditorContent;
use Illuminate\Http\Request;

class EditorContentController extends Controller
{
    /**
     * LIST KONTEN UNTUK EDITOR
     */
public function index()
{
    $contents = ContentPlan::with(['asset', 'producedVideo'])
        ->whereIn('status', [
            'assigned',
            'on_progress',
            'revision',
            'done',
            'video_uploaded',   // ✅ TAMBAHAN
            'video_revision',   // ✅ TAMBAHAN (kalau leader minta revisi)
        ])
        ->latest()
        ->get();

    return view('editor.contents.index', compact('contents'));
}



    /**
     * FORM KERJA EDITOR
     */
    public function create(ContentPlan $content)
    {
        // ❌ Tidak boleh kerjakan kalau sedang menunggu review
        if ($content->status === 'on_progress') {
            abort(403, 'Konten sedang menunggu review leader');
        }

        $editorContent = $content->editorContent;

        $hook = '';
        $body = '';
        $closing = '';

        if ($editorContent && $editorContent->script_brief) {
            preg_match('/HOOK:\n(.*?)\n\nBODY:/s', $editorContent->script_brief, $hookMatch);
            preg_match('/BODY:\n(.*?)\n\nCLOSING:/s', $editorContent->script_brief, $bodyMatch);
            preg_match('/CLOSING:\n(.*)/s', $editorContent->script_brief, $closingMatch);

            $hook = trim($hookMatch[1] ?? '');
            $body = trim($bodyMatch[1] ?? '');
            $closing = trim($closingMatch[1] ?? '');

            if (empty($hook) && empty($body) && empty($closing)) {
                $body = $editorContent->script_brief;
            }
        }

        return view('editor.contents.create', compact('content', 'editorContent', 'hook', 'body', 'closing'));
    }

    /**
     * SIMPAN HASIL KERJA EDITOR
     */
   public function store(Request $request, ContentPlan $content)
{
    $request->validate([
        'post_type'      => 'required|string',
        'content_title'  => 'required|string',
        'hook'           => 'required|string',
        'body'           => 'required|string',
        'closing'        => 'required|string',
        'caption'        => 'required|string',
        'editor_name'    => 'required|string',
        'thumbnail'      => 'nullable|image|max:2048',
    ]);

    // 🔥 Upload thumbnail
    $thumbnailPath = null;

    if ($request->hasFile('thumbnail')) {
        $thumbnailPath = $request->file('thumbnail')
            ->store('thumbnails', 'public');
    }

    // 🔥 Gabungkan script jadi 1 kolom (tanpa ubah DB)
    $scriptBrief =
        "HOOK:\n" . $request->hook . "\n\n" .
        "BODY:\n" . $request->body . "\n\n" .
        "CLOSING:\n" . $request->closing;

    EditorContent::updateOrCreate(
        ['content_plan_id' => $content->id],
        [
            'post_type'        => $request->post_type,
            'content_title'    => $request->content_title,
            'script_brief'     => $scriptBrief,
            'reference'        => $request->reference,
            'caption'          => $request->caption,
            'hashtag'          => $request->hashtag,
            'talent'           => $request->talent,
            'editor_name'      => $request->editor_name,
            'preview_thumbnail'=> $thumbnailPath,
        ]
    );

    $content->update([
        'status' => 'on_progress'
    ]);

    return redirect()
        ->route('editor.contents.index')
        ->with('success', 'Konten berhasil dikirim, menunggu review leader');
}

}
