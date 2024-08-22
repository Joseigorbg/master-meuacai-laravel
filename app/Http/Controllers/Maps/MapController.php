<?php

namespace App\Http\Controllers\Maps;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class MapController extends Controller
{
    public function searchLocation(Request $request)
    {
        $query = $request->get('q');
        if ($query) {
            $client = new Client();
            $url = 'https://nominatim.openstreetmap.org/search?format=json&q=' . urlencode($query);

            try {
                $response = $client->request('GET', $url, [
                    'headers' => [
                        'User-Agent' => 'Laravel Application',
                    ],
                ]);
                $body = $response->getBody();
                $content = $body->getContents();

                Log::info('Nominatim Response: ' . $content);

                // Verifique se o conteúdo é JSON válido
                $json = json_decode($content, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return response()->json($json);
                } else {
                    Log::error('Invalid JSON response from Nominatim');
                    return response()->json(['error' => 'Invalid JSON response from Nominatim'], 500);
                }
            } catch (\Exception $e) {
                Log::error('Error fetching location: ' . $e->getMessage());
                return response()->json(['error' => 'Unable to fetch location data'], 500);
            }
        }
        return response()->json([]);
    }
}
