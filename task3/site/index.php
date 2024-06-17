<?php

namespace Src;

use Config\Config;
use Firebase\JWT\Key;
use Model\UserModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Service\UserService;
use Slim\Factory\AppFactory;
use Firebase\JWT\JWT;
use Tuupola\Middleware\JwtAuthentication;

require_once __DIR__ . '/vendor/autoload.php';

if (!file_exists(Config::$dbFile)) {
    require_once 'config/initdb.php';
}

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$app->add(new JwtAuthentication([
    "path" => ["/getusers"],
    "ignore" => ["'/login", "/test"],
    "secret" => ["acme" => Config::$jwtSecret]
]));

$userService = new UserService();

$app->post('/login', function (Request $request, Response $response, $args) use ($userService) {
    $data = $request->getParsedBody();
    $username = $data['username'];
    $password = $data['password'];

    if (!$user = $userService->getUser($username)) {
        $user = new UserModel($username, $password);
        $user = $userService->registerUser($user);
    }
    if (password_verify($password, $user->getPassword())) {
        $token = JWT::encode(['username' => $user->getUsername()], Config::$jwtSecret, "HS256");
    }
    $response->getBody()->write(json_encode(['token' => $token, 'count' => $user->getCount()]));
    return $response;
});

$app->post('/addonemore', function (Request $request, Response $response, $args) use ($userService) {
    $tokenEncoded = str_replace('Bearer ', '', $request->getHeader("Authorization"))[0];
    $token = JWT::decode($tokenEncoded, new Key(Config::$jwtSecret, "HS256"));
    if (isset($token->username)) {
        $user = $userService->getUser(($token->username));
        if ($userService->addOneMore($user)) {
            $response->getBody()->write(json_encode(['count' => $user->getCount() + 1]));
            return $response;
        }
        return $response->withStatus(500)
            ->getBody()
            ->write(json_encode(['error' => 'Cant update value']));
    } else {
        return $response->withStatus(401);
    }
});

$app->run();


