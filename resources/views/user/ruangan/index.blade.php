<x-layout-user>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6 transition-colors duration-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Daftar Ruangan</h1>
                <p class="text-gray-600 dark:text-gray-400">Temukan ruangan yang sesuai dengan kebutuhan Anda</p>
            </div>

            <!-- Stats -->
            <div class="mt-4 md:mt-0 flex space-x-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $ruangan->total() }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Total Ruangan</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                        {{ \App\Models\Ruangan::where('status', 'tersedia')->count() }}
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Tersedia</div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <div class="relative">
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari ruangan berdasarkan nama atau lokasi..."
                        value="{{ $search }}"
                        class="w-full px-4 py-2 pl-10 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-200"
                    >
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex space-x-2">
                <select id="statusFilter" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-200">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ $status === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="tidak_tersedia" {{ $status === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>

                <select id="sortFilter" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-200">
                    <option value="nama_ruangan" {{ $sort === 'nama_ruangan' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="nama_ruangan_desc" {{ $sort === 'nama_ruangan' && $direction === 'desc' ? 'selected' : '' }}>Nama Z-A</option>
                    <option value="kapasitas" {{ $sort === 'kapasitas' ? 'selected' : '' }}>Kapasitas Kecil</option>
                    <option value="kapasitas_desc" {{ $sort === 'kapasitas' && $direction === 'desc' ? 'selected' : '' }}>Kapasitas Besar</option>
                    <option value="lokasi" {{ $sort === 'lokasi' ? 'selected' : '' }}>Lokasi A-Z</option>
                </select>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @for($i = 0; $i < 8; $i++)
                    <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-6 animate-pulse">
                        <div class="w-full h-48 bg-gray-300 dark:bg-gray-600 rounded-lg mb-4"></div>
                        <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded mb-2"></div>
                        <div class="h-3 bg-gray-300 dark:bg-gray-600 rounded mb-2 w-3/4"></div>
                        <div class="h-3 bg-gray-300 dark:bg-gray-600 rounded w-1/2"></div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Cards Container -->
        <div id="cardsContainer">
            @include('user.ruangan.partials.cards')
        </div>
    </div>

    <script>
        class RuanganSearch {
            constructor() {
                this.searchInput = document.getElementById('searchInput');
                this.statusFilter = document.getElementById('statusFilter');
                this.sortFilter = document.getElementById('sortFilter');
                this.cardsContainer = document.getElementById('cardsContainer');
                this.loadingState = document.getElementById('loadingState');
                this.searchTimer = null;

                this.init();
            }

            init() {
                // Search input with debounce
                this.searchInput.addEventListener('input', () => {
                    clearTimeout(this.searchTimer);
                    this.searchTimer = setTimeout(() => this.performSearch(), 500);
                });

                // Filter changes
                this.statusFilter.addEventListener('change', () => this.performSearch());
                this.sortFilter.addEventListener('change', () => this.performSearch());
            }

            performSearch() {
                const searchValue = this.searchInput.value;
                const statusValue = this.statusFilter.value;
                const sortValue = this.sortFilter.value;

                // Parse sort value
                let sort = sortValue;
                let direction = 'asc';

                if (sortValue.endsWith('_desc')) {
                    sort = sortValue.replace('_desc', '');
                    direction = 'desc';
                }

                // Show loading state
                this.showLoading();

                // Build URL
                const params = new URLSearchParams();
                if (searchValue) params.append('search', searchValue);
                if (statusValue) params.append('status', statusValue);
                if (sort) params.append('sort', sort);
                if (direction) params.append('direction', direction);

                const url = `{{ route('user.ruangan.index') }}?${params.toString()}`;

                // Fetch new data
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    this.cardsContainer.innerHTML = html;
                    this.hideLoading();

                    // Update URL without page reload
                    window.history.pushState({}, '', url);
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.hideLoading();
                });
            }

            showLoading() {
                this.cardsContainer.classList.add('hidden');
                this.loadingState.classList.remove('hidden');
            }

            hideLoading() {
                this.loadingState.classList.add('hidden');
                this.cardsContainer.classList.remove('hidden');
            }
        }

        // Initialize search functionality
        document.addEventListener('DOMContentLoaded', () => {
            new RuanganSearch();
        });
    </script>
</x-layout-user>
