<?php

namespace Gigablah\Silex\QrCode;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Endroid\QrCode\QrCode;

/**
 * QR code generation provider.
 *
 * @author Chris Heng <bigblah@gmail.com>
 */
class QrCodeServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['qrcode.options'] = array();

        $pimple['qrcode'] = $pimple->share(function ($app) {
            $qrCode = new QrCode();

            foreach ($pimple['qrcode.options'] as $key => $value) {
                $method = 'set'.implode('', array_map('ucwords', explode('_', $key)));

                if (method_exists($qrCode, $method)) {
                    $qrCode->$method($value);
                }
            }

            return $qrCode;
        });
    }

    public function boot(Container $pimple)
    {
    }
}
