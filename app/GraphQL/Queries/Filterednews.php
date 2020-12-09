<?php

namespace App\GraphQL\Queries;

use NewsAPI;
use Illuminate\Support\Facades\Http;

class Filterednews
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
	 
	 
	public function resolve($rootValue, array $args)
    {
		$input = collect($args)->toArray();
		
		
		//'https://newsapi.org/v2/top-headlines?'.source.'apiKey='.config('newsapi.api_key');
		
		$url = 'https://newsapi.org/v2/top-headlines?'.$input['filters'].'apiKey='.config('newsapi.api_key');
		$response = Http::get($url);
		
		$articles = $response['articles'];
		
		
		foreach ($articles as &$article){
			
			if($article['source']['id'] == null) {
				$article['source']['id'] = "unknown";
			}
			if($article['source']['name'] == null) {
				$article['source']['name'] = "unknown";
			}
			if($article['title'] == null) {
				$article['title'] = "unknown";
			}
			if($article['author'] == null) {
				$article['author'] = "unknown";
			}
			if($article['description'] == null) {
				$article['description'] = "unknown";
			}
			if($article['url'] == null) {
				$article['url'] = "unknown";
			}
			if($article['urlToImage'] == null) {
				$article['urlToImage'] = "unknown";
			}
			if($article['publishedAt'] == null) {
				$article['publishedAt'] = "unknown";
			}
			if($article['content'] == null) {
				$article['content'] = "unknown";
			}
		}
		
		
		return $articles;
    }
	
}
