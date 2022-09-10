<?php

namespace App\Console\Commands;

use App\Models\City;
use Illuminate\Console\Command;

class FetchCitiesDataFromAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch cities data from API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $continue = $this->confirm('All existing data in `cities` table will be deleted. Continue?');

        if (!$continue) {
            $this->info('Aborted!');
            return 0;
        }

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', config('source.external_url').'/city', [
            'headers' => [
                'key' => config('source.external_key')
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        $cities = getNestedVar($data, config('source.external_data_path'));

        if (City::count() > 0) {
            City::truncate();
        }

        foreach ($cities as $city) {
            City::create([
                'id' => $city['city_id'],
                'province_id' => $city['province_id'],
                'name' => $city['city_name'],
                'type' => $city['type'],
                'postal_code' => $city['postal_code']
            ]);
        }

        $this->line('Cities data fetched successfully.');
    }
}
