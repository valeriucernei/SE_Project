<?php
use Composer\InstalledVersions;
require_once dirname(__FILE__).'/../config.php';
require_once dirname(__FILE__).'/../../vendor/autoload.php';

/**
 * Client Class to interact with SMTP Server
 *
 */
class SMTPClient {

    private $mailer;

    /**
     * Estabilish connection and settings for SMTP Server
     */
    public function __construct() {
        $transport = (new Swift_SmtpTransport(Config::SMTP_HOST(),
                                              Config::SMTP_PORT(), 'tls'))
                                              ->setUsername(Config::SMTP_USER())
                                              ->setPassword(Config::SMTP_PASSWORD());

        $this->mailer = new Swift_Mailer($transport);
    }

    /**
     * Send email with confirmation link to the user's email address
     * @param  object $user user's data object
     */
    public function send_register_user_token($user) {
        $message = (new Swift_Message('CarMarket | Confirm Registration'))
                    ->setFrom([
                        'noreply@car-market.live' => 'CarMarket No Reply Mail'])
                    ->setTo([$user['email']])
                    ->setBody(
                        'Confirmation link: https://car-market.live/?confirmation='.
                        $user['token']."#confirm");
        $this->mailer->send($message);
    }

    /**
     * Send email with Successful Email Confirmation text
     * @param  object $user user's data object
     */
    public function send_confirmed_email($user){
        $message = (new Swift_Message('CarMarket | Confirm Registration'))
                    ->setFrom([
                        'noreply@car-market.live' => 'CarMarket No Reply Mail'])
                    ->setTo([$user['email']])
                    ->setBody('Your account has been successfully activated!');
        $this->mailer->send($message);
    }

    /**
     * Send email with a recovery link for password reset
     * @param  object $user User's data object
     */
    public function send_recovery_email($user){
        $message = (new Swift_Message('CarMarket | Reset Password Link'))
            ->setFrom(['noreply@car-market.live' => 'CarMarket No Reply Mail'])
            ->setTo([$user['email']])
            ->setBody('Recovery link: https://car-market.live/?token='.$user['token']."#reset");
        $this->mailer->send($message);
    }

}
