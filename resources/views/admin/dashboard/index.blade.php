<x-layout>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Card Pengajuan Peminjaman -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-5 transition-colors duration-200">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengajuan Peminjaman</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $pengajuanPeminjaman }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm {{ $peminjamanPercentage >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    <span class="font-medium">{{ $peminjamanPercentage >= 0 ? '+' : '' }}{{ $peminjamanPercentage }}%</span> dari bulan lalu
                </p>
            </div>
        </div>

        <!-- Card Pengajuan Pengembalian -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-5 transition-colors duration-200">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengajuan Pengembalian</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $pengajuanPengembalian }}</p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm {{ $pengembalianPercentage >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    <span class="font-medium">{{ $pengembalianPercentage >= 0 ? '+' : '' }}{{ $pengembalianPercentage }}%</span> dari bulan lalu
                </p>
            </div>
        </div>

        <!-- Card Peminjaman -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-5 transition-colors duration-200">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Peminjaman</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $peminjaman }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm {{ $totalPeminjamanPercentage >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    <span class="font-medium">{{ $totalPeminjamanPercentage >= 0 ? '+' : '' }}{{ $totalPeminjamanPercentage }}%</span> dari bulan lalu
                </p>
            </div>
        </div>

        <!-- Card Pengembalian -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-5 transition-colors duration-200">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengembalian</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $pengembalian }}</p>
                </div>
                <div class="bg-red-100 dark:bg-red-900 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm {{ $totalPengembalianPercentage >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    <span class="font-medium">{{ $totalPengembalianPercentage >= 0 ? '+' : '' }}{{ $totalPengembalianPercentage }}%</span> dari bulan lalu
                </p>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8 transition-colors duration-200">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 sm:mb-0">
                <span class="hidden md:inline">Aktivitas 30 Hari Terakhir</span>
                <span class="md:hidden">Aktivitas 7 Hari Terakhir</span>
            </h2>
            <div class="flex items-center space-x-2">
                <!-- Period Toggle for Mobile -->
                <div class="md:hidden">
                    <select id="periodSelect" class="text-sm border border-gray-300 dark:border-gray-600 rounded-md px-3 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-colors duration-200">
                        <option value="7">7 Hari</option>
                        <option value="30">30 Hari</option>
                    </select>
                </div>
                <!-- Chart Type Toggle -->
                <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1 transition-colors duration-200">
                    <button id="barChartBtn" class="px-3 py-1 text-sm font-medium rounded-md bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm transition-all duration-200">
                        Bar
                    </button>
                    <button id="lineChartBtn" class="px-3 py-1 text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">
                        Line
                    </button>
                </div>
            </div>
        </div>
        <div class="h-64 md:h-80">
            <canvas id="activityChart"></canvas>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-200">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Aktivitas Terbaru</h2>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($recentActivities as $activity)
                <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    <div class="flex items-center">
                        <div class="{{ $activity['icon_class'] }} p-2 rounded-lg mr-4">
                            @if(strpos($activity['activity_type'], 'Peminjaman') !== false && strpos($activity['activity_type'], 'Menunggu') !== false)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            @elseif(strpos($activity['activity_type'], 'Disetujui') !== false && $activity['type'] === 'peminjaman')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @elseif(strpos($activity['activity_type'], 'Pengajuan Pengembalian') !== false)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            @elseif(strpos($activity['activity_type'], 'Pengembalian') !== false && strpos($activity['activity_type'], 'Disetujui') !== false)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800 dark:text-white">{{ $activity['activity_type'] }} {{ $activity['ruangan_name'] }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $activity['type'] === 'peminjaman' ? 'Diajukan' : 'Dikembalikan' }} oleh {{ $activity['user_name'] }} - {{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}
                            </p>
                        </div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">
                            {{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Belum ada aktivitas terbaru</p>
                </div>
            @endforelse
        </div>

        <!-- View All Button -->
        @if($recentActivities != null)
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 transition-colors duration-200">
            <a href="{{ route('peminjaman-pengembalian.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors duration-200">
                Lihat Semua Aktivitas →
            </a>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pass PHP data to JavaScript
        const chartData = @json($chartData);

        class DashboardChart {
            constructor() {
                this.chart = null;
                this.currentType = 'bar';
                this.currentPeriod = window.innerWidth < 768 ? 7 : 30; // Default 7 days on mobile, 30 on desktop
                this.chartData = chartData;
                this.init();
            }

            init() {
                this.setupEventListeners();
                this.createChart();
                this.updatePeriodSelect();
            }

            setupEventListeners() {
                // Chart type toggle
                document.getElementById('barChartBtn').addEventListener('click', () => {
                    this.switchChartType('bar');
                });

                document.getElementById('lineChartBtn').addEventListener('click', () => {
                    this.switchChartType('line');
                });

                // Period select (mobile)
                const periodSelect = document.getElementById('periodSelect');
                if (periodSelect) {
                    periodSelect.addEventListener('change', (e) => {
                        this.currentPeriod = parseInt(e.target.value);
                        this.updateChart();
                    });
                }

                // Responsive handling
                window.addEventListener('resize', () => {
                    if (window.innerWidth < 768 && this.currentPeriod === 30) {
                        this.currentPeriod = 7;
                        this.updateChart();
                        this.updatePeriodSelect();
                    } else if (window.innerWidth >= 768 && this.currentPeriod === 7) {
                        this.currentPeriod = 30;
                        this.updateChart();
                        this.updatePeriodSelect();
                    }
                });

                // Theme change listener
                const observer = new MutationObserver(() => {
                    this.updateChartTheme();
                });

                observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            }

            getChartData() {
                // Use real data from backend
                let dates = this.chartData.dates;
                let pengajuanPeminjaman = this.chartData.pengajuanPeminjaman;
                let pengajuanPengembalian = this.chartData.pengajuanPengembalian;
                let peminjaman = this.chartData.peminjaman;
                let pengembalian = this.chartData.pengembalian;

                // If we're showing only 7 days, take the last 7 days
                if (this.currentPeriod === 7) {
                    dates = dates.slice(-7);
                    pengajuanPeminjaman = pengajuanPeminjaman.slice(-7);
                    pengajuanPengembalian = pengajuanPengembalian.slice(-7);
                    peminjaman = peminjaman.slice(-7);
                    pengembalian = pengembalian.slice(-7);
                }

                return {
                    dates,
                    pengajuanPeminjaman,
                    pengajuanPengembalian,
                    peminjaman,
                    pengembalian
                };
            }

            getChartColors() {
                const isDark = document.documentElement.classList.contains('dark');
                return {
                    textColor: isDark ? '#f3f4f6' : '#374151',
                    gridColor: isDark ? '#374151' : '#e5e7eb',
                    datasets: {
                        pengajuanPeminjaman: {
                            borderColor: '#3B82F6',
                            backgroundColor: isDark ? 'rgba(59, 130, 246, 0.2)' : 'rgba(59, 130, 246, 0.1)'
                        },
                        pengajuanPengembalian: {
                            borderColor: '#8B5CF6',
                            backgroundColor: isDark ? 'rgba(139, 92, 246, 0.2)' : 'rgba(139, 92, 246, 0.1)'
                        },
                        peminjaman: {
                            borderColor: '#10B981',
                            backgroundColor: isDark ? 'rgba(16, 185, 129, 0.2)' : 'rgba(16, 185, 129, 0.1)'
                        },
                        pengembalian: {
                            borderColor: '#EF4444',
                            backgroundColor: isDark ? 'rgba(239, 68, 68, 0.2)' : 'rgba(239, 68, 68, 0.1)'
                        }
                    }
                };
            }

            createChart() {
                const data = this.getChartData();
                const colors = this.getChartColors();
                const ctx = document.getElementById('activityChart').getContext('2d');

                if (this.chart) {
                    this.chart.destroy();
                }

                this.chart = new Chart(ctx, {
                    type: this.currentType,
                    data: {
                        labels: data.dates,
                        datasets: [
                            {
                                label: 'Pengajuan Peminjaman',
                                data: data.pengajuanPeminjaman,
                                borderColor: colors.datasets.pengajuanPeminjaman.borderColor,
                                backgroundColor: colors.datasets.pengajuanPeminjaman.backgroundColor,
                                tension: 0.4,
                                fill: this.currentType === 'line',
                                borderWidth: this.currentType === 'line' ? 2 : 1
                            },
                            {
                                label: 'Pengajuan Pengembalian',
                                data: data.pengajuanPengembalian,
                                borderColor: colors.datasets.pengajuanPengembalian.borderColor,
                                backgroundColor: colors.datasets.pengajuanPengembalian.backgroundColor,
                                tension: 0.4,
                                fill: this.currentType === 'line',
                                borderWidth: this.currentType === 'line' ? 2 : 1
                            },
                            {
                                label: 'Peminjaman',
                                data: data.peminjaman,
                                borderColor: colors.datasets.peminjaman.borderColor,
                                backgroundColor: colors.datasets.peminjaman.backgroundColor,
                                tension: 0.4,
                                fill: this.currentType === 'line',
                                borderWidth: this.currentType === 'line' ? 2 : 1
                            },
                            {
                                label: 'Pengembalian',
                                data: data.pengembalian,
                                borderColor: colors.datasets.pengembalian.borderColor,
                                backgroundColor: colors.datasets.pengembalian.backgroundColor,
                                tension: 0.4,
                                fill: this.currentType === 'line',
                                borderWidth: this.currentType === 'line' ? 2 : 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: colors.textColor,
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: window.innerWidth < 768 ? 11 : 12
                                    }
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: document.documentElement.classList.contains('dark') ? 'rgba(31, 41, 55, 0.9)' : 'rgba(255, 255, 255, 0.9)',
                                titleColor: colors.textColor,
                                bodyColor: colors.textColor,
                                borderColor: colors.gridColor,
                                borderWidth: 1
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: colors.textColor,
                                    font: {
                                        size: window.innerWidth < 768 ? 10 : 11
                                    },
                                    maxRotation: window.innerWidth < 768 ? 45 : 0
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: colors.gridColor,
                                    borderDash: [2, 4],
                                    drawBorder: false
                                },
                                ticks: {
                                    color: colors.textColor,
                                    font: {
                                        size: window.innerWidth < 768 ? 10 : 11
                                    }
                                }
                            }
                        },
                        elements: {
                            point: {
                                radius: this.currentType === 'line' ? 4 : 0,
                                hoverRadius: this.currentType === 'line' ? 6 : 0
                            }
                        }
                    }
                });
            }

            switchChartType(type) {
                this.currentType = type;
                this.updateChartTypeButtons();
                this.createChart();
            }

            updateChartTypeButtons() {
                const barBtn = document.getElementById('barChartBtn');
                const lineBtn = document.getElementById('lineChartBtn');

                if (this.currentType === 'bar') {
                    barBtn.className = 'px-3 py-1 text-sm font-medium rounded-md bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm transition-all duration-200';
                    lineBtn.className = 'px-3 py-1 text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200';
                } else {
                    lineBtn.className = 'px-3 py-1 text-sm font-medium rounded-md bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm transition-all duration-200';
                    barBtn.className = 'px-3 py-1 text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200';
                }
            }

            updateChart() {
                this.createChart();
            }

            updatePeriodSelect() {
                const periodSelect = document.getElementById('periodSelect');
                if (periodSelect) {
                    periodSelect.value = this.currentPeriod.toString();
                }
            }

            updateChartTheme() {
                if (this.chart) {
                    const colors = this.getChartColors();

                    // Update legend colors
                    this.chart.options.plugins.legend.labels.color = colors.textColor;

                    // Update tooltip colors
                    this.chart.options.plugins.tooltip.backgroundColor = document.documentElement.classList.contains('dark') ? 'rgba(31, 41, 55, 0.9)' : 'rgba(255, 255, 255, 0.9)';
                    this.chart.options.plugins.tooltip.titleColor = colors.textColor;
                    this.chart.options.plugins.tooltip.bodyColor = colors.textColor;
                    this.chart.options.plugins.tooltip.borderColor = colors.gridColor;

                    // Update scale colors
                    this.chart.options.scales.x.ticks.color = colors.textColor;
                    this.chart.options.scales.y.ticks.color = colors.textColor;
                    this.chart.options.scales.y.grid.color = colors.gridColor;

                    // Update dataset colors
                    this.chart.data.datasets.forEach((dataset, index) => {
                        const datasetKeys = ['pengajuanPeminjaman', 'pengajuanPengembalian', 'peminjaman', 'pengembalian'];
                        const key = datasetKeys[index];
                        if (colors.datasets[key]) {
                            dataset.backgroundColor = colors.datasets[key].backgroundColor;
                            dataset.borderColor = colors.datasets[key].borderColor;
                        }
                    });

                    this.chart.update();
                }
            }
        }

        // Initialize dashboard when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            new DashboardChart();
        });
    </script>
</x-layout>
