<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
{
    $students = Student::query()
        ->when($request->jk, fn ($q, $jk) => $q->where('jenis_kelamin', $jk))
        ->when($request->q, function ($query, $q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('nis', 'like', "%{$q}%")
                    ->orWhere('kelas', 'like', "%{$q}%");
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $counts = [
        'all' => Student::count(),
        'L'   => Student::where('jenis_kelamin', 'L')->count(),
        'P'   => Student::where('jenis_kelamin', 'P')->count(),
    ];

    return view('students.index', compact('students', 'counts'));
}

    public function create()
    {
        return view('students.create');
    }

    // INSERT
    public function store(Request $request)
    {
        $data = $request->validate([
            'nis'           => 'required|string|max:20|unique:students,nis',
            'nama'          => 'required|string|max:100',
            'email'         => 'nullable|email|unique:students,email',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'kelas'         => 'required|string|max:20',
            'alamat'        => 'nullable|string',
        ]);

        Student::create($data);

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    // UPDATE
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'nis'           => ['required', 'string', 'max:20', Rule::unique('students', 'nis')->ignore($student->id)],
            'nama'          => 'required|string|max:100',
            'email'         => ['nullable', 'email', Rule::unique('students', 'email')->ignore($student->id)],
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'kelas'         => 'required|string|max:20',
            'alamat'        => 'nullable|string',
        ]);

        $student->update($data);

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    // DELETE
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
{
    $request->validate([
        'ids'   => 'required|array',
        'ids.*' => 'integer|exists:students,id',
    ]);

    $count = Student::whereIn('id', $request->ids)->delete();

    return redirect()->route('students.index')
        ->with('success', "{$count} data siswa berhasil dihapus.");
}
}