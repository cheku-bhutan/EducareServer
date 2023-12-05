<?php

namespace App\Services;

use App\Models\UserSignupOtp;
use Carbon\Carbon;

class OtpService
{
    /**
     * Length of the generated OTP
     * @var int
     */
    protected $length;

    /**
     * Generated OPT type
     * @var bool
     */
    protected $only_digits;

    /**
     * use same token to resending opt
     * @var bool
     */
    protected $use_same_token;

    /**
     * Otp Validity time
     * @var int
     */
    protected $validity;

    /**
     * Delete old otps
     * @var int
     */
    protected $delete_old_otps;

    /**
     * Maximum otps allowed to generate
     * @var int
     */
    protected $maximum_otps_allowed;

    /**
     * Maximum number of times to allowed to validate
     * @var int
     */
    protected $allowed_attempts;

    public function __construct()
    {
        $this->length = config('otp.length');
        $this->only_digits = config('otp.only_digits');
        $this->use_same_token = config('otp.use_same_token');
        $this->validity = config('otp.validity');
        $this->delete_old_otps = config('otp.delete_old_otps');
        $this->maximum_otps_allowed = config('otp.maximum_otps_allowed');
        $this->allowed_attempts = config('otp.allowed_attempts');
    }

    public function generate($identifier): object
    {
        $this->delete_old_otps();

        $otp = UserSignupOtp::where('identifier', $identifier)->first();

        if ($otp == null) {
            $otp = UserSignupOtp::create([
                'identifier' => $identifier,
                'token' => $this->create_pin(),
                'validity' => $this->validity,
                'generated_at' => Carbon::now(),
            ]);
        } else {
            if ($otp->no_times_generated == $this->maximum_otps_allowed) {
                return (object)[
                    'status' => false,
                    'message' => "Reached the maximum limits to generate OTP",
                ];
            }

            $otp->update([
                'identifier' => $identifier,
                'token' => $this->use_same_token ? $otp->token : $this->create_pin(),
                'validity' => $this->validity,
                'generated_at' => Carbon::now(),
            ]);

        }

        $otp->increment('no_times_generated');

        return (object)[
            'status' => true,
            'token' => $otp->token,
            'message' => "OTP generated",
        ];
    }

    public function validate($identifier, $token): object
    {
        $otp = UserSignupOtp::where('identifier', $identifier)->first();

        if (!$otp) {
            return (object)[
                'status' => false,
                'message' => 'OTP does not exists, Please generate new OTP',
            ];
        }

        if ($otp->is_expired()) {
            return (object)[
                'status' => false,
                'message' => 'OTP is expired',
            ];
        }

        if ($otp->no_times_attempted == $this->allowed_attempts) {
            return (object)[
                'status' => false,
                'message' => "Reached the maximum allowed attempts",
            ];
        }

        $otp->increment('no_times_attempted');

        if ($otp->token == $token) {
            return (object)[
                'status' => true,
                'message' => 'OTP is valid',
            ];
        }

        return (object)[
            'status' => false,
            'message' => 'OTP does not match',
        ];
    }

    public function expired_at($identifier): object
    {
        $otp = UserSignupOtp::where('identifier', $identifier)->first();

        if (!$otp) {
            return (object)[
                'status' => false,
                'message' => 'OTP does not exists, Please generate new OTP',
            ];
        }

        return (object)[
            'status' => true,
            'expired_at' => $otp->expired_at(),
        ];
    }

    private function delete_old_otps():void
    {
        UserSignupOtp::where('expired', true)
            ->orWhere('created_at', '<', Carbon::now()->subMinutes($this->delete_old_otps))
            ->delete();
    }

    private function create_pin(): string
    {
        if ($this->only_digits) {
            $characters = '0123456789';
        } else {
            $characters = '123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
        }
        $length = strlen($characters);
        $pin = '';
        for ($i = 0; $i < $this->length; $i++) {
            $pin .= $characters[rand(0, $length - 1)];
        }

        return $pin;
    }
}
