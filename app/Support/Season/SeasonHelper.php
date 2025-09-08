<?php

namespace App\Support\Season;

use App\Repositories\Contracts\SeasonRepositoryInterface;

class SeasonHelper
{

    public static function getSeasonByID(int $id): ?array
    {
        $season = app(SeasonRepositoryInterface::class)->getSeasonById($id);
        return [
            'name' => $season->name,
            'code' => $season->code,
            'start_date' => $season->start_date,
            'end_date' => $season->end_date,
            'status' => $season->status,
            'note' => $season->note,
        ];
    }

    public static function getCurrentSeason(): string
    {
        $month = now()->month;

        return match (true) {
            $month >= 1 && $month <= 3  => 'SP', // Xuân
            $month >= 4 && $month <= 6  => 'SU', // Hạ
            $month >= 7 && $month <= 9  => 'FA', // Thu
            default                     => 'WI', // Đông: 10-12
        };
    }

    public static function getSeasonDate(string $seasonCode, $year): array
    {

        return match (strtoupper($seasonCode)) {
            'SP' => [
                'start_date' => "$year-01-01",
                'end_date'   => "$year-03-31",
            ],
            'SU' => [
                'start_date' => "$year-04-01",
                'end_date'   => "$year-06-30",
            ],
            'FA' => [
                'start_date' => "$year-07-01",
                'end_date'   => "$year-09-30",
            ],
            'WI' => [
                'start_date' => "$year-10-01",
                'end_date'   => "$year-12-31",
            ],
            default => [
                'start_date' => null,
                'end_date'   => null,
            ],
        };
    }

    public static function getSeasonNameAndCode(string $year, $season): array
    {
        $season = strtoupper($season);

        $map = [
            'SP' => 'SPRING',
            'SU' => 'SUMMER',
            'FA' => 'FALL',
            'WI' => 'WINTER',
        ];

        $shortYear = substr($year, -2);

        return [
            'code' => $season . $shortYear,
            'name' => $map[$season] . ' ' . $shortYear,
        ];
    }

    public static function getSeasonStatus(string $start, $end): string
    {
        $now = now();

        if ($now->isBefore($start)) {
            return 'upcoming';
        } elseif ($now->isAfter($end)) {
            return 'finished';
        } else {
            return 'ongoing';
        }
    }

    public static function getSeasonAvailable(): array
    {
        $seasons = app(SeasonRepositoryInterface::class)->getSeasonAvailable();
        foreach ($seasons as $season) {
            $season->status = self::getSeasonStatus($season->start_date, $season->end_date);
            $season->save();
        }
        return $seasons;
    }
}
