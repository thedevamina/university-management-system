<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

// Yeh method add karo
public function index()
{
    $student   = Auth::user()->studentProfile;
    $documents = $student->documents()->latest()->get();

    return view('student.documents.index', compact('documents'));
}
    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        // Login student ka profile
        $student = Auth::user()->studentProfile;

        $file     = $request->file('document');
        $path     = $file->store('documents/students', 'public');
        $fileName = $file->getClientOriginalName();

        $student->documents()->create([
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