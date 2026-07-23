<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LaporanPenjualanService;
use App\Services\MonitoringStokService;

class DashboardController extends Controller
{
    public function __construct(
        protected LaporanPenjualanService $laporanPenjualanService,
        protected MonitoringStokService $monitoringStokService
    ) {}
    public function index()
    {
        $ringkasan = $this->laporanPenjualanService->ringkasanHariIni();
        
        return view('dashboard', [
            'ringkasan' => $ringkasan,
            'produkStokRendah' => $this->monitoringStokService->produkStokRendah(),
            'produkStokHabis' => $this->monitoringStokService->produkStokHabis(),
        ]);
    }
}
