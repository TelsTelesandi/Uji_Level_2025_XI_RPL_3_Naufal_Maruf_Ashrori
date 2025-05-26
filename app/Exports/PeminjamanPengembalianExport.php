<?php

namespace App\Exports;

use App\Models\PeminjamanRuangan;
use App\Models\PengembalianRuangan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamanPengembalianExport implements FromCollection, WithHeadings, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $exportType;

    public function __construct($startDate, $endDate, $exportType)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->exportType = $exportType;
    }

    public function collection()
    {
        $data = new Collection();

        if ($this->exportType === 'all' || $this->exportType === 'peminjaman') {
            $peminjaman = PeminjamanRuangan::with('user', 'ruangan')
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->get()
                ->map(function ($item) {
                    return [
                        'Tipe' => 'Peminjaman',
                        'Nama User' => $item->user->nama_lengkap,
                        'ID Card' => $item->user->id_card,
                        'Ruangan' => $item->ruangan->nama_ruangan ?? '-',
                        'Tanggal' => $item->tanggal,
                        'Waktu Mulai' => $item->waktu_mulai,
                        'Durasi (JP)' => $item->durasi_pinjam,
                        'Waktu Selesai' => $item->waktu_selesai,
                        'Keperluan' => $item->keperluan,
                        'Status' => $item->status,
                        'Kondisi Ruangan' => '-', // Placeholder biar kolom tetap sinkron
                        'Tanggal Pengajuan' => $item->created_at
                    ];
                });

            $data = $data->merge($peminjaman);
        }

        if ($this->exportType === 'all' || $this->exportType === 'pengembalian') {
            $pengembalian = PengembalianRuangan::with('user', 'peminjaman')
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->get()
                ->map(function ($item) {
                    return [
                        'Tipe' => 'Pengembalian',
                        'Nama User' => $item->user->nama_lengkap,
                        'ID Card' => $item->user->id_card,
                        'Ruangan' => $item->peminjaman->ruangan->nama_ruangan ?? '-',
                        'Tanggal' => $item->peminjaman->tanggal ?? '-',
                        'Waktu Mulai' => $item->peminjaman->waktu_mulai ?? '-',
                        'Durasi (JP)' => $item->peminjaman->durasi_pinjam . " jam" ?? '-',
                        'Waktu Selesai' => $item->peminjaman->waktu_selesai ?? '-',
                        'Keperluan' => $item->peminjaman->keperluan ?? '-',
                        'Status' => $item->status,
                        'Kondisi Ruangan' => $item->kondisi_ruangan,
                        'Tanggal Pengajuan' => $item->created_at
                    ];
                });

            $data = $data->merge($pengembalian);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Tipe',
            'Nama User',
            'ID Card',
            'Ruangan',
            'Tanggal',
            'Waktu Mulai',
            'Durasi (JP)',
            'Waktu Selesai',
            'Keperluan',
            'Status',
            'Kondisi Ruangan',
            'Tanggal Pengajuan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'BDD7EE'] // Biru muda untuk header
                ]
            ],
        ];
    }
}
