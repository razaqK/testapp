<?php


namespace App\Security;


use App\Constant\Messages;
use Carbon\Carbon;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\ValidationData;

class JWT implements Authenticator
{
    private static $signer;
    private static $privatekey;
    private static $publickey;

    public function __construct()
    {
        self::$signer = new Sha256();
        self::$privatekey = new Key('file://../data/rsa_appkey');
        self::$publickey = new Key('file://../data/rsa_appkey.pub');
    }

    public function generate(array $data = []): string
    {
        $now = Carbon::now();
        $expiryTime = $now
            ->addSeconds(3000);

        $jwtToken = (new Builder())->issuedBy('s@l0od-ap1')
            ->issuedAt(time())
            ->expiresAt(strtotime($expiryTime))
            ->withHeader(
                "token",
                $data
            )
            ->getToken(self::$signer, self::$privatekey);
        return (string)$jwtToken;
    }

    public function authenticate(string $token): array
    {
        try {
            $jwtToken = (new Parser())->parse($token);
            if (!$jwtToken->verify(self::$signer, self::$publickey)) {
                return ['message' => Messages::ACCESS_DENIED, 'code' => 401];
            }

            $data = new ValidationData();
            $data->setIssuer('s@l0od-ap1');

            if ($jwtToken->isExpired()) {
                return ['message' => Messages::TOKEN_EXPIRED, 'code' => 401];
            }

            if (!$jwtToken->validate($data)) {
                return ['message' => Messages::ACCESS_DENIED, 'code' => 401];
            }

            return ['message' => '', 'code' => 200, 'data' => $jwtToken->getHeader('token')];
        } catch (\Exception $e) {
            return ['message' => Messages::ACCESS_DENIED, 'code' => 401];
        }
    }
}