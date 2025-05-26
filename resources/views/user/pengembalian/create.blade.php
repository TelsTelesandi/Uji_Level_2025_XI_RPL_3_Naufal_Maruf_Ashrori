<x-layout-user>
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Ajukan Pengembalian Ruangan</h1>
            <a href="{{ route('user.peminjaman.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
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

        <!-- Peminjaman Info -->
        <div class="bg-gray-50 p-4 rounded-md mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-2">Informasi Peminjaman</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Ruangan</p>
                    <p class="text-sm font-medium text-gray-900">{{ $peminjaman->ruangan->nama_ruangan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Peminjaman</p>
                    <p class="text-sm font-medium text-gray-900">{{$peminjaman->tanggal_formatted}}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Waktu Peminjaman</p>
                    <p class="text-sm font-medium text-gray-900">{{ $peminjaman->waktu_mulai_formatted }} - {{ $peminjaman->waktu_selesai_formatted }} ({{ $peminjaman->durasi_pinjam }} jam)</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status Peminjaman</p>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Disetujui
                    </span>
                </div>
            </div>
        </div>

        <form action="{{ route('user.pengembalian.store') }}" method="POST">
            @csrf
            <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->peminjaman_id ?? 1 }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label for="kondisi_ruangan" class="block text-sm font-medium text-gray-700 mb-2">Kondisi Ruangan</label>
                    <select name="kondisi_ruangan" id="kondisi_ruangan" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" required>
                        <option value="">Pilih Kondisi Ruangan</option>
                        <option value="baik" {{ old('kondisi_ruangan') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak_ringan" {{ old('kondisi_ruangan') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak_berat" {{ old('kondisi_ruangan') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                    @error('kondisi_ruangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Pengembalian</label>
                    <textarea name="catatan" id="catatan" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-white text-gray-900 rounded-md">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Berikan catatan jika ada kerusakan atau hal lain yang perlu diperhatikan</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('user.peminjaman.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Ajukan Pengembalian
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kondisiRuanganSelect = document.getElementById('kondisi_ruangan');
            const catatanTextarea = document.getElementById('catatan');
            
            kondisiRuanganSelect.addEventListener('change', function() {
                if (this.value === 'rusak_ringan' || this.value === 'rusak_berat') {
                    catatanTextarea.setAttribute('required', 'required');
                    if (catatanTextarea.value === '') {
                        catatanTextarea.placeholder = 'Harap berikan detail kerusakan yang terjadi...';
                    }
                } else {
                    catatanTextarea.removeAttribute('required');
                    catatanTextarea.placeholder = '';
                }
            });
        });
    </script>
</x-layout-user>
