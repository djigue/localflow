<?php

namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private string $secret;

    // 🔐 Le constructeur récupère la clé secrète grâce à l'injection
    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    // 🧾 Cette méthode génère un token avec les données qu'on lui passe
    public function generateToken(array $payload, int $expiration = 3600): string
    {
        $issuedAt = time();                      // ⏰ Heure actuelle
        $expireAt = $issuedAt + $expiration;    // ⏳ Expiration dans X secondes

        $payload['iat'] = $issuedAt;            // iat = issued at
        $payload['exp'] = $expireAt;            // exp = expiration

        // 🔐 Génère le token avec la clé et l’algorithme HS256
        return JWT::encode($payload, $this->secret, 'HS256');
    }

    // 🔍 Cette méthode vérifie et décode un token
    public function decodeToken(string $jwt): array
    {
        return (array) JWT::decode($jwt, new Key($this->secret, 'HS256'));
    }
}
