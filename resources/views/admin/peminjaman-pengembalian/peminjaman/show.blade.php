<x-layout>
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Peminjaman</h1>
            <a href="{{ route('peminjaman-pengembalian.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informasi Peminjaman -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Peminjaman</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Calon Peminjamn</label>
                        <p class="text-sm text-gray-900">{{ $peminjaman->user->nama_lengkap ?? 'PEM-001' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">ID Peminjaman</label>
                        <p class="text-sm text-gray-900">{{ $peminjaman->peminjaman_id ?? 'PEM-001' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tanggal Pengajuan</label>
                        <p class="text-sm text-gray-900">{{ $peminjaman->created_at ? $peminjaman->created_at_formatted
                            : '25 Mei 2025 08:30' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <div class="mt-1">
                            @php
                            $statusClass = [
                            'menunggu' => 'bg-yellow-100 text-yellow-800',
                            'disetujui' => 'bg-green-100 text-green-800',
                            'ditolak' => 'bg-red-100 text-red-800',
                            'selesai' => 'bg-blue-100 text-blue-800',
                            'dibatalkan' => 'bg-gray-100 text-gray-800',
                            ][$peminjaman->status ?? 'disetujui'];
                            @endphp
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($peminjaman->status ?? 'Disetujui') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Ruangan -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Ruangan</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama Ruangan</label>
                        <p class="text-sm text-gray-900">{{ $peminjaman->ruangan->nama_ruangan ?? 'Ruang Rapat Utama' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Lokasi</label>
                        <p class="text-sm text-gray-900">{{ $peminjaman->ruangan->lokasi ?? 'Lantai 2, Gedung A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Kapasitas</label>
                        <p class="text-sm text-gray-900">{{ $peminjaman->ruangan->kapasitas ?? '20' }} orang</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Fasilitas</label>
                        <p class="text-sm text-gray-900">{{ $peminjaman->ruangan->fasilitas ?? 'Proyektor, AC,
                            Whiteboard, Sound System' }}</p>
                    </div>
                </div>
            </div>

            <!-- Jadwal Peminjaman -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Jadwal Peminjaman</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tanggal</label>
                        <p class="text-sm text-gray-900">{{ $peminjaman->tanggal ? $peminjaman->tanggal_formatted : '25
                            Mei 2025' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Waktu Mulai</label>
                        <p class="text-sm text-gray-900">{{ $peminjaman->waktu_mulai_formatted ?? '09:00' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Waktu Selesai</label>
                        <p class="text-sm text-gray-900">{{ $peminjaman->waktu_selesai_formatted ?? '12:00' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Durasi</label>
                        <p class="text-sm text-gray-900">{{ $peminjaman->durasi_pinjam ?? '3' }} jam</p>
                    </div>
                </div>
            </div>

            <!-- Keperluan -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Keperluan</h2>
                <p class="text-sm text-gray-900">{{ $peminjaman->keperluan ?? 'Rapat koordinasi tim pengembangan
                    aplikasi untuk membahas progress proyek dan planning sprint berikutnya.' }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end space-x-3">
            @if(($peminjaman->status ?? 'disetujui') === 'menunggu')
            <button onclick="updateStatus({{ $peminjaman->peminjaman_id }}, 'ditolak')"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Tolak Pengajuan Peminjaman
            </button>
            <button onclick="updateStatus({{ $peminjaman->peminjaman_id }}, 'disetujui')"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Terima Pengajuan Peminjaman
            </button>
            @endif
        </div>
    </div>

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
          function updateStatus(id, status) {
    Swal.fire({
        title: 'Yakin ubah status?',
        text: 'Status akan diubah menjadi: ' + status,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#38c172', // hijau
        cancelButtonColor: '#6c757d',  // abu-abu
        confirmButtonText: 'Ya, ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('peminjaman-ruangan') }}/${id}/status`;

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';

            const statusField = document.createElement('input');
            statusField.type = 'hidden';
            statusField.name = 'status';
            statusField.value = status;

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            form.appendChild(statusField);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
    </script>
</x-layout>
