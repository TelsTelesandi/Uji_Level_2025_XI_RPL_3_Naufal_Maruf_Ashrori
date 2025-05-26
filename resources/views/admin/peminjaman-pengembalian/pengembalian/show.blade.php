<x-layout>
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Pengembalian</h1>
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informasi Pengembalian -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengembalian</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">ID Pengembalian</label>
                        <p class="text-sm text-gray-900">{{ $pengembalian->pengembalian_id ?? 'PEN-001' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tanggal Pengajuan</label>
                        <p class="text-sm text-gray-900">{{ $pengembalian->created_at ? $pengembalian->created_at->format('d M Y H:i') : '25 Mei 2025 12:30' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <div class="mt-1">
                            @php
                                $statusClass = [
                                    'belum_disetujui' => 'bg-yellow-100 text-yellow-800',
                                    'disetujui' => 'bg-green-100 text-green-800',
                                ][$pengembalian->status ?? 'disetujui'];

                                $statusText = [
                                    'belum_disetujui' => 'Belum Disetujui',
                                    'disetujui' => 'Disetujui',
                                ][$pengembalian->status ?? 'disetujui'];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Peminjaman Terkait -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Peminjaman</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">ID Peminjaman</label>
                        <p class="text-sm text-gray-900">{{ $pengembalian->peminjaman->peminjaman_id ?? 'PEM-001' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Ruangan</label>
                        <p class="text-sm text-gray-900">{{ $pengembalian->peminjaman->ruangan->nama_ruangan ?? 'Ruang Rapat Utama' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Lokasi</label>
                        <p class="text-sm text-gray-900">{{ $pengembalian->peminjaman->ruangan->lokasi ?? 'Lantai 2, Gedung A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tanggal Peminjaman</label>
                        <p class="text-sm text-gray-900">{{ $pengembalian->peminjaman->tanggal ? \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal)->format('d M Y') : '25 Mei 2025' }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Pengembalian -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Pengembalian</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tanggal Pengembalian</label>
                        <p class="text-sm text-gray-900">{{ $pengembalian->tanggal_kembali ? \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d M Y') : '25 Mei 2025' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Waktu Pengembalian</label>
                        <p class="text-sm text-gray-900">{{ $pengembalian->waktu_kembali ?? '12:00' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Kondisi Ruangan</label>
                        <div class="mt-1">
                            @php
                                $kondisiClass = [
                                    'baik' => 'bg-green-100 text-green-800',
                                    'rusak_ringan' => 'bg-yellow-100 text-yellow-800',
                                    'rusak_berat' => 'bg-red-100 text-red-800',
                                ][$pengembalian->kondisi_ruangan ?? 'baik'];

                                $kondisiText = [
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_berat' => 'Rusak Berat',
                                ][$pengembalian->kondisi_ruangan ?? 'baik'];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $kondisiClass }}">
                                {{ $kondisiText }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Catatan</h2>
                <p class="text-sm text-gray-900">{{ $pengembalian->catatan ?? 'Ruangan dalam kondisi baik, semua fasilitas berfungsi normal.' }}</p>
            </div>
        </div>
    </div>
</x-layout>
