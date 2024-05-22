<?php

use App\Console\Commands\OverdueTodos;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command(OverdueTodos::class, function () {})
->purpose('Display an inspiring quote')
->hourly();

