<x-layout-user>
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Peminjaman Ruangan</h1>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('user.peminjaman.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Ajukan Peminjaman
                </a>
            </div>
        </div>

        <!-- Tab Navigation with Horizontal Scroll -->
        <div class="border-b border-gray-200 mb-6">
            <div class="relative pb-4">
                <!-- Scroll Left Button -->
                <button id="scrollLeft" class="absolute left-0 top-0 z-10 h-full w-8 bg-gradient-to-r from-white to-transparent flex items-center justify-center opacity-0 transition-opacity duration-200 hover:opacity-100 md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Scrollable Tab Container -->
                <nav id="tabContainer" class="flex overflow-x-auto scrollbar-hide scroll-smooth -mb-px" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <div class="flex space-x-6 px-1 min-w-max">
                        <a href="{{ route('user.peminjaman.index', ['status' => 'semua']) }}" 
                           class="whitespace-nowrap py-4 px-3 border-b-2 font-medium text-sm transition-colors duration-200 {{ $status === 'semua' || !$status ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Semua
                            </span>
                        </a>
                        
                        <a href="{{ route('user.peminjaman.index', ['status' => 'menunggu']) }}" 
                           class="whitespace-nowrap py-4 px-3 border-b-2 font-medium text-sm transition-colors duration-200 {{ $status === 'menunggu' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Menunggu
                            </span>
                        </a>
                        
                        <a href="{{ route('user.peminjaman.index', ['status' => 'disetujui']) }}" 
                           class="whitespace-nowrap py-4 px-3 border-b-2 font-medium text-sm transition-colors duration-200 {{ $status === 'disetujui' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Disetujui
                            </span>
                        </a>
                        
                        <a href="{{ route('user.peminjaman.index', ['status' => 'ditolak']) }}" 
                           class="whitespace-nowrap py-4 px-3 border-b-2 font-medium text-sm transition-colors duration-200 {{ $status === 'ditolak' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Ditolak
                            </span>
                        </a>
                        
                        <a href="{{ route('user.peminjaman.index', ['status' => 'selesai']) }}" 
                           class="whitespace-nowrap py-4 px-3 border-b-2 font-medium text-sm transition-colors duration-200 {{ $status === 'selesai' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                Selesai
                            </span>
                        </a>
                    </div>
                </nav>

                <!-- Scroll Right Button -->
                <button id="scrollRight" class="absolute right-0 top-0 z-10 h-full w-8 bg-gradient-to-l from-white to-transparent flex items-center justify-center opacity-0 transition-opacity duration-200 hover:opacity-100 md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Scroll Indicator Dots -->
                <div id="scrollIndicator" class="flex justify-center mt-2 space-x-1 md:hidden">
                    <!-- Dots will be generated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <div class="relative">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari berdasarkan nama ruangan..."
                    value="{{ $search ?? '' }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div id="flashMessage" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button onclick="document.getElementById('flashMessage').remove()" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ruangan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Waktu
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($peminjaman ?? [] as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->ruangan->nama_ruangan ?? 'Ruang Rapat Utama' }}</div>
                                <div class="text-xs text-gray-500">{{ $item->ruangan->lokasi ?? 'Lantai 2, Gedung A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->tanggal ?? '25 Mei 2025' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $item->waktu_mulai_formatted ?? '09:00' }} - {{ $item->waktu_selesai_formatted ?? '12:00' }}</div>
                                <div class="text-xs text-gray-500">{{ $item->durasi_pinjam ?? '3' }} jam</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = [
                                        'menunggu' => 'bg-yellow-100 text-yellow-800',
                                        'disetujui' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-800',
                                        'selesai' => 'bg-blue-100 text-blue-800',
                                        'dibatalkan' => 'bg-gray-200 text-gray-600'
                                    ][$item->status ?? 'disetujui'];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($item->status ?? 'Disetujui') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('user.peminjaman.show', $item->peminjaman_id ?? 1) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @if(($item->status ?? 'disetujui') === 'disetujui')
                                        <a href="{{ route('user.pengembalian.create', $item->peminjaman_id ?? 1) }}" class="text-green-600 hover:text-green-900" title="Ajukan Pengembalian">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if(($item->status ?? 'disetujui') === 'menunggu')
                                        <button onclick="confirmCancel({{ $item->peminjaman_id }})" class="text-red-600 hover:text-red-900" title="Batalkan">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-lg font-medium text-gray-900 mb-2">Tidak ada data peminjaman</p>
                                    <p class="text-gray-500">Mulai dengan mengajukan peminjaman ruangan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <!-- Pagination links would go here -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Tab Scroll Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabContainer = document.getElementById('tabContainer');
            const scrollLeftBtn = document.getElementById('scrollLeft');
            const scrollRightBtn = document.getElementById('scrollRight');
            const scrollIndicator = document.getElementById('scrollIndicator');

            if (!tabContainer || !scrollLeftBtn || !scrollRightBtn) return;

            let isScrolling = false;

            // Check if scrolling is needed
            function checkScrollButtons() {
                const { scrollLeft, scrollWidth, clientWidth } = tabContainer;
                
                // Show/hide scroll buttons based on scroll position
                if (scrollLeft > 0) {
                    scrollLeftBtn.style.opacity = '1';
                } else {
                    scrollLeftBtn.style.opacity = '0';
                }

                if (scrollLeft < scrollWidth - clientWidth - 1) {
                    scrollRightBtn.style.opacity = '1';
                } else {
                    scrollRightBtn.style.opacity = '0';
                }

                // Update scroll indicator
                updateScrollIndicator();
            }

            // Create scroll indicator dots
            function createScrollIndicator() {
                if (window.innerWidth >= 768) return; // Only show on mobile

                const tabWidth = tabContainer.scrollWidth;
                const containerWidth = tabContainer.clientWidth;
                
                if (tabWidth <= containerWidth) {
                    scrollIndicator.innerHTML = '';
                    return;
                }

                const dotsCount = Math.ceil(tabWidth / containerWidth);
                scrollIndicator.innerHTML = '';

                for (let i = 0; i < dotsCount; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'w-2 h-2 rounded-full bg-gray-300 transition-colors duration-200';
                    scrollIndicator.appendChild(dot);
                }
            }

            // Update scroll indicator
            function updateScrollIndicator() {
                const dots = scrollIndicator.querySelectorAll('div');
                if (dots.length === 0) return;

                const { scrollLeft, scrollWidth, clientWidth } = tabContainer;
                const scrollPercentage = scrollLeft / (scrollWidth - clientWidth);
                const activeDotIndex = Math.round(scrollPercentage * (dots.length - 1));

                dots.forEach((dot, index) => {
                    if (index === activeDotIndex) {
                        dot.className = 'w-2 h-2 rounded-full bg-blue-500 transition-colors duration-200';
                    } else {
                        dot.className = 'w-2 h-2 rounded-full bg-gray-300 transition-colors duration-200';
                    }
                });
            }

            // Smooth scroll function
            function smoothScroll(element, target, duration = 300) {
                const start = element.scrollLeft;
                const change = target - start;
                const startTime = performance.now();

                function animateScroll(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    
                    // Easing function (ease-out)
                    const easeOut = 1 - Math.pow(1 - progress, 3);
                    
                    element.scrollLeft = start + (change * easeOut);

                    if (progress < 1) {
                        requestAnimationFrame(animateScroll);
                    } else {
                        isScrolling = false;
                    }
                }

                isScrolling = true;
                requestAnimationFrame(animateScroll);
            }

            // Scroll left button
            scrollLeftBtn.addEventListener('click', function() {
                if (isScrolling) return;
                const scrollAmount = tabContainer.clientWidth * 0.8;
                const targetScroll = Math.max(0, tabContainer.scrollLeft - scrollAmount);
                smoothScroll(tabContainer, targetScroll);
            });

            // Scroll right button
            scrollRightBtn.addEventListener('click', function() {
                if (isScrolling) return;
                const scrollAmount = tabContainer.clientWidth * 0.8;
                const maxScroll = tabContainer.scrollWidth - tabContainer.clientWidth;
                const targetScroll = Math.min(maxScroll, tabContainer.scrollLeft + scrollAmount);
                smoothScroll(tabContainer, targetScroll);
            });

            // Listen to scroll events
            tabContainer.addEventListener('scroll', checkScrollButtons);

            // Touch/swipe support for mobile
            let startX = 0;
            let scrollStart = 0;

            tabContainer.addEventListener('touchstart', function(e) {
                startX = e.touches[0].pageX;
                scrollStart = tabContainer.scrollLeft;
            });

            tabContainer.addEventListener('touchmove', function(e) {
                if (!startX) return;
                
                const currentX = e.touches[0].pageX;
                const diffX = startX - currentX;
                tabContainer.scrollLeft = scrollStart + diffX;
                
                e.preventDefault(); // Prevent page scroll
            });

            tabContainer.addEventListener('touchend', function() {
                startX = 0;
                scrollStart = 0;
            });

            // Initialize on load and resize
            function initialize() {
                createScrollIndicator();
                checkScrollButtons();
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                setTimeout(initialize, 100);
            });

            // Initialize
            initialize();

            // Auto-scroll to active tab on page load
            const activeTab = tabContainer.querySelector('.border-blue-500');
            if (activeTab) {
                setTimeout(() => {
                    const tabRect = activeTab.getBoundingClientRect();
                    const containerRect = tabContainer.getBoundingClientRect();
                    
                    if (tabRect.left < containerRect.left || tabRect.right > containerRect.right) {
                        const scrollTarget = activeTab.offsetLeft - (tabContainer.clientWidth / 2) + (activeTab.clientWidth / 2);
                        smoothScroll(tabContainer, Math.max(0, scrollTarget));
                    }
                }, 100);
            }
        });

        // Cancel confirmation function
        function confirmCancel(id) {
            Swal.fire({
                title: 'Batalkan Peminjaman?',
                text: "Tindakan ini tidak bisa dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, batalkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/user/peminjaman/${id}/cancel`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal membatalkan peminjaman.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            title: 'Dibatalkan!',
                            text: 'Peminjaman berhasil dibatalkan.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.fire('Gagal', error.message, 'error');
                    });
                }
            });
        }

        // Live search functionality
        const searchInput = document.getElementById('searchInput');
        let searchTimer;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(performSearch, 500);
        });

        function performSearch() {
            const searchValue = searchInput.value;
            const currentStatus = '{{ $status ?? "semua" }}';

            window.location.href = `{{ route('user.peminjaman.index') }}?status=${currentStatus}&search=${searchValue}`;
        }

        // Close flash message after 5 seconds
        if (document.getElementById('flashMessage')) {
            setTimeout(() => {
                const flashMessage = document.getElementById('flashMessage');
                if (flashMessage) {
                    flashMessage.remove();
                }
            }, 5000);
        }
    </script>

    <style>
        /* Hide scrollbar for tab container */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;  /* Chrome, Safari and Opera */
        }

        /* Smooth scroll behavior */
        .scroll-smooth {
            scroll-behavior: smooth;
        }

        /* Custom gradient for scroll buttons */
        #scrollLeft {
            background: linear-gradient(to right, rgba(255,255,255,1) 0%, rgba(255,255,255,0.8) 70%, rgba(255,255,255,0) 100%);
        }
        
        #scrollRight {
            background: linear-gradient(to left, rgba(255,255,255,1) 0%, rgba(255,255,255,0.8) 70%, rgba(255,255,255,0) 100%);
        }
    </style>
</x-layout-user>
