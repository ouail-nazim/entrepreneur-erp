<?php

namespace App\Exports;

use App\Models\Timesheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TimesheetExport implements FromQuery, WithMapping, WithHeadings, WithTitle
{
    protected $contactId;
    protected $startDate;
    protected $endDate;

    public function __construct(int $contactId, string $startDate, string $endDate)
    {
        $this->contactId = $contactId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Timesheet::query()
            ->with('contact')
            ->where('contact_id', $this->contactId)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status', 'validated');
    }

    public function headings(): array
    {
        return [
            __('contacts.full_name'),
            __('timesheets.date'),
            __('timesheets.days'),
            __('contacts.daily_rate'),
            __('invoices.total'),
            __('timesheets.comment'),
            __('timesheets.status'),
        ];
    }

    public function map($timesheet): array
    {
        $dailyRate = $timesheet->contact->daily_rate;
        $total = $timesheet->quantity * $dailyRate;
        $currency = \App\Models\Setting::get('currency', '€');

        return [
            $timesheet->contact->full_name,
            $timesheet->date,
            $timesheet->quantity,
            number_format($dailyRate, 2) . ' ' . $currency,
            number_format($total, 2) . ' ' . $currency,
            $timesheet->comment,
            $timesheet->status,
        ];
    }

    public function title(): string
    {
        return __('contacts.timesheets');
    }
}
