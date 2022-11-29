<?php

namespace App\Exports\Invoices;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoiceExport implements FromArray, WithStrictNullComparison, WithHeadings, ShouldAutoSize
{
    protected $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function array(): array
    {
    	$result = [];

    	foreach ($this->items as $item) {
    		$result[] = [
                '#' => $item['id'],
                'Reference Number' => $item['reference_number'],
                'Branch' => $item['branch'],
                'Customer' => $item['user'],
                'Contact #' => $item['contact_number'],
                'Email' => $item['email'],
                'Pastry' => $item['pastry'],
                'Attendees' => $item['attendees'],
                'Schedule Date' => $item['scheduled_date'],
                'Reservation Slot Time' => $item['start_time'],
                'Booking Type' => $item['booking_type'],
                'Coupon Code' => $item['coupon_code'],
                'Coupon Discount' => $item['ovt'],
                'Price Per Head' => $item['price_per_head'],
                'Additional Fee' => $item['additional_fee'],
                'Sub Total' => $item['sub_total'],
                'Total Payment' => $item['grand_total'],
                'Payment Type' => $item['payment_type_label'],
                'Payment Status' => $item['payment_status_label'],
                'Status' => $item['is_claim'],
            ];
    	}

        return $result;
    }

    public function headings(): array
    {
        return [
            '#',
            'Reference Number',
            'Branch',
            'Customer',
            'Contact #',
            'Email',
            'Pastry',
            'Attendees',
            'Schedule Date',
            'Reservation Slot Time',
            'Booking Type',
            'Coupon Code',
            'Coupon Discount',
            'Price Per Head',
            'Additional Fee',
            'Sub Total',
            'Total Payment',
            'Payment Type',
            'Payment Status',
            'Status',
        ];
    }
}
