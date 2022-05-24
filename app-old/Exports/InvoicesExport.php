<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoicesExport implements FromView
{
    protected $booking;
    public function __construct($booking)
    {
        $this->booking = $booking;
    }
    public function view(): View
    {
        return view('booking.invoice_pdf', [
            'booking' => $this->booking
        ]);
    }
}