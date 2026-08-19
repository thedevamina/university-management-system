<?php
namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // ← yeh method missing tha
    public function index()
    {
        $faculty   = Auth::user()->facultyProfile;
        $documents = $faculty->documents()->latest()->get();

        return view('faculty.documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $faculty  = Auth::user()->facultyProfile;
        $file     = $request->file('document');
        $path     = $file->store('documents/faculty', 'public');
        $fileName = $file->getClientOriginalName();

        $faculty->documents()->create([
            'file_name' => $fileName,
            'file_path' => $path,
        ]);

        return back()->with('success', 'Document uploaded successfully!');
    }

    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted successfully!');
    }
}