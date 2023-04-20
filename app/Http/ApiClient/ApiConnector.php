<?php

namespace App\Http\ApiClient;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\NoReturn;
use mysql_xdevapi\Exception;
use App\Models\Asteroid;

class ApiConnector
{
    private $to;

    private $url;

    private $from;

    private $apiKey;

    public function __construct()
    {
        $this->url = config('api.api_url');
        $this->apiKey = config('api.api_key');
        $this->setDate();
    }

    public function getDataFromApi(): Response
    {
        return Http::get($this->url . "?" . $this->from . "&" . $this->to . "&api_key=" . $this->apiKey);
    }

    public function checkAndSaveData(): string
    {
        $response = json_decode($this->getDataFromApi()->body(), true);

        $message = '';
        if (!key_exists('error', $response)) {
            $this->saveData($response);
            $message = 'Successfully saved to the asteroid table';
        } else {
            $message = $response['error']['message'];
        }

        return $message;
    }

    private function saveData(array $data): void
    {
        try {
            if (!empty($data)){
                foreach ($data['near_earth_objects'] as $key => $items){
                    foreach ($items as $item){
                        if (Asteroid::where('name', $item['name'])->first()){
                            continue;
                        } else {
                            $asteroid = new Asteroid();
                            $asteroid->name = $item['name'];
                            $asteroid->date = $key;
                            $asteroid->reference = $item['neo_reference_id'];
                            $asteroid->speed = $item['close_approach_data'][0]['relative_velocity']['kilometers_per_hour'];
                            $asteroid->is_hazardous = $item['is_potentially_hazardous_asteroid'];
                            $asteroid->save();
                        }
                    }
                }
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }

    }

    private function setDate(): void
    {
        $from = strtotime('-3 days', time());
        $to = time();
        if (!empty(config('api.from')) && str_contains(config('api.from'), 'day')) {
            $from = strtotime(config('api.from'), time());
        }

        if (!empty(config('api.to')) && str_contains(config('api.to'), 'day')) {
            $to = strtotime(config('api.to'), time());
        }

        $this->from = "start_date=" . date("Y-m-d", $from);
        $this->to = "end_date=" . date("Y-m-d", $to);
    }
}
