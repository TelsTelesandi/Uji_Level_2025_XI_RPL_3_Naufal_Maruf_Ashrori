<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {

            return view('admin.profile.index', compact('user'));
        } else {
            return view('user.profile.index', compact('user'));

        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validation rules
        $rules = [
            'id_card' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'id_card')->ignore($user->user_id, 'user_id')
            ],
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($user->user_id, 'user_id')
            ],
            'nama_lengkap' => 'required|string|max:100',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ];

        // Add current password validation if new password is provided
        if ($request->filled('password')) {
            $rules['current_password'] = 'required|string';
        }

        $messages = [
            'id_card.required' => 'ID Card wajib diisi.',
            'id_card.max' => 'ID Card tidak boleh lebih dari 20 karakter.',
            'id_card.unique' => 'ID Card sudah digunakan oleh pengguna lain.',

            'username.required' => 'Username wajib diisi.',
            'username.max' => 'Username tidak boleh lebih dari 50 karakter.',
            'username.unique' => 'Username sudah digunakan oleh pengguna lain.',

            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 100 karakter.',

            'current_password.required' => 'Password saat ini harus diisi untuk mengganti password.',
            'password.min' => 'Password baru minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password baru.',
        ];

        $validatedData = $request->validate($rules, $messages);

        // Verify current password if new password is provided
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }
        }

        try {
            // Remove password fields if not updating password
            if (!$request->filled('password')) {
                unset($validatedData['password'], $validatedData['current_password']);
            } else {
                // Hash the new password
                $validatedData['password'] = Hash::make($validatedData['password']);
                unset($validatedData['current_password']);
            }

            // Update user data
            $user->update($validatedData);

            return redirect()->route('profile.index')
                ->with('success', 'Profil berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'url_foto_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'url_foto_profil.required' => 'Foto profil wajib diunggah.',
            'url_foto_profil.image' => 'File yang diunggah harus berupa gambar.',
            'url_foto_profil.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
            'url_foto_profil.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);


        try {
            // Handle profile photo upload
            if ($request->hasFile('url_foto_profil')) {
                // Delete old profile photo if exists
                if ($user->url_foto_profil && Storage::disk('public')->exists($user->url_foto_profil)) {
                    Storage::disk('public')->delete($user->url_foto_profil);
                }

                // Generate unique filename
                $filename = 'profile_' . $user->user_id . '_' . time() . '.' . $request->file('url_foto_profil')->getClientOriginalExtension();
                $path = 'profile_photos/' . $filename;

                // Store the original file
                $request->file('url_foto_profil')->storeAs('profile_photos', $filename, 'public');

                // Update user with new photo path
                $user->update(['url_foto_profil' => $path]);

                return redirect()->route('profile.index')
                    ->with('success', 'Foto profil berhasil diperbarui.');
            }

            return back()->withErrors(['url_foto_profil' => 'Tidak ada file yang diunggah.']);

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui foto profil: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        try {
            if ($user->url_foto_profil && Storage::disk('public')->exists($user->url_foto_profil)) {
                Storage::disk('public')->delete($user->url_foto_profil);
                $user->update(['url_foto_profil' => null]);

                return redirect()->route('profile.index')
                    ->with('success', 'Foto profil berhasil dihapus.');
            }

            return back()->withErrors(['error' => 'Foto profil tidak ditemukan.']);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus foto profil: ' . $e->getMessage()]);
        }
    }
}
