<x-layout>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Profil Pengguna</h1>
                <p class="text-sm text-gray-600 mt-1">Kelola informasi profil dan pengaturan akun Anda</p>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Photo Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Foto Profil</h2>

                    <div class="flex flex-col items-center">
                        <div class="relative mb-4">
                            @if($user->url_foto_profil)
                                <img id="profilePreview"
                                     src="{{ asset('storage/' . $user->url_foto_profil) }}"
                                     alt="Foto Profil"
                                     class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                            @else
                                @php
                                    $initials = '';
                                    $words = explode(' ', $user->nama_lengkap);
                                    foreach ($words as $w) {
                                        if(!empty($w)) {
                                            $initials .= $w[0];
                                        }
                                    }
                                    $initials = substr($initials, 0, 2);
                                @endphp
                                <div id="profilePreview" class="w-32 h-32 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold border-4 border-gray-200">
                                    {{ $initials }}
                                </div>
                            @endif

                            @if($user->url_foto_profil)
                                <form action="{{ route('profile.delete-photo') }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus foto profil?')"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>

                        <form action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data" class="w-full" id="photoUploadForm">
                            @csrf
                            @method('POST')
                            <div class="w-full">
                                <label for="url_foto_profil" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih Foto Baru
                                </label>
                                <input type="file"
                                       id="url_foto_profil"
                                       name="url_foto_profil"
                                       accept="image/*"
                                       onchange="previewImage(this)"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF hingga 2MB</p>
                            </div>
                            <button type="submit"
                                    id="uploadPhotoBtn"
                                    disabled
                                    class="mt-4 w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                Unggah Foto
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h2>

                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">User ID</label>
                            <p class="text-sm text-gray-900">{{ $user->user_id }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Role</label>
                            <p class="text-sm text-gray-900">{{ ucfirst($user->role) }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Jenis Pengguna</label>
                            <p class="text-sm text-gray-900">{{ ucfirst($user->jenis_pengguna) }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Bergabung Sejak</label>
                            <p class="text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Form Section -->
            <div class="lg:col-span-2">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pribadi</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- ID Card -->
                            <div>
                                <label for="id_card" class="block text-sm font-medium text-gray-700 mb-2">
                                    ID Card <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="id_card"
                                       name="id_card"
                                       value="{{ old('id_card', $user->id_card) }}"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_card') border-red-500 @enderror">
                                @error('id_card')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                    Username <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="username"
                                       name="username"
                                       value="{{ old('username', $user->username) }}"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('username') border-red-500 @enderror">
                                @error('username')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Full Name -->
                            <div class="md:col-span-2">
                                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="nama_lengkap"
                                       name="nama_lengkap"
                                       value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_lengkap') border-red-500 @enderror">
                                @error('nama_lengkap')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password Change Section -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Ubah Password</h2>
                        <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Current Password -->
                            <div class="md:col-span-2">
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Saat Ini
                                </label>
                                <input type="password"
                                       id="current_password"
                                       name="current_password"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror">
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Baru
                                </label>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('user.dashboard') }}"
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Preview image before upload and enable/disable upload button
        function previewImage(input) {
            const uploadButton = document.getElementById('uploadPhotoBtn');

            if (input.files && input.files[0]) {
                // Enable the upload button
                uploadButton.disabled = false;

                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.getElementById('profilePreview');
                    if (preview.tagName === 'DIV') {
                        // Replace the initials div with an image
                        const parent = preview.parentNode;
                        const img = document.createElement('img');
                        img.id = 'profilePreview';
                        img.src = e.target.result;
                        img.alt = 'Foto Profil';
                        img.className = 'w-32 h-32 rounded-full object-cover border-4 border-gray-200';
                        parent.replaceChild(img, preview);
                    } else {
                        // Update existing image
                        preview.src = e.target.result;
                    }
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                // Disable the upload button if no file is selected
                uploadButton.disabled = true;
            }
        }

        // Ensure upload button is disabled on page load
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('url_foto_profil');
            const uploadButton = document.getElementById('uploadPhotoBtn');

            // Set initial button state
            uploadButton.disabled = !(fileInput.files && fileInput.files[0]);

            // Add event listener for when user clears the file input
            fileInput.addEventListener('change', function() {
                uploadButton.disabled = !(this.files && this.files[0]);
            });
        });
    </script>
</x-layout>
