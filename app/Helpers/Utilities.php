<?php

namespace App\Helpers;

use App\Models\EmailTemplate;
use App\Models\SystemConfig;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

class Utilities
{

    /**
     * Get system settings(General Setup) from the database.
     *
     * @return object
     */

    public static function getSystemSettings(): object
    {
        $system_settings = SystemConfig::all()->toArray();
        $settings = array();
        foreach ($system_settings as $setting) {
            $settings[$setting['config_key']] = $setting['value'];
        }
        return (object)$settings;
    }
    /**
     * Format currency amount with a symbol and decimal + thousand separator.
     * Default symbol is 'KSh'.
     * Default decimal places is 2.
     * @param float $amount
     * @param string $symbol
     * @param int $dp
     * @return string
     */
    public static function format_currency($amount, $symbol = 'KSh', $dp = 2): string
    {
        return $symbol . ' ' . number_format($amount, $dp, '.', ',');
    }

    /**
     * Get active status of a route. (active or '')
     * This is useful for navigation highlighting.
     * @param string $route
     * @return string
     */
    public static function get_navigation_state_of($route): string
    {
        return request()->routeIs($route) ? 'active' : '';
    }

    /**
     * Get current timestamp in Y-m-d_H-i-s format.
     * This is useful for file name uniqueness
     *
     * @return string
     */
    public static function generate_current_timestamp(): string
    {
        return date('Y-m-d_H-i-s');
    }

    /**
     * Generate a random UUID. Uses built-in Ramsey UUID generator.(v4)
     * This is useful for file name uniqueness
     *
     * @return string
     */
    public static function generate_uuid(): string
    {
        return Uuid::uuid4()->toString(); // e.g., "1f8a5dc4-3c0a-4d2a-9c1e-2b3f4a5b6c7d"
    }

    /**
     * Get verified account status of a user.
     * @param int $user_id
     * @return bool
     */
    public static function is_verified_user($user_id): bool
    {
        $user = User::findorFail($user_id);
        return $user && $user->status_id == self::getSystemSettings()->status_verified;
    }

    /**
     * Get online status of a user.
     * @param int $user_id
     * @return bool
     */
    public static function user_is_online($user_id): bool
    {
        return Cache::has('user-is-online-' . $user_id);
    }

    /**
     * Format bytes to human-readable format
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    public static function format_bytes($bytes, $precision = 2): string {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Generates a username from an email address.
     * @param string $email
     * @return string
     */
    public static function generate_username_from_email($email): ?string
    {
        // Extract the part before the "@" symbol, that becomes the unique username
        $username = explode('@', $email)[0];
        return $username;
    }

    /**
     * Sends an email to a user email address.
     * @param string $email_code
     * @param string $to_email
     * @param array $email_data
     * @return array
     */
    public static function send_email_as_html($email_code,$to_email,$email_data): array
    {
        $email_template = EmailTemplate::where('email_code', $email_code)->first();

        if(!$email_template){
            return ['status'=>false, 'message'=>"Email Template not found "];
        }

        $text_content = $email_template->text_content;
        $subject = $email_template->subject;

        foreach ($email_data as $key => $value) {
            $text_content = str_replace("#".$key."#", $value, $text_content);
        }

        try {
            // Send the email using Laravel's Mail facade
            Mail::raw($text_content, function ($message) use ($to_email,$subject,$text_content ) { // Use raw method for plain text emails {
                $message->to($to_email)
                    ->subject($subject)
                    ->html($text_content);
            }); // Specify HTML content type

            return ['status'=>true, 'message'=>"Email sent successfully!"];
        } catch (\Exception $e) {
            return ['status'=>false, 'message'=>"Error sending email: " . $e->getMessage()];
        }

    }
    public static function send_email_as_plaintext($to_email,$email_subject, $email_body): array
    {

        try {
            // Send the email using Laravel's Mail facade
            Mail::raw($email_body, function ($message) use ($to_email,$email_subject,$email_body) { // Use raw method for plain text emails {
                $message->to($to_email)
                    ->subject($email_subject)
                    ->html($email_body);
            }); // Specify HTML content type

            return ['status'=>true, 'message'=>"Email sent successfully!"];
        } catch (\Exception $e) {
            return ['status'=>false, 'message'=>"Error sending email: " . $e->getMessage()];
        }

    }
}
