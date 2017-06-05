<?php
namespace application\components\utility;

class Pbkdf2
{
    public $hashAlgorithm = 'sha256';
    public $iterations = 1000;
    public $saltBytes = 24;
    public $hashBytes = 24;

    private static $sections = 4;
    private static $algorithmIndex = 0;
    private static $iterationIndex = 1;
    private static $saltIndex = 2;
    private static $pbkdf2Index = 3;

    public function createHash($password)
    {
        // format: algorithm:iterations:salt:hash
        $salt = base64_encode(mcrypt_create_iv($this->saltBytes, MCRYPT_DEV_URANDOM));
        return $this->hashAlgorithm.":".$this->iterations.":".$salt.":".
            base64_encode($this->pbkdf2($password, $salt, true));
    }

    public static function validatePassword($password, $goodHash)
    {
        $params = explode(":", $goodHash);
        if (count($params) < self::$sections) {
            return false;
        }
        $hash = base64_decode($params[self::$pbkdf2Index]);

        $pbkdf2 = new Pbkdf2();
        $pbkdf2->hashAlgorithm = $params[self::$algorithmIndex];
        $pbkdf2->iterations = $params[self::$iterationIndex];
        $pbkdf2->hashBytes = strlen($hash);

        return self::slowEquals($hash, $pbkdf2->pbkdf2($password, $params[self::$saltIndex], true));
    }

    /**
     * Compares two strings $a and $b in length-constant time.
     *
     * @param string $a
     * @param string $b
     * @return bool
     */
    private static function slowEquals($a, $b)
    {
        $diff = strlen($a) ^ strlen($b);
        for ($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $diff === 0;
    }

    /**
     * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
     *
     * @param string $password The password.
     * @param string $salt A salt that is unique to the password.
     * @param bool $raw_output If true, the key is returned in raw binary format. Hex encoded otherwise.
     * @return string A $this->hashBytes-byte key derived from the password and salt.
     *
     * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
     * This implementation of PBKDF2 was originally created by https://defuse.ca
     * With improvements by http://www.variations-of-shadow.com
     */
    public function pbkdf2($password, $salt, $raw_output = false)
    {
        $algorithm = strtolower($this->hashAlgorithm);
        if (!in_array($algorithm, hash_algos(), true)) {
            die('PBKDF2 ERROR: Invalid hash algorithm.');
        }
        if ($this->iterations <= 0 || $this->hashBytes <= 0) {
            die('PBKDF2 ERROR: Invalid parameters.');
        }

        $hash_length = strlen(hash($algorithm, "", true));
        $block_count = ceil($this->hashBytes / $hash_length);

        $output = "";
        for ($i = 1; $i <= $block_count; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt.pack("N", $i);
            // first iteration
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < $this->iterations; $j++) {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }

        if ($raw_output) {
            return substr($output, 0, $this->hashBytes);
        } else {
            return bin2hex(substr($output, 0, $this->hashBytes));
        }
    }
}