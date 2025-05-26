<x-layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6 transition-colors duration-200">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Data Ruangan</h1>
            <a href="{{ route('ruangan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 mb-6 rounded transition-colors duration-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">Ada beberapa kesalahan:</p>
                        <ul class="mt-1 text-sm list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('ruangan.update', $ruangan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-8">
                <!-- Basic Information Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi Dasar
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="nama_ruangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Ruangan</label>
                            <input type="text"
                                   name="nama_ruangan"
                                   id="nama_ruangan"
                                   value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-200"
                                   placeholder="Masukkan nama ruangan"
                                   required>
                            @error('nama_ruangan')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="lokasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lokasi</label>
                            <input type="text"
                                   name="lokasi"
                                   id="lokasi"
                                   value="{{ old('lokasi', $ruangan->lokasi) }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-200"
                                   placeholder="Masukkan lokasi ruangan"
                                   required>
                            @error('lokasi')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kapasitas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kapasitas</label>
                            <input type="number"
                                   name="kapasitas"
                                   id="kapasitas"
                                   value="{{ old('kapasitas', $ruangan->kapasitas) }}"
                                   min="1"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-200"
                                   placeholder="Masukkan kapasitas ruangan"
                                   required>
                            @error('kapasitas')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Masukkan jumlah maksimal orang yang dapat menempati ruangan</p>
                        </div>
                    </div>
                </div>

                <!-- Image Upload Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Foto Ruangan
                    </h3>

                    <div class="space-y-4">
                        <!-- Upload Area with Preview -->
                        <div class="relative">
                            <input type="file"
                                   name="image"
                                   id="image"
                                   accept="image/*"
                                   class="hidden"
                                   onchange="handleFileSelect(event)">

                            <!-- Hidden input to track if image should be removed -->
                            <input type="hidden" name="remove_image" id="remove_image" value="0">

                            <div id="dropZone"
                                 class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 cursor-pointer bg-gray-50 dark:bg-gray-700/50 min-h-[200px]"
                                 onclick="document.getElementById('image').click()">

                                <!-- Default Upload UI -->
                                <div id="uploadUI" class="p-8 text-center {{ $ruangan->file_gambar ? 'hidden' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Upload Foto Ruangan</h4>
                                    <p class="text-gray-600 dark:text-gray-400 mb-2">Klik untuk memilih file atau drag & drop</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">PNG, JPG, JPEG hingga 5MB</p>
                                </div>

                                <!-- Preview UI -->
                                <div id="previewUI" class="{{ $ruangan->file_gambar ? '' : 'hidden' }} relative">
                                    <img id="previewImage"
                                         src="{{ $ruangan->file_gambar ? asset('storage/' . $ruangan->file_gambar) : '/placeholder.svg' }}"
                                         alt="Preview"
                                         class="w-full h-64 object-cover">

                                    <!-- Overlay with file info -->
                                    <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all duration-200 flex items-center justify-center">
                                        <div class="opacity-0 hover:opacity-100 transition-opacity duration-200 text-center">
                                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-lg">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">Klik untuk mengganti foto</p>
                                                <p id="fileName" class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                                                    {{ $ruangan->file_gambar ? basename($ruangan->file_gambar) : '' }}
                                                </p>
                                                <p id="fileSize" class="text-xs text-gray-500 dark:text-gray-500"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Remove button -->
                                    <button type="button"
                                            id="removeBtn"
                                            onclick="removeImage(event)"
                                            class="absolute top-3 right-3 w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-200 shadow-lg z-10">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Current Image Info -->
                        @if($ruangan->file_gambar)
                            <div id="currentImageInfo" class="p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm text-blue-800 dark:text-blue-200">
                                        Foto saat ini: {{ basename($ruangan->file_gambar) }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        @error('image')
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Ruangan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const maxFileSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        let hasExistingImage = {{ $ruangan->file_gambar ? 'true' : 'false' }};

        // Drag and drop functionality
        const dropZone = document.getElementById('dropZone');

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-blue-400', 'dark:border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/30');
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-400', 'dark:border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/30');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-400', 'dark:border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/30');

            const files = Array.from(e.dataTransfer.files);
            if (files.length > 0) {
                handleFile(files[0]);
            }
        });

        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                handleFile(file);
            }
        }

        function handleFile(file) {
            // Validate file type
            if (!allowedTypes.includes(file.type)) {
                showError(`File ${file.name} bukan format gambar yang valid (PNG, JPG, JPEG)`);
                return;
            }

            // Validate file size
            if (file.size > maxFileSize) {
                showError(`File ${file.name} terlalu besar (maksimal 5MB)`);
                return;
            }

            // Show preview
            showPreview(file);

            // Reset remove image flag
            document.getElementById('remove_image').value = '0';

            // Hide current image info
            const currentImageInfo = document.getElementById('currentImageInfo');
            if (currentImageInfo) {
                currentImageInfo.style.display = 'none';
            }
        }

        function showPreview(file) {
            const uploadUI = document.getElementById('uploadUI');
            const previewUI = document.getElementById('previewUI');
            const previewImage = document.getElementById('previewImage');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');

            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);

                uploadUI.classList.add('hidden');
                previewUI.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        function removeImage(event) {
            event.stopPropagation(); // Prevent triggering file input

            const uploadUI = document.getElementById('uploadUI');
            const previewUI = document.getElementById('previewUI');
            const fileInput = document.getElementById('image');
            const currentImageInfo = document.getElementById('currentImageInfo');

            // Clear file input
            fileInput.value = '';

            // If there was an existing image, mark it for removal
            if (hasExistingImage) {
                document.getElementById('remove_image').value = '1';
                hasExistingImage = false;
            }

            // Show upload UI, hide preview
            previewUI.classList.add('hidden');
            uploadUI.classList.remove('hidden');

            // Hide current image info
            if (currentImageInfo) {
                currentImageInfo.style.display = 'none';
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showError(message) {
            // Create temporary error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-opacity duration-300';
            errorDiv.textContent = message;
            document.body.appendChild(errorDiv);

            // Remove after 3 seconds
            setTimeout(() => {
                errorDiv.style.opacity = '0';
                setTimeout(() => {
                    if (document.body.contains(errorDiv)) {
                        document.body.removeChild(errorDiv);
                    }
                }, 300);
            }, 3000);
        }

        // Form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const namaRuangan = document.getElementById('nama_ruangan').value.trim();
            const lokasi = document.getElementById('lokasi').value.trim();
            const kapasitas = document.getElementById('kapasitas').value;

            if (!namaRuangan || !lokasi || !kapasitas) {
                e.preventDefault();
                showError('Mohon lengkapi semua field yang wajib diisi');
                return;
            }

            if (parseInt(kapasitas) < 1) {
                e.preventDefault();
                showError('Kapasitas ruangan harus minimal 1 orang');
                return;
            }

            // Show loading state
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengupdate...
            `;

            // Reset button after 10 seconds (fallback)
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 10000);
        });
    </script>
</x-layout>
