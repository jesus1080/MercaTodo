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
        // dd($request->all());
        // $separador = "-";
        // $date = explode($separador, $request->param);
        
        //dump($date[0]);
          
       
        $invoices = Invoice::whereDate('created_at', '>=',$request->start_date)
                            ->whereDate('created_at', '<=',$request->end_date)                        
                            ->get(['session_id','payment_status','total']);
        //dd($invoices);
        
       
        //$pdf = Pdf::loadView('reports.invoice', ['invoices' => $invoices]);
        //dd($pdf);
        // $invoices = Invoice::find(1);
        // dd($invoices);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('reports.invoice', compact('invoices'));
        //$pdf = Pdf::loadView('reports.invoice', compact('invoices'));

        //$pdf->loadHTML('<h1>test<\h1>');
        // $pdf2 = $pdf->output();
        // header("Content-type:application/pdf");
        // echo $pdf2;
        // exit;
        
        return $pdf->download('invoices.pdf');
        
        
    }
    
    
    
}
