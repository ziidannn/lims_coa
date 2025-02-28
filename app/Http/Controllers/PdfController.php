<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Customer;
use App\Models\Subject;

class PdfController extends Controller
{
    public function showPdf($customerId, $id)
    {
        $customer = Customer::findOrFail($customerId);
        $description = Subject::orderBy('name')->get();

        $institute = (object) [
            'customer' => $customer->name,
            'address' => $customer->address,
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'created_at' => $customer->created_at,
            'subject' => $customer->subjects->pluck('name')->toArray(), // Mengambil semua nama subject
            'sample_taken_by' => 'PT. Delta Indonesia Laboratory',
            'sample_receive_date' => '2025-02-27',
            'sample_analysis_date' => '2025-02-28',
            'report_date' => '2025-03-01',
        ];

        $pdf = Pdf::loadView('pdf.resume_coa_pdf', compact('institute'));
        return $pdf->stream('Resume Institute ' . $institute->customer . ".pdf");
    }


}
