<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use App\Models\Stat;
use Illuminate\Support\Facades\DB;


class ImportStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-stats {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import stats from CSV files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        $path = storage_path($filename);


        // Validate file existence
        if (!file_exists($path)) {
            $this->error("File not found: $path");
            return 1; // Return an error code
        }

        try {
            $data = array_map('str_getcsv', file($path));
            $headers = array_map('trim', array_shift($data));

            if (!in_array('utm_campaign', $headers) || !in_array('revenue', $headers) || !in_array('monetization_timestamp', $headers)) {
                $this->error('CSV file is missing required headers: utm_campaign, revenue, or monetization_timestamp');
                return 1;
            }

            $batchSize = 1000; // Number of records per batch
            $batch = [];

            foreach ($data as $row) {
                $row = array_combine($headers, $row);

                if (empty($row['utm_campaign']) || empty($row['utm_term']) || $row['utm_campaign'] == "NULL" || $row['utm_term'] == "NULL") {
                    continue;
                }

                // Get or create campaign
                $campaign = Campaign::firstOrCreate(['utm_campaign' => $row['utm_campaign']]);

                // Prepare the record
                $batch[] = [
                    'campaign_id' => $campaign->id,
                    'utm_term' => $row['utm_term'],
                    'revenue' => floatval($row['revenue']),
                    'event_time' => $row['monetization_timestamp'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Insert batch when size is reached
                if (count($batch) >= $batchSize) {
                    DB::table('stats')->insert($batch);
                    $batch = []; // Reset the batch
                }
            }

            // Insert remaining records
            if (!empty($batch)) {
                DB::table('stats')->insert($batch);
            }

            $this->info("Data imported successfully from $filename.");
            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred during import: ' . $e->getMessage());
            return 1;
        }

        
    }
}