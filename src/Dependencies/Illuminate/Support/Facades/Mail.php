<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Testing\Fakes\MailFake;

/**
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Mail\PendingMail bcc($users)
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Mail\PendingMail to($users)
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Collection queued(string $mailable, \Closure|string $callback = null)
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Collection sent(string $mailable, \Closure|string $callback = null)
 * @method static array failures()
 * @method static bool hasQueued(string $mailable)
 * @method static bool hasSent(string $mailable)
 * @method static mixed later(\DateTimeInterface|\DateInterval|int $delay, \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Mail\Mailable|string|array $view, string $queue = null)
 * @method static mixed queue(\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Mail\Mailable|string|array $view, string $queue = null)
 * @method static void assertNotQueued(string $mailable, callable $callback = null)
 * @method static void assertNotSent(string $mailable, callable|int $callback = null)
 * @method static void assertNothingQueued()
 * @method static void assertNothingSent()
 * @method static void assertQueued(string $mailable, callable|int $callback = null)
 * @method static void assertSent(string $mailable, callable|int $callback = null)
 * @method static void raw(string $text, $callback)
 * @method static void send(\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Mail\Mailable|string|array $view, array $data = [], \Closure|string $callback = null)
 *
 * @see \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Mail\Mailer
 * @see \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Testing\Fakes\MailFake
 */
class Mail extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Testing\Fakes\MailFake
     */
    public static function fake()
    {
        static::swap($fake = new MailFake);

        return $fake;
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mail.manager';
    }
}
