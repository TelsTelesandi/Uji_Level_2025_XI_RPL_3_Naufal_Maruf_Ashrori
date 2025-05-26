<x-layout>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6 transition-colors duration-200">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar
                    </a>
                </div>

                {{-- @if($ruangan->status === 'tersedia')
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Ajukan Peminjaman
                    </button>
                @endif --}}
            </div>

            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $ruangan->nama_ruangan }}</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Image Gallery -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-200">
                    <div class="relative h-64 md:h-80 bg-gradient-to-br from-blue-400 to-blue-600 dark:from-blue-600 dark:to-blue-800">
                        @if($ruangan->file_gambar)
                        <img src="{{ asset('storage/' . $ruangan->file_gambar) }}" alt="Foto Ruangan" class="w-full h-full object-cover">
                        @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>

                        <!-- Image placeholder overlay -->
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="bg-black bg-opacity-50 rounded-lg p-3">
                                <p class="text-white text-sm">📷 Foto ruangan akan segera tersedia</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-colors duration-200">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Deskripsi Ruangan</h2>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ $ruangan->nama_ruangan }} adalah ruangan yang berlokasi di {{ $ruangan->lokasi }} dengan kapasitas maksimal {{ $ruangan->kapasitas }} orang.
                    </p>
                </div>

                <!-- Availability Checker -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-200">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Cek Ketersediaan Ruangan
                        </h2>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <label for="tanggal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Tanggal</label>
                                <input type="date"
                                       id="tanggal"
                                       value="{{ date('Y-m-d') }}"
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-200">
                            </div>
                            <div class="flex items-end">
                                <button onclick="checkAvailability()" class="px-6 py-3 bg-blue-600 dark:bg-blue-500 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Refresh
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="availabilityInfo" class="p-6">
                        <div class="flex items-center justify-center py-8">
                            <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Memuat ketersediaan...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Info -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-colors duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Ruangan</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Kapasitas</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $ruangan->kapasitas }} orang</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Lokasi</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $ruangan->lokasi }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Status</span>
                            <span class="font-medium {{ $ruangan->status === 'tersedia' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ ucfirst($ruangan->status) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">ID Ruangan</span>
                            <span class="font-medium text-gray-900 dark:text-white">#{{ $ruangan->ruangan_id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ruanganId = {{ $ruangan->ruangan_id }};
            const tanggalInput = document.getElementById('tanggal');
            const availabilityInfo = document.getElementById('availabilityInfo');

            // Check availability on page load and when date changes
            checkAvailability();
            tanggalInput.addEventListener('change', checkAvailability);

            function checkAvailability() {
                const tanggal = tanggalInput.value;

                if (!tanggal) {
                    availabilityInfo.innerHTML = `
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Silakan pilih tanggal untuk melihat ketersediaan ruangan</p>
                        </div>
                    `;
                    return;
                }

                // Show loading state
                availabilityInfo.innerHTML = `
                    <div class="flex items-center justify-center py-8">
                        <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Memeriksa ketersediaan...</span>
                    </div>
                `;

                fetch(`/peminjaman-ruangan/check-availability?ruangan_id=${ruanganId}&tanggal=${tanggal}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            availabilityInfo.innerHTML = `
                                <div class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-400 dark:text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    <p class="text-red-600 dark:text-red-400 mb-4">${data.error}</p>
                                    <button onclick="checkAvailability()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">Coba Lagi</button>
                                </div>
                            `;
                            return;
                        }

                        const bookings = data.bookings || [];

                        // Extended time slots from 7 AM to 10 PM
                        const timeSlots = {
                            'Pagi': [
                                { start: '07:00', end: '08:00' },
                                { start: '08:00', end: '09:00' },
                                { start: '09:00', end: '10:00' },
                                { start: '10:00', end: '11:00' },
                                { start: '11:00', end: '12:00' }
                            ],
                            'Siang': [
                                { start: '12:00', end: '13:00' },
                                { start: '13:00', end: '14:00' },
                                { start: '14:00', end: '15:00' },
                                { start: '15:00', end: '16:00' },
                                { start: '16:00', end: '17:00' }
                            ],
                            'Sore': [
                                { start: '17:00', end: '18:00' },
                                { start: '18:00', end: '19:00' },
                                { start: '19:00', end: '20:00' }
                            ],
                            'Malam': [
                                { start: '20:00', end: '21:00' },
                                { start: '21:00', end: '22:00' }
                            ]
                        };

                        // Check if a time slot is booked
                        function isSlotBooked(slotStart, slotEnd) {
                            return bookings.some(booking => {
                                const bookingStart = booking.waktu_mulai.substring(0, 5);
                                const bookingEnd = booking.waktu_selesai.substring(0, 5);

                                // Check for time overlap
                                return !(slotEnd <= bookingStart || slotStart >= bookingEnd);
                            });
                        }

                        // Count total available slots
                        let totalSlots = 0;
                        let availableSlots = 0;

                        Object.values(timeSlots).forEach(slots => {
                            slots.forEach(slot => {
                                totalSlots++;
                                if (!isSlotBooked(slot.start, slot.end)) {
                                    availableSlots++;
                                }
                            });
                        });

                        // Build availability HTML
                        let availabilityHTML = `
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        ${formatDate(tanggal)}
                                    </h4>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Ketersediaan</div>
                                        <div class="text-lg font-bold ${availableSlots > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">
                                            ${availableSlots}/${totalSlots} slot
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Tingkat Ketersediaan</span>
                                        <span class="text-sm font-bold text-blue-900 dark:text-blue-100">${Math.round((availableSlots/totalSlots)*100)}%</span>
                                    </div>
                                    <div class="w-full bg-blue-200 dark:bg-blue-800 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-400 dark:to-blue-500 h-3 rounded-full transition-all duration-500 shadow-sm" style="width: ${(availableSlots/totalSlots)*100}%"></div>
                                    </div>
                                </div>
                            </div>
                        `;

                        // Generate time period sections
                        Object.entries(timeSlots).forEach(([period, slots]) => {
                            const periodAvailable = slots.filter(slot => !isSlotBooked(slot.start, slot.end)).length;
                            const periodTotal = slots.length;

                            // Period icons
                            const periodIcons = {
                                'Pagi': '🌅',
                                'Siang': '☀️',
                                'Sore': '🌇',
                                'Malam': '🌙'
                            };

                            availabilityHTML += `
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <h5 class="text-md font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                                            <span class="text-lg mr-2">${periodIcons[period]}</span>
                                            ${period}
                                        </h5>
                                        <span class="text-xs px-2 py-1 rounded-full ${periodAvailable > 0 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'}">
                                            ${periodAvailable}/${periodTotal} tersedia
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            `;

                            slots.forEach(slot => {
                                const isBooked = isSlotBooked(slot.start, slot.end);
                                availabilityHTML += `
                                    <div class="relative group">
                                        <div class="p-4 rounded-lg border-2 transition-all duration-200 ${isBooked
                                            ? 'border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30'
                                            : 'border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 hover:border-green-300 dark:hover:border-green-700'
                                        }">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <div class="font-medium text-gray-900 dark:text-white text-sm">
                                                        ${slot.start} - ${slot.end}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        1 jam
                                                    </div>
                                                </div>
                                                <div class="flex items-center">
                                                    ${isBooked
                                                        ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>'
                                                        : '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>'
                                                    }
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });

                            availabilityHTML += `
                                    </div>
                                </div>
                            `;
                        });

                        // Add legend
                        availabilityHTML += `
                            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h6 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Keterangan:</h6>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-green-200 dark:bg-green-800 border-2 border-green-300 dark:border-green-700 rounded mr-2"></div>
                                        <span class="text-xs text-gray-600 dark:text-gray-400">Tersedia</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-red-200 dark:bg-red-800 border-2 border-red-300 dark:border-red-700 rounded mr-2"></div>
                                        <span class="text-xs text-gray-600 dark:text-gray-400">Terpakai</span>
                                    </div>
                                </div>
                            </div>
                        `;

                        availabilityInfo.innerHTML = availabilityHTML;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        availabilityInfo.innerHTML = `
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-400 dark:text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-red-600 dark:text-red-400 mb-4">Gagal memuat data ketersediaan</p>
                                <button onclick="checkAvailability()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">Coba Lagi</button>
                            </div>
                        `;
                    });
            }

            function formatDate(dateString) {
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }

            // Make checkAvailability available globally for retry button
            window.checkAvailability = checkAvailability;
        });
    </script>
</x-layout>
