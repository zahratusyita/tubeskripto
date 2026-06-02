<?php

namespace App\Services;

use App\Models\Ballot;
use App\Models\RsaKey;
use Illuminate\Support\Facades\Crypt;
use RuntimeException;

class RsaVoteService
{
    private function opensslConfig(): ?string
    {
        $opensslConfig = env('OPENSSL_CONF') ?: 'C:\php\extras\ssl\openssl.cnf';

        return file_exists($opensslConfig) ? $opensslConfig : null;
    }

    public function generateKeyPair(): array
    {
        $opensslConfig = $this->opensslConfig();
        $resource = openssl_pkey_new([
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'config' => $opensslConfig,
        ]);

        if ($resource === false) {
            throw new RuntimeException('Gagal membuat RSA key pair.');
        }

        if (! openssl_pkey_export($resource, $privateKey, null, ['config' => $opensslConfig])) {
            throw new RuntimeException('Gagal mengekspor private key RSA.');
        }

        $details = openssl_pkey_get_details($resource);

        if (! is_array($details) || empty($details['key'])) {
            throw new RuntimeException('Gagal membaca public key RSA.');
        }

        return [
            'public_key' => $details['key'],
            'private_key_encrypted' => Crypt::encryptString($privateKey),
        ];
    }

    public function encryptCandidateId(int $candidateId, string $publicKey): string
    {
        $payload = json_encode(['candidate_id' => $candidateId], JSON_THROW_ON_ERROR);

        if (! openssl_public_encrypt($payload, $encrypted, $publicKey, OPENSSL_PKCS1_OAEP_PADDING)) {
            throw new RuntimeException('Gagal mengenkripsi suara.');
        }

        return base64_encode($encrypted);
    }

    public function decryptCandidateId(Ballot $ballot, RsaKey $rsaKey): int
    {
        $privateKey = Crypt::decryptString($rsaKey->private_key_encrypted);
        $privateKeyResource = openssl_pkey_get_private($privateKey);

        if ($privateKeyResource === false) {
            throw new RuntimeException('Private key RSA tidak valid untuk dekripsi.');
        }

        if (! openssl_private_decrypt(base64_decode($ballot->encrypted_vote), $decrypted, $privateKeyResource, OPENSSL_PKCS1_OAEP_PADDING)) {
            throw new RuntimeException('Gagal mendekripsi ballot.');
        }

        $payload = json_decode($decrypted, true, flags: JSON_THROW_ON_ERROR);

        return (int) $payload['candidate_id'];
    }

    public function integrityHash(string $anonymousTokenHash, string $encryptedVote): string
    {
        return hash_hmac('sha256', $anonymousTokenHash.'|'.$encryptedVote, config('app.key'));
    }
}
