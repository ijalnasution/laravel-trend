<?php

namespace Flowframe\Trend\Adapters;

use Error;

class PgsqlAdapter extends AbstractAdapter
{
    public function format(string $column, string $interval, bool $isTimestamp): string
    {
        $format = match ($interval) {
            'minute' => 'YYYY-MM-DD HH24:MI:00',
            'hour' => 'YYYY-MM-DD HH24:00:00',
            'day' => 'YYYY-MM-DD',
            'month' => 'YYYY-MM',
            'year' => 'YYYY',
            default => throw new Error('Invalid interval.'),
        };

        if ($isTimestamp) {
            return "to_char(to_timestamp({$column}), '{$format}')";
        }

        return "to_char({$column}, '{$format}')";
    }
}
