<?php

namespace App\Helpers;

use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyEmail;

class MailHelper
{
    public static function sendTemplateMail($templateCode, $toEmail, $replacements)
    {
        $template = EmailTemplate::where('code', $templateCode)->first();
        $subject = $template->subject;

        $content = $template->content;
        foreach ($replacements as $placeholder => $value) {
            $content = str_replace("[$placeholder]", $value, $content);
        }

        Mail::to($toEmail)->send(new MyEmail($content, $subject));
    }
}
