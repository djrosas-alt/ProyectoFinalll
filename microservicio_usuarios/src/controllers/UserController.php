<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\AuthToken;

class UserController
{
    
    public function register($req, $res)
    {
        $data = $req->getParsedBody();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],  
            'role' => $data['role'],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $res->withJson(['message' => 'Usuario registrado', 'user' => $user]);
    }

    
    public function login($req, $res)
    {
        $data = $req->getParsedBody();
$user = User::where('email', $data['email'])->first();

        if (!$user || $user->password !== $data['password']) {
            return $res->withJson(['error' => 'Credenciales inválidas'], 401);
        }

        
        $token = bin2hex(random_bytes(32));

        AuthToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $res->withJson([
            'message' => 'Login exitoso',
            'token' => $token,
            'user' => $user
        ]);
    }

  
    public function validarToken($req, $res)
    {
        $token = $req->getHeaderLine('Authorization');

        $valid = AuthToken::where('token', $token)->first();

        if (!$valid) {
            return $res->withJson(['error' => 'Token inválido'], 401);
        }
 return $res->withJson(['message' => 'Token válido']);
    }

 
    public function logout($req, $res)
    {
        $token = $req->getHeaderLine('Authorization');

        AuthToken::where('token', $token)->delete();

        return $res->withJson(['message' => 'Sesión cerrada']);
    }
}