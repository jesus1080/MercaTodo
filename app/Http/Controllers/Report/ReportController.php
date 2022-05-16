<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Renderer;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        $initialDate = Carbon::now()->format('Y-m-d');

        return Inertia::render('Report/Report', compact('initialDate'));
    }

    public function generate(Request $request)
    {
        $invoices = Invoice::whereDate('created_at', '>=', $request->start_date)
                            ->whereDate('created_at', '<=', $request->end_date)
                            ->with('client')
                            ->get(['session_id','payment_status','total']);

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('reports.invoice', compact('invoices'));

        return $pdf->download('invoices.pdf');
    }
}
