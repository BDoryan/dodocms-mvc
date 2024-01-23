<?php

class JWTUtils
{
    private string $secretKey;
    private int $expiresIn;

    public function __construct(string $secretKey, int $expiresIn = 3600)
    {
        $this->secretKey = $secretKey;
        $this->expiresIn = $expiresIn;
    }

    /**
     * Return a token with the claims
     *
     * @param array $claims
     * @param int|null $expiresIn
     * @return string
     */
    public function createToken(array $claims, ?int $expiresIn = null): string
    {
        if($expiresIn == null) {
            $expiresIn = $this->expiresIn;
        }
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));

        $claims['exp'] = time() + $expiresIn;

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
                Application::get()->getLogger()->warning("Token expired");
            }
        } else {
            Application::get()->getLogger()->warning("Invalid signature");
        }
        return null;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }
}