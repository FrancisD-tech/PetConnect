<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class supabase
{
    protected $url;
    protected $key;

    public function __construct()
    {
        $this->url = env('SUPABASE_URL') . '/rest/v1/';
        $this->key = env('SUPABASE_KEY');
    }

    public function query($table, $filters = [])
    {
        return Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
        ])
        ->get($this->url . $table, $filters)
        ->json();
    }

    public function insert($table, $data)
    {
        return Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ])
        ->post($this->url . $table, $data)
        ->json();
    }
}
