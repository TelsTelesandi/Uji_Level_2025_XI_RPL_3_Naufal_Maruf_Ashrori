<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Importer;

use function Laravel\Prompts\error;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'user_id');
        $direction = $request->input('direction', 'asc');

        $users = User::where('nama_lengkap', 'like', "%{$search}%")
            ->orWhere('username', 'like', "%{$search}%")
            ->orWhere('id_card', 'like', "%{$search}%")
            ->orderBy($sort, $direction)
            ->paginate(10);

        if ($request->ajax()) {
            return view('admin.users.table', compact('users', 'sort', 'direction'));
        }

        return view('admin.users.index', compact('users', 'search', 'sort', 'direction'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'id_card' => 'required|string|max:255|unique:users',
            'role' => ['required', Rule::in(['admin', 'user'])],
            'jenis_pengguna' => ['required', Rule::in(['siswa', 'guru'])],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.string' => 'Nama lengkap harus berupa teks.',
            'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',

            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',

            'id_card.required' => 'ID Card wajib diisi.',
            'id_card.string' => 'ID Card harus berupa teks.',
            'id_card.max' => 'ID Card tidak boleh lebih dari 255 karakter.',
            'id_card.unique' => 'ID Card sudah terdaftar.',

            'role.required' => 'Role pengguna wajib dipilih.',
            'role.in' => 'Role yang dipilih tidak valid.',

            'jenis_pengguna.required' => 'Jenis pengguna wajib dipilih.',
            'jenis_pengguna.in' => 'Jenis pengguna yang dipilih tidak valid.',

            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);


        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->user_id, "user_id")],
            'id_card' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->user_id, "user_id")],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'jenis_pengguna' => ['required', Rule::in(['siswa', 'guru'])],
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.string' => 'Nama lengkap harus berupa teks.',
            'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',

            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',

            'id_card.required' => 'ID Card wajib diisi.',
            'id_card.string' => 'ID Card harus berupa teks.',
            'id_card.max' => 'ID Card tidak boleh lebih dari 255 karakter.',
            'id_card.unique' => 'ID Card sudah terdaftar.',

            'role.required' => 'Role pengguna wajib dipilih.',
            'role.in' => 'Role yang dipilih tidak valid.',

            'jenis_pengguna.required' => 'Jenis pengguna wajib dipilih.',
            'jenis_pengguna.in' => 'Jenis pengguna yang dipilih tidak valid.',

            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);


        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }

    public function importForm()
    {
        return view('users.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ], [
            "file.required" => "File wajib diisi.",
            "file.file" => "File wajib berupa file.",
            "file.mimes" => "File harus berupa file Excel (XLSX, XLS)."
        ]);

        $request->file('file')->store('imports_data_user', 'public');

        $importer = new UsersImport();

        $error = false;
        $message = [];

        Excel::import($importer, $request->file('file'));

        $rows_count = $importer->getRowsCount();
        $created_or_updated_rows = $importer->getCreatedOrUpdatedRowsCount();
        $failed_rows = $importer->getFailedRows();

        if ($created_or_updated_rows == 0 || $rows_count == 0) {
            $error = true;
            $message = "Gagal mengimport data, pastikan data valid.";
        }

        if ($error) {
            return redirect()->route('users.index')
                ->with('error', $message)
                ->with('failed_rows', $failed_rows);
        }

        return redirect()->route('users.index')
            ->with('success', $created_or_updated_rows . ' data user berhasil diimpor')
            ->with('failed_rows', $failed_rows);
    }

    public function downloadTemplate()
    {
        $filePath = public_path('/storage/templates/template_data_user.xlsx');

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($filePath, 'template_data_user.xlsx');
    }

}
