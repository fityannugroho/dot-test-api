<?php

namespace App\Console\Commands;

use App\Models\Province;
use Illuminate\Console\Command;

class FetchProvincesDataFromAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:provinces';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch provinces data from API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $continue = $this->confirm('All existing data will be deleted. Are you sure you want to continue?');

        if (!$continue) {
            $this->info('Aborted!');
            return 0;
        }

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', config('source.external_url').'/province', [
            'headers' => [
                'key' => config('source.external_key')
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        $provinces = getNestedVar($data, config('source.external_data_path'));

        if (Province::count() > 0) {
            Province::truncate();
        }

        foreach ($provinces as $province) {
            Province::create([
                'id' => $province['province_id'],
                'name' => $province['province']
            ]);
        }

        $this->info('Provinces data fetched successfully.');
    }
}
