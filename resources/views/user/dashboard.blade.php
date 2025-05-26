<x-layout-user>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <!-- Card Peminjaman Aktif -->
        <div class="bg-white rounded-lg shadow-md p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Peminjaman Aktif</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $peminjamanAktif ?? 2 }}</p>
                </div>
                <div class="bg-blue-100 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <a href="{{ route('user.peminjaman.index') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Detail →
                </a>
            </div>
        </div>

        <!-- Card Menunggu Persetujuan -->
        <div class="bg-white rounded-lg shadow-md p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Menunggu Persetujuan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $menungguPersetujuan ?? 1 }}</p>
                </div>
                <div class="bg-yellow-100 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <a href="{{ route('user.peminjaman.index') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Detail →
                </a>
            </div>
        </div>

        <!-- Card Riwayat Peminjaman -->
        <div class="bg-white rounded-lg shadow-md p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Riwayat Peminjaman</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $riwayatPeminjaman ?? 8 }}</p>
                </div>
                <div class="bg-green-100 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <a href="{{ route('user.peminjaman.index') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Detail →
                </a>
            </div>
        </div>
    </div>

    <!-- Upcoming Reservations -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Peminjaman Mendatang</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ruangan
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Waktu
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($upcomingReservations->take(3) as $row)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $row->ruangan->nama_ruangan }}</div>
                            <div class="text-xs text-gray-500">{{ $row->ruangan->lokasi }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($row->tanggal_mulai)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $row->waktu_mulai_formatted }} - {{ $row->waktu_selesai_formatted }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        {{ $row->status == 'disetujui' ? 'bg-green-100 text-green-800' :
                           ($row->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' :
                           'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('user.peminjaman.show', $row->peminjaman_id) }}" class="text-blue-600 hover:text-blue-900"
                                title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                            Belum ada peminjaman yang diajukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        @if($upcomingReservations->count() > 3)
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <a href="{{ route('user.peminjaman.index') }}"
                class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                Lihat Semua Peminjaman →
            </a>
        </div>
        @endif
    </div>

    <!-- Available Rooms -->
    {{-- <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Ruangan Tersedia Hari Ini</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-md font-medium text-gray-900">Ruang Kelas 101</h3>
                        <p class="text-sm text-gray-500">Lantai 1, Gedung C</p>
                        <p class="text-xs text-gray-500 mt-1">Kapasitas: 30 orang</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        Tersedia
                    </span>
                </div>
                <div class="mt-4 flex justify-end">
                    <a href="{{ route('user.peminjaman.create') }}"
                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Pinjam
                    </a>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-md font-medium text-gray-900">Ruang Seminar</h3>
                        <p class="text-sm text-gray-500">Lantai 3, Gedung A</p>
                        <p class="text-xs text-gray-500 mt-1">Kapasitas: 100 orang</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        Tersedia
                    </span>
                </div>
                <div class="mt-4 flex justify-end">
                    <a href="{{ route('user.peminjaman.create') }}"
                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Pinjam
                    </a>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-md font-medium text-gray-900">Ruang Rapat Kecil</h3>
                        <p class="text-sm text-gray-500">Lantai 2, Gedung B</p>
                        <p class="text-xs text-gray-500 mt-1">Kapasitas: 10 orang</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        Tersedia
                    </span>
                </div>
                <div class="mt-4 flex justify-end">
                    <a href="{{ route('user.peminjaman.create') }}"
                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Pinjam
                    </a>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <a href="{{ route('user.peminjaman.create') }}"
                class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                Lihat Semua Ruangan →
            </a>
        </div>
    </div> --}}
</x-layout-user>
