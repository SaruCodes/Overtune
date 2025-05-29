<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SpotifyService
{
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = $this->getAccessToken();
    }

    protected function getAccessToken()
    {
        $clientId = config('services.spotify.client_id');
        $clientSecret = config('services.spotify.client_secret');

        $response = Http::asForm()->withHeaders(['Authorization' => 'Basic ' . base64_encode("$clientId:$clientSecret"),])
            ->post('https://accounts.spotify.com/api/token', ['grant_type' => 'client_credentials',]);

        return $response->json()['access_token'] ?? null;
    }

    public function searchAlbum($albumName, $artistName = null)
    {
        $query = $albumName;
        if ($artistName) {
            $query .= " artist:$artistName";
        }

        $response = Http::withToken($this->accessToken)->get('https://api.spotify.com/v1/search', [
                'q' => $query,
                'type' => 'album',
                'limit' => 1,
            ]);

        return $response->json()['albums']['items'][0] ?? null;
    }
}
