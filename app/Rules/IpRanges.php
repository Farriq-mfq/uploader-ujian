<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IpRanges implements ValidationRule
{

    private $BeforeIp;
    public function __construct($ip)
    {
        $this->BeforeIp = $ip;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(preg_match("/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/",$value)){
            $splitIpstart = explode(".", $this->BeforeIp);
            $splitIpsend = explode(".", $value);
            if($splitIpstart[0] != $splitIpsend[0]){
                $fail("Block ip pertama tidak sesuai dengan ip sebelumnya");
            }else if($splitIpstart[1] != $splitIpsend[1]){
                $fail("Block ip kedua tidak sesuai dengan ip sebelumnya");
            }else if($splitIpstart[2] != $splitIpsend[2]){
                $fail("Block ip ketiga tidak sesuai dengan ip sebelumnya");
            }else if($splitIpstart[3] >= $splitIpsend[3]){
                $fail("Ip range tidak valid");
            }
        }else{
            $fail("Ip tidak valid");
        }
    }
}
