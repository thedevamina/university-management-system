<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\StudentProfile;
use App\Models\FacultyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // ── Student Documents ─────────────────────────────────────

    public function indexForStudent(StudentProfile $student)
    {
        $documents = $student->documents()->latest()->get();

        return view('admin.documents.student-index', 
            compact('student', 'documents'));
    }

    public function storeForStudent(Request $request, StudentProfile $student)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

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

        return back()->with('success', 'Document deleted!');
    }

    // ── Faculty Documents ─────────────────────────────────────

    public function indexForFaculty(FacultyProfile $faculty)
    {
        $documents = $faculty->documents()->latest()->get();

        return view('admin.documents.faculty-index',
            compact('faculty', 'documents'));
    }

    public function storeForFaculty(Request $request, FacultyProfile $faculty)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $file     = $request->file('document');
        $path     = $file->store('documents/faculty', 'public');
        $fileName = $file->getClientOriginalName();

        $faculty->documents()->create([
            'file_name' => $fileName,
            'file_path' => $path,
        ]);

        return back()->with('success', 'Document uploaded successfully!');
    }

    public function destroyFaculty(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted!');
    }
}