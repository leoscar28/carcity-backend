<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportUser implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithMapping
{

    protected $users;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        return User::with('roles')
            ->whereBetween('created_at', [$this->from, $this->to])->get();
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->roles->title,
            $user->name . ' ' . $user->surname,
            $user->email,
            $user->created_at,
            $user->bin,
            $user->company,
            $user->status === 1 ? "Включен" : "Отключен",
            $user->can_create_banner === 0 ? "Отключен" : "Включен",
            $user->phone
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Роль',
            'Имя',
            'Эл.почта',
            'Дата регистрации',
            'БИН/ИИН',
            'Компания',
            'Статус',
            'Может создавать объявления',
            'Номер телефона',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(11)->setBold(true);;
            },
        ];
    }
}

?>
