<?php

//namespace Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations;
namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

// Sending Email Req.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
use vendor\autoload;


class Registery extends BaseAuth
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
		$generated_password = $this->generatePassword();
        $model = $this->createAuthModel($generated_password, $args);

        $this->validateAuthModel($model);

        if ($model instanceof MustVerifyEmail) {
            $model->sendEmailVerificationNotification();

            event(new Registered($model));

            return [
                'tokens' => [],
                'status' => 'MUST_VERIFY_EMAIL',
            ];
        }
        $credentials = $this->buildCredentials([
            'username' => $args[config('lighthouse-graphql-passport.username')],
            'password' => $generated_password,
        ]);
		
        $user = $model->where(config('lighthouse-graphql-passport.username'), $args[config('lighthouse-graphql-passport.username')])->first();
        $response = $this->makeRequest($credentials);
        $response['user'] = $user;
        event(new Registered($user));
		
		$this->sendPassword($generated_password, $args);
		
        return [
            'tokens' => $response,
            'status' => 'SUCCESS',
        ];
    }

    protected function validateAuthModel($model): void
    {
        $authModelClass = $this->getAuthModelFactory()->getClass();

        if ($model instanceof $authModelClass) {
            return;
        }

        throw new \RuntimeException("Auth model must be an instance of {$authModelClass}");
    }

    protected function createAuthModel($password, array $data): Model
    {
        $input = collect($data)->except('password_confirmation')->toArray();
        $input['password'] = Hash::make($password);

        return $this->getAuthModelFactory()->create($input);
    }
	
	protected function generatePassword() 
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		
		for ($i = 0; $i < 10; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		
		return implode($pass); //turn the array into a string
	}
	
	protected function sendPassword($password, $data) 
	{
		$input = collect($data)->except('password_confirmation')->toArray();

		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->SMTPDebug = 0;                
			$mail->isSMTP();                                     
			$mail->Host       = config('mail.mailers.smtp.host');                 
			$mail->SMTPAuth   = true;                                  
			$mail->Username   = config('mail.mailers.smtp.username');                    
			$mail->Password   = config('mail.mailers.smtp.password');              
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         
			$mail->Port       = 465;                                    

			//Recipients
			$mail->setFrom(config('mail.mailers.smtp.username'), 'News Website');
			$mail->addAddress($input['email']);     // Add a recipient
			

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Register Completed';
			$mail->Body    = "<h5>"."You registered successfully, please use this password to access your account: <b>". $password."</b></h5>";
			
			// Send Mail with the password
			$mail->send();
			
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}		
		
	}
}
