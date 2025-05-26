<x-layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6 transition-colors duration-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 md:mb-0">Kelola Peminjaman & Pengembalian Ruangan</h1>
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button" onclick="openExportModal()" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 dark:bg-green-500 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Data
                </button>
            </div>
        </div>

        <!-- Enhanced Tab Navigation with Horizontal Scroll -->
        <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
            <div class="relative pb-4">
                <!-- Scroll Left Button -->
                <button id="scrollLeft" class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-gradient-to-r from-white dark:from-gray-800 to-transparent p-2 rounded-full shadow-md hover:shadow-lg transition-all duration-200 md:hidden" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Scrollable Tab Container -->
                <div id="tabContainer" class="overflow-x-auto scrollbar-hide scroll-smooth">
                    <nav class="-mb-px flex space-x-6 min-w-max px-1">
                        <a href="{{ route('peminjaman-pengembalian.index', ['type' => 'peminjaman']) }}" 
                           class="tab-link flex items-center whitespace-nowrap py-4 px-3 border-b-2 font-medium text-sm transition-all duration-200 {{ $type === 'peminjaman' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Peminjaman Ruangan</span>
                        </a>
                        <a href="{{ route('peminjaman-pengembalian.index', ['type' => 'pengembalian']) }}" 
                           class="tab-link flex items-center whitespace-nowrap py-4 px-3 border-b-2 font-medium text-sm transition-all duration-200 {{ $type === 'pengembalian' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>Pengembalian Ruangan</span>
                        </a>
                    </nav>
                </div>

                <!-- Scroll Right Button -->
                <button id="scrollRight" class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-gradient-to-l from-white dark:from-gray-800 to-transparent p-2 rounded-full shadow-md hover:shadow-lg transition-all duration-200 md:hidden" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Scroll Indicators -->
                <div id="scrollIndicators" class="flex justify-center mt-2 space-x-1 md:hidden" style="display: none;">
                    <div class="scroll-dot w-2 h-2 rounded-full bg-blue-500 transition-all duration-200"></div>
                    <div class="scroll-dot w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 transition-all duration-200"></div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari berdasarkan nama pengguna atau ruangan..."
                    value="{{ $search }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-200"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex space-x-2">
                <select id="statusFilter" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-200">
                    <option value="">Semua Status</option>
                    @if($type === 'peminjaman')
                        <option value="menunggu" {{ $status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ $status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ $status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="dibatalkan" {{ $status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    @else
                        <option value="belum_disetujui" {{ $status === 'belum_disetujui' ? 'selected' : '' }}>Belum Disetujui</option>
                        <option value="disetujui" {{ $status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    @endif
                </select>
                <button id="applyFilter" class="px-4 py-2 bg-gray-600 dark:bg-gray-500 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                    Filter
                </button>
            </div>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div id="flashMessage" class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 mb-6 rounded transition-colors duration-200">
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
                            <button onclick="document.getElementById('flashMessage').remove()" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-200 dark:hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-green-900 transition-colors duration-200">
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
            <div id="tableContainer">
                @if($type === 'peminjaman')
                    @include('admin.peminjaman-pengembalian.peminjaman-table')
                @else
                    @include('admin.peminjaman-pengembalian.pengembalian-table')
                @endif
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div id="exportModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('peminjaman-pengembalian.export') }}" method="POST">
                    @csrf
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                    Export Data
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="export_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Data</label>
                                        <select name="export_type" id="export_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 sm:text-sm rounded-md transition-colors duration-200">
                                            <option value="all">Semua Data</option>
                                            <option value="peminjaman">Peminjaman Saja</option>
                                            <option value="pengembalian">Pengembalian Saja</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
                                        <input type="datetime-local" name="start_date" id="start_date" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 sm:text-sm rounded-md transition-colors duration-200" required>
                                    </div>
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Akhir</label>
                                        <input type="datetime-local" name="end_date" id="end_date" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 sm:text-sm rounded-md transition-colors duration-200" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse transition-colors duration-200">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 dark:bg-green-500 text-base font-medium text-white hover:bg-green-700 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                            Export
                        </button>
                        <button type="button" onclick="closeExportModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        /* Smooth scroll behavior */
        .scroll-smooth {
            scroll-behavior: smooth;
        }
        
        /* Tab hover effects */
        .tab-link:hover {
            transform: translateY(-1px);
        }
        
        /* Active tab glow effect */
        .tab-link.active {
            box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.3);
        }
    </style>

    <script>
        // Enhanced Tab Navigation with Horizontal Scroll
        document.addEventListener('DOMContentLoaded', function() {
            const tabContainer = document.getElementById('tabContainer');
            const scrollLeftBtn = document.getElementById('scrollLeft');
            const scrollRightBtn = document.getElementById('scrollRight');
            const scrollIndicators = document.getElementById('scrollIndicators');
            
            let isScrolling = false;
            let startX;
            let scrollLeft;

            // Check if scrolling is needed
            function checkScrollButtons() {
                if (window.innerWidth >= 768) { // md breakpoint
                    scrollLeftBtn.style.display = 'none';
                    scrollRightBtn.style.display = 'none';
                    scrollIndicators.style.display = 'none';
                    return;
                }

                const isScrollable = tabContainer.scrollWidth > tabContainer.clientWidth;
                
                if (isScrollable) {
                    scrollLeftBtn.style.display = tabContainer.scrollLeft > 0 ? 'block' : 'none';
                    scrollRightBtn.style.display = 
                        tabContainer.scrollLeft < (tabContainer.scrollWidth - tabContainer.clientWidth) ? 'block' : 'none';
                    scrollIndicators.style.display = 'flex';
                    updateScrollIndicators();
                } else {
                    scrollLeftBtn.style.display = 'none';
                    scrollRightBtn.style.display = 'none';
                    scrollIndicators.style.display = 'none';
                }
            }

            // Update scroll indicators
            function updateScrollIndicators() {
                const dots = scrollIndicators.querySelectorAll('.scroll-dot');
                const scrollPercentage = tabContainer.scrollLeft / (tabContainer.scrollWidth - tabContainer.clientWidth);
                
                dots.forEach((dot, index) => {
                    if (index === 0) {
                        dot.className = scrollPercentage < 0.5 ? 
                            'scroll-dot w-2 h-2 rounded-full bg-blue-500 transition-all duration-200' :
                            'scroll-dot w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 transition-all duration-200';
                    } else {
                        dot.className = scrollPercentage >= 0.5 ? 
                            'scroll-dot w-2 h-2 rounded-full bg-blue-500 transition-all duration-200' :
                            'scroll-dot w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 transition-all duration-200';
                    }
                });
            }

            // Scroll functions
            function scrollTabsLeft() {
                tabContainer.scrollBy({ left: -200, behavior: 'smooth' });
            }

            function scrollTabsRight() {
                tabContainer.scrollBy({ left: 200, behavior: 'smooth' });
            }

            // Event listeners
            scrollLeftBtn.addEventListener('click', scrollTabsLeft);
            scrollRightBtn.addEventListener('click', scrollTabsRight);
            
            tabContainer.addEventListener('scroll', checkScrollButtons);
            window.addEventListener('resize', checkScrollButtons);

            // Touch/swipe support
            tabContainer.addEventListener('touchstart', function(e) {
                isScrolling = true;
                startX = e.touches[0].pageX - tabContainer.offsetLeft;
                scrollLeft = tabContainer.scrollLeft;
            });

            tabContainer.addEventListener('touchmove', function(e) {
                if (!isScrolling) return;
                e.preventDefault();
                const x = e.touches[0].pageX - tabContainer.offsetLeft;
                const walk = (x - startX) * 2;
                tabContainer.scrollLeft = scrollLeft - walk;
            });

            tabContainer.addEventListener('touchend', function() {
                isScrolling = false;
            });

            // Mouse drag support for desktop
            tabContainer.addEventListener('mousedown', function(e) {
                isScrolling = true;
                startX = e.pageX - tabContainer.offsetLeft;
                scrollLeft = tabContainer.scrollLeft;
                tabContainer.style.cursor = 'grabbing';
            });

            tabContainer.addEventListener('mousemove', function(e) {
                if (!isScrolling) return;
                e.preventDefault();
                const x = e.pageX - tabContainer.offsetLeft;
                const walk = (x - startX) * 2;
                tabContainer.scrollLeft = scrollLeft - walk;
            });

            tabContainer.addEventListener('mouseup', function() {
                isScrolling = false;
                tabContainer.style.cursor = 'grab';
            });

            tabContainer.addEventListener('mouseleave', function() {
                isScrolling = false;
                tabContainer.style.cursor = 'grab';
            });

            // Initial check
            checkScrollButtons();

            // Auto-scroll to active tab
            const activeTab = document.querySelector('.tab-link[class*="border-blue-500"]');
            if (activeTab) {
                setTimeout(() => {
                    activeTab.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                }, 100);
            }
        });

        // Live search functionality
        const searchInput = document.getElementById('searchInput');
        let searchTimer;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(performSearch, 500);
        });

        function performSearch() {
            const searchValue = searchInput.value;
            const statusValue = document.getElementById('statusFilter').value;
            
            fetch(`{{ route('peminjaman-pengembalian.index') }}?type={{ $type }}&search=${searchValue}&status=${statusValue}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('tableContainer').innerHTML = html;
            });
        }

        // Apply filter
        document.getElementById('applyFilter').addEventListener('click', function() {
            performSearch();
        });

        // Sort functionality
        function sortTable(column) {
            const currentSort = '{{ $sort }}';
            const currentDirection = '{{ $direction }}';
            const statusValue = document.getElementById('statusFilter').value;
            
            let newDirection = 'asc';
            if (column === currentSort && currentDirection === 'asc') {
                newDirection = 'desc';
            }
            
            fetch(`{{ route('peminjaman-pengembalian.index') }}?type={{ $type }}&sort=${column}&direction=${newDirection}&search={{ $search }}&status=${statusValue}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('tableContainer').innerHTML = html;
            });
        }

        // Update status
        function updateStatus(id, status) {
            Swal.fire({
                title: 'Yakin ubah status?',
                text: 'Status akan diubah menjadi: ' + status,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#38c172',
                cancelButtonColor: '#6c757d',
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

        // Update pengembalian status
        function updatePengembalianStatus(id, status) {
            Swal.fire({
                title: 'Yakin ubah status?',
                text: 'Status akan diubah menjadi: ' + status,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#38c172',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, ubah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('peminjaman-ruangan/pengembalian') }}/${id}/status`;
                    
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

        // Export modal
        function openExportModal() {
            document.getElementById('exportModal').classList.remove('hidden');
            
            // Set default date range (current month)
            const now = new Date();
            const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
            const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0, 23, 59, 59);
            
            document.getElementById('start_date').value = formatDatetimeLocal(firstDay);
            document.getElementById('end_date').value = formatDatetimeLocal(lastDay);
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.add('hidden');
        }

        function formatDatetimeLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            
            return `${year}-${month}-${day}T${hours}:${minutes}`;
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
</x-layout>
