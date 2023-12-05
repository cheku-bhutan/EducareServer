<?php

use App\Mail\Welcome;
use App\Mail\DefaultMail;
use Illuminate\Support\Facades\Mail;

if (!function_exists('send_email')) {
    function send_email($to, $subject, $detail, $template = 'default')
    {
        $mailable_template = match ($template) {
            'welcome' => new Welcome($subject, $detail),
            default => new DefaultMail($subject, $detail),
        };
        try {
            Mail::to($to)->send($mailable_template);
        } catch (\Exception $e) {
            return $e;
        }
    }
}