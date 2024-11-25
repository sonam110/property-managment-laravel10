<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AppSetting extends Model
{
    use HasFactory;

    public static function smtpDetail()
    {
       
        $smtpDetail = config(
            [
                'mail.driver' => env('MAIL_MAILER'),
                'mail.host' => env('MAIL_HOST'),
                'mail.port' => env('MAIL_PORT'),
                'mail.encryption' =>  env('MAIL_ENCRYPTION'),
                'mail.username' => env('MAIL_USERNAME'),
                'mail.password' => env('MAIL_PASSWORD'),
                'mail.from.address' => env('MAIL_FROM_ADDRESS'),
                'mail.from.name' => env('MAIL_FROM_NAME'),
            ]
        );

        return $smtpDetail;
    }
    public static function settingsById($user_id)
    {
        $data = Utility::getSettingById($user_id);

        $settings = [
            "app_name" => "Signature Group",
            "description" => "RS",
            "app_logo" => "",
            "email" => "",
            "mobile_no" => "g:i A",
            "address" => "",
            "Zipcode" => "",
            "gst_no" => "",
            "pan_no" => "",
            "tax_per" => "",
            "website_url" => "",
            "lease_prefix" => "",
            "tenant_prefix" => "",
            "invoice_prefix" => "#INVO",
            "invoice_disclaimer" => "ffffff",
            "invoice_terms" => "#PROP",
            "recipt_note" => "ffffff",
            "date_format" => "#BILL",
            "generate_invoice_day" => "#EXP",
            "document" => "ffffff",
            "bank_name" => "#CUST",
            "account_holder_name" => "#VEND",
            "account_no" => "",
            "bank_address" => "",
           
        ];

        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    
}
