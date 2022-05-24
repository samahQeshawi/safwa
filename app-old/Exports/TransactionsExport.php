<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $user_type;
    protected $keyword;

    public function __construct(Request $request)
    {
        $this->sender_id = $request->sender_id;
        $this->keyword = $request->keyword;
    }

    public function headings(): array
    {
        return [
            'Sender',
            'Receiver',
            'Booking',
            'Amount',
            'Note',
            'Done By',
        ];
    }

    public function map($transaction): array
    {
        return [
            optional(optional($transaction)->sender)->name,
            optional(optional($transaction)->receiver)->name,
            optional(optional($transaction)->booking)->booking_no,
            $transaction->amount,
            $transaction->note,
            $transaction->doneBy->name,
        ];
    }

    public function query()
    {
        $transaction  =   Transaction::query();
        if ($this->sender_id)
            $transaction = $transaction->where('sender_id', $this->sender_id);
        if ($this->keyword) {
            $keyword = $this->keyword;
            $transaction = $transaction->whereHas('sender', function($q) use($keyword) {
                            $q->where('name', 'like', '%' .$keyword . '%');
                        })->orWhereHas('receiver', function($q) use($keyword) {
                            $q->where('name', 'like', '%' .$keyword . '%');
                        })->orWhereHas('booking', function($q) use($keyword) {
                            $q->where('booking_no', 'like', '%' .$keyword . '%');
                        });
        }
        return $transaction;
    }
}

