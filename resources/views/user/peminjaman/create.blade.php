<x-layout-user>
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Ajukan Peminjaman Ruangan</h1>
            <a href="{{ route('user.peminjaman.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
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

        <form action="{{ route('user.peminjaman.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="ruangan_id" class="block text-sm font-medium text-gray-700 mb-2">Ruangan</label>
                    <select name="ruangan_id" id="ruangan_id"
                        class="mt-1 block w-full pl-3 p-3 text-base border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                        required>
                        <option value="">Pilih Ruangan</option>
                        @foreach($ruangan ?? [] as $room)
                        <option value="{{ $room->ruangan_id }}" {{ old('ruangan_id')==$room->ruangan_id ? 'selected' :
                            '' }}>
                            {{ $room->nama_ruangan }} ({{ $room->lokasi }}, Kapasitas: {{ $room->kapasitas }})
                        </option>
                        @endforeach
                        <!-- Sample data when no real data is available -->
                        @if(empty($ruangan))
                        <option value="1">Ruang Rapat Utama (Lantai 2, Gedung A, Kapasitas: 20)</option>
                        <option value="2">Laboratorium Komputer (Lantai 1, Gedung B, Kapasitas: 30)</option>
                        <option value="3">Ruang Seminar (Lantai 3, Gedung A, Kapasitas: 100)</option>
                        <option value="4">Ruang Kelas 101 (Lantai 1, Gedung C, Kapasitas: 30)</option>
                        <option value="5">Ruang Rapat Kecil (Lantai 2, Gedung B, Kapasitas: 10)</option>
                        @endif
                    </select>
                    @error('ruangan_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                        min="{{ date('Y-m-d') }}"
                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-white text-gray-900 rounded-md p-3"
                        required>
                    @error('tanggal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="waktu_mulai" class="block text-sm font-medium text-gray-700 mb-2">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai') }}"
                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-white text-gray-900 rounded-md p-3"
                        required>
                    @error('waktu_mulai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="durasi_pinjam" class="block text-sm font-medium text-gray-700 mb-2">Durasi (Jam)</label>
                    <input type="number" name="durasi_pinjam" id="durasi_pinjam" value="{{ old('durasi_pinjam', 1) }}"
                        min="1" max="24"
                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-white text-gray-900 rounded-md p-3"
                        required>
                    @error('durasi_pinjam')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Masukkan durasi peminjaman dalam jam</p>
                </div>

                <div class="md:col-span-2">
                    <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-2">Keperluan</label>
                    <textarea name="keperluan" id="keperluan" rows="3"
                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-white text-gray-900 rounded-md p-3"
                        required>{{ old('keperluan') }}</textarea>
                    @error('keperluan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Informasi Ketersediaan</h3>
                <div id="availabilityInfo" class="mt-2 p-4 bg-gray-50 rounded-md">
                    <p class="text-sm text-gray-500">Silakan pilih ruangan dan tanggal untuk melihat ketersediaan.</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('user.peminjaman.index') }}"
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ruanganSelect = document.getElementById('ruangan_id');
            const tanggalInput = document.getElementById('tanggal');
            const availabilityInfo = document.getElementById('availabilityInfo');
            const waktuMulaiInput = document.getElementById('waktu_mulai');
            const durasiInput = document.getElementById('durasi_pinjam');

            // Check availability when ruangan or tanggal changes
            ruanganSelect.addEventListener('change', checkAvailability);
            tanggalInput.addEventListener('change', checkAvailability);

            function checkAvailability() {
    const ruanganId = ruanganSelect.value;
    const tanggal = tanggalInput.value;

    if (ruanganId && tanggal) {
        availabilityInfo.innerHTML = '<p class="text-sm text-gray-500">Memeriksa ketersediaan...</p>';

        fetch(`/user/peminjaman/check-availability?ruangan_id=${ruanganId}&tanggal=${tanggal}`)
            .then(response => response.json())
            .then(data => {

                if (data.error) {
                    availabilityInfo.innerHTML = `<p class="text-sm text-red-500">${data.error}</p>`;
                    return;
                }

                const bookings = data.bookings;

                console.log(bookings)

                // Misal slot jam yang dicek adalah:
                const slots = [
    { start: '07:00', end: '08:00' },
    { start: '08:00', end: '09:00' },
    { start: '09:00', end: '10:00' },
    { start: '10:00', end: '11:00' },
    { start: '11:00', end: '12:00' },
    { start: '12:00', end: '13:00' },
    { start: '13:00', end: '14:00' },
    { start: '14:00', end: '15:00' },
    { start: '15:00', end: '16:00' },
    { start: '16:00', end: '17:00' }
];

                // Fungsi bantu untuk cek apakah slot bertabrakan dengan booking
                function isBooked(slotStart, slotEnd) {
                    for (const booking of bookings) {
                        const waktuMulai = booking.waktu_mulai.substring(0, 5); // Ambil "HH:mm"
                        const waktuSelesai = booking.waktu_selesai.substring(11, 16); // Ambil "HH:mm" dari "YYYY-MM-DD HH:mm:ss"

                        if (!(slotEnd <= waktuMulai || slotStart >= waktuSelesai)) {
                            return true; // Ada tabrakan waktu
                        }
                    }
                    return false;
                }

                // Bangun HTML slot sesuai ketersediaan
                let availabilityHTML = `<h4 class="font-medium text-gray-900 mb-2">Jadwal Ruangan pada ${formatDate(tanggal)}</h4><div class="space-y-2">`;

                slots.forEach(slot => {
                    const booked = isBooked(slot.start, slot.end);
                    availabilityHTML += `
                        <div class="flex items-center">
                            <span class="inline-block w-16 text-sm text-gray-500">${slot.start}-${slot.end}</span>
                            <span class="inline-block px-2 py-1 text-xs rounded-full ${booked ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'}">${booked ? 'Terpakai' : 'Tersedia'}</span>
                        </div>
                    `;
                });

                availabilityHTML += '</div><p class="mt-2 text-sm text-gray-500">Pilih waktu yang tersedia untuk melakukan peminjaman.</p>';

                availabilityInfo.innerHTML = availabilityHTML;
            })
            .catch(err => {
                availabilityInfo.innerHTML = '<p class="text-sm text-red-500">Gagal memeriksa ketersediaan.</p>';
                console.error(err);
            });
    }
}

            function formatDate(dateString) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }

            // Show estimated end time based on start time and duration
            waktuMulaiInput.addEventListener('change', updateEndTime);
            durasiInput.addEventListener('change', updateEndTime);

            function updateEndTime() {
                const waktuMulai = waktuMulaiInput.value;
                const durasi = parseInt(durasiInput.value);

                if (waktuMulai && durasi) {
                    const [hours, minutes] = waktuMulai.split(':').map(Number);
                    let endHours = hours + durasi;
                    const endMinutes = minutes;

                    // Format end time
                    const formattedEndHours = String(endHours % 24).padStart(2, '0');
                    const formattedEndMinutes = String(endMinutes).padStart(2, '0');

                    // Display end time (in a real application, you might want to show this to the user)
                    console.log(`Waktu selesai: ${formattedEndHours}:${formattedEndMinutes}`);
                }
            }
        });
    </script>
</x-layout-user>
