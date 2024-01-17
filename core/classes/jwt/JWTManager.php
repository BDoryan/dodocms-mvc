<?php

class JWTManager
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function createToken(array $claims, $expiration = 3600)
    {
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));

        $claims['exp'] = time() + $expiration;

        $headerClaims = base64_encode(json_encode($claims));

        $signature = hash_hmac('sha256', "$header.$headerClaims", $this->secretKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return "$header.$headerClaims.$base64UrlSignature";
    }

    public function verifyToken($token)
    {
        list($receivedHeader, $receivedClaims, $receivedSignature) = explode('.', $token);

        $calculatedSignature = hash_hmac('sha256', "$receivedHeader.$receivedClaims", $this->secretKey, true);
        $base64UrlCalculatedSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($calculatedSignature));

        if ($base64UrlCalculatedSignature === $receivedSignature) {
            $decodedClaims = json_decode(base64_decode($receivedClaims), true);

            if (isset($decodedClaims['exp']) && $decodedClaims['exp'] > time()) {
                return $decodedClaims;
            } else {
                throw new Exception("Token expired");
            }
        } else {
            throw new Exception("Invalid signature");
        }
    }
}

//// Exemple d'utilisation de la classe
//$jwtManager = new JWTManager('votre_clé_secrète');
//
//// Créer un token avec des réclamations personnalisées
//$token = $jwtManager->createToken(['user_id' => 123, 'username' => 'john_doe'], 3600);
//
//// Afficher le token
//echo "Token: $token\n";
//
//// Vérifier le token
//try {
//    $decodedPayload = $jwtManager->verifyToken($token);
//    print_r($decodedPayload);
//} catch (Exception $e) {
//    echo "Erreur: " . $e->getMessage();
//}
//?>
