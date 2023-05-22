<?php

require_once 'vendor/autoload.php'; // Assuming you have the necessary JWT library installed

use \Firebase\JWT\JWT;

class AuthorisationController
{
    private $secretKey = 'your-secret-key'; // Replace with your own secret key

    public function connectUser($username, $password, $userId)
    {
        $payload = array(
            'username' => $username,
            'password' => $password,
            'userId' => $userId
        );

        $token = JWT::encode($payload, $this->secretKey); // Encode the payload into a JWT token

        // Return the token in JSON format
        header('Content-Type: application/json');
        echo json_encode(array('token' => $token));
        exit;
    }

    public function authenticate()
    {
        $token = $this->getTokenFromRequest(); // Get the token from the request

        if ($token) {
            try {
                // Verify and decode the token using the secret key
                $decoded = JWT::decode($token, $this->secretKey, array('HS256'));

                // Proceed with the request handling

            } catch (Exception $e) {
                // Token verification failed
                header('HTTP/1.0 401 Unauthorized');
                echo json_encode(array('error' => 'Invalid token'));
                exit;
            }
        } else {
            // No token provided
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(array('error' => 'No token provided'));
            exit;
        }
    }

    private function getTokenFromRequest()
    {
        $headers = getallheaders(); // Get all request headers
        $authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

        if (preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            // Extract the token from the Authorization header
            return $matches[1];
        }

        return null;
    }
}

// Update your existing code
spl_autoload_register(function ($class) {
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';
});

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Create an instance of the AuthorisationController
//Put this code on the top of each route unless for the connexion one
$authController = new AuthorisationController();
$authController->authenticate(); // Authenticate the user before processing the request

// Rest of your existing code...
// ...


/*

I have added comments to explain each part of the code:

The require_once 'vendor/autoload.php'; line assumes that you have already installed the JWT library using Composer and it is located in the vendor directory. Adjust the path accordingly if needed.

The use \Firebase\JWT\JWT; statement imports the necessary JWT class for token handling.

The AuthorisationController class has a private $secretKey property which should be replaced with your own secret key. This key is used for signing and verifying the JWT tokens.

The authenticate() method checks for the presence of a JWT token in the request and verifies its validity. If the token is valid, the request processing continues. Otherwise, a 401 Unauthorized response is returned.

The getTokenFromRequest() method extracts the token from the Authorization header of the request.

In your existing code, the spl_autoload_register() function is used to autoload the necessary classes. Make sure the autoloading functionality is correctly set up.

The header() function is used to set the response headers for JSON content type and Access-Control-Allow-Origin.

An instance of the AuthorisationController is created, and the authenticate() method is called to authenticate the user before processing the request.

The rest of your existing code follows after the authentication step.

Remember to customize the code according to your specific needs, such as replacing the secret key, adjusting paths, and making any additional modifications required for your application.