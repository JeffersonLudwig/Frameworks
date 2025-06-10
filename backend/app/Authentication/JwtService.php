<?php

namespace App\Authentication;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use DateTimeImmutable;

class JwtService
{
    private Configuration $config;


    public function __construct(string $secret)
    {
        $this->config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($secret)
        );
    }


    public function gerarToken(array $claims, int $expSegundos = 3600): string
    {
        $agora = new DateTimeImmutable();
        $builder = $this->config->builder()
            ->issuedAt($agora)
            ->expiresAt($agora->modify("+{$expSegundos} seconds"));

        foreach ($claims as $chave => $valor) {
            $builder = $builder->withClaim($chave, $valor);
        }

        $token = $builder->getToken($this->config->signer(), $this->config->signingKey());
        return $token->toString();
    }


    public function validarToken(string $jwt): array|false
    {
        try {
            $token = $this->config->parser()->parse($jwt);

            /** @var UnencryptedToken $token */

            $clock = new SystemClock(new \DateTimeZone('UTC'));

            $constraints = [
                new SignedWith($this->config->signer(), $this->config->signingKey()),
                new ValidAt($clock),
            ];

            if (!$this->config->validator()->validate($token, ...$constraints)) {
                return false;
            }

            return $token->claims()->all();
        } catch (\Throwable $e) {
            return false;
        }
    }
}
