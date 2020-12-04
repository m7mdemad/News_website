<?php

namespace App\GraphQL\Queries;
use NewsAPI;

class Allnews
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke(): string
    {
        $response = NewsAPI::sources()->all();
		return $response[0]['author'];
    }
}
