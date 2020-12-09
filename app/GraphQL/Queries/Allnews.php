<?php

namespace App\GraphQL\Queries;

use NewsAPI;
use Illuminate\Support\Facades\Http;

class Allnews
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
	 
	 
	public function resolve($rootValue, array $args)
    {
		
		$url = 'https://newsapi.org/v2/top-headlines?sources=techcrunch,bbc-news&apiKey='.config('newsapi.api_key');
		$response = Http::get($url);
		
		return $response['articles'];
    }
	
}
