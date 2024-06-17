<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class RssFeedController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('https://timesofindia.indiatimes.com/rssfeeds/-2128838597.cms?feedtype=json');
        $data = $response->json();

        // Adjust the structure based on actual response
        if (isset($data['channel']['item'])) {
            $items = $data['channel']['item'];
        } else {
            $items = []; // Fallback in case of missing data
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $items = array_filter($items, function($item) use ($search) {
                return stripos($item['title'], $search) !== false;
            });
        }

        // Sort functionality
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            usort($items, function($a, $b) use ($sort) {
                return strcmp($a[$sort], $b[$sort]);
            });
        }

        // Pagination functionality
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = array_slice($items, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($items), $perPage);

        return view('rss_feed.index', [
            'items' => $paginatedItems,
            'search' => $request->input('search'),
            'sort' => $request->input('sort')
        ]);
    }
}
