<?php

//namespace Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations;
namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;

//use joshcam\mysqli-database-class\MysqliDb;

class DeleteArticle 
{
    /**
     * @param $rootValue
     * @param array                                                    $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext|null $context
     * @param \GraphQL\Type\Definition\ResolveInfo                     $resolveInfo
     *
     * @throws \Exception
     *
     * @return array
     */
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
		
		//$servername = config('database.mysql.host');
		//$username = config('database.mysql.username');
		//$password = config('database.mysql.password');
	//	$dbname = config('database.mysql.database');
		
//		$conn = new MysqliDb ($servername, $username, $password, $dbname);

        $input = collect($args)->toArray();
		
		$sql = "DELETE FROM articles WHERE user_id=".$input['user_id']." and title=\"".$input['title']."\"";		
		
		DB::delete($sql);
		//DB::delete('delete * from articles where user_id = ? and and title = "? ', [$input['user_id'], $input['title']]);
		return [
            'status' => 'Article removed from your favourites',
		];
		
		
    }
	
}
