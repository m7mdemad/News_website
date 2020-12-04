<?php

//namespace Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations;
namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

/**
 * Class UpdatePassword.
 */
class UpdateThePassword extends BaseAuth
{
    /**
     * @param $rootValue
     * @param array               $args
     * @param GraphQLContext|null $context
     * @param ResolveInfo         $resolveInfo
     *
     * @return array
     */
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        //$user = $context->user();
		$user = $this->findUser($args['username']);

        if (!Hash::check($args['old_password'], $user->password)) {
            throw new ValidationException([
                'password' => __('Current password is incorrect'),
            ], 'Validation Exception');
        }
        $user->password = Hash::make($args['password']);
        $user->save();
        event(new PasswordUpdated($user));

        return [
            'status'  => 'PASSWORD_UPDATED',
            'message' => __('Your password has been updated'),
        ];
    }
	
	
	protected function makeAuthModelInstance()
    {
        return $this->getAuthModelFactory()->make();
    }
	
	protected function findUser(string $username)
    {
        $model = $this->makeAuthModelInstance();

        if (method_exists($model, 'findForPassport')) {
            return $model->findForPassport($username);
        }

        return $model::query()
            ->where(config('lighthouse-graphql-passport.username'), $username)
            ->first();
    }
}
