<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Province;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class FetchDataFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $continue = $this->confirm('All existing data will be deleted. Continue?');

        if (!$continue) {
            $this->info('Aborted!');
            return 0;
        }

        $this->fetchProvinces();
        $this->fetchCities();
        $this->newLine()->info('Done!');
    }

    private function fetchProvinces()
    {
        try {
            $this->comment('Fetching provinces data...');

            $provinces = fetch(
                config('source.external_url') . '/province',
                config('source.external_key'),
                config('source.external_data_path')
            );

            $this->line(count($provinces) . ' province records fetched.');
            if (empty($provinces)) {
                return;
            }
        } catch (\Exception $e) {
            $this->line($e->getMessage());
            $this->error('Failed to fetch provinces data.');
            return;
        }

        if (Province::count() > 0) {
            $this->comment('Deleting provinces data from database...');
            Schema::disableForeignKeyConstraints();
            Province::truncate();
            Schema::enableForeignKeyConstraints();
            $this->line('All provinces data has been deleted.');
        }

        $this->comment('Inserting provinces data...');
        foreach ($provinces as $province) {
            Province::create([
                'id' => $province['province_id'],
                'name' => $province['province']
            ]);
        }

        $this->line('Provinces data inserted successfully.');
    }

    private function fetchCities()
    {
        try {
            $this->comment('Fetching cities data...');

            $cities = fetch(
                config('source.external_url') . '/city',
                config('source.external_key'),
                config('source.external_data_path')
            );

            $this->line(count($cities) . ' city records fetched.');
            if (empty($cities)) {
                return;
            }
        } catch (\Exception $e) {
            $this->line($e->getMessage());
            $this->error('Failed to fetch cities data.');
            return;
        }

        if (City::count() > 0) {
            $this->comment('Deleting cities data from database...');
            City::truncate();
            $this->line('All cities data has been deleted.');
        }

        $this->comment('Inserting cities data...');
        foreach ($cities as $city) {
            City::create([
                'id' => $city['city_id'],
                'province_id' => $city['province_id'],
                'name' => $city['city_name'],
                'type' => $city['type'],
                'postal_code' => $city['postal_code']
            ]);
        }

        $this->line('Cities data inserted successfully.');
    }
}
