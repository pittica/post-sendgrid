<?php
/**
 * post-sendgrid (https://github.com/pittica/post-sendgrid)
 * Copyright (c) Pittica S.r.l.s. (https://pittica.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @category  Mailer
 * @package   post-sendgrid
 * @author    Lucio Benini <info@pittica.com>
 * @copyright 2020 Pittica S.r.l.s. (https://pittica.com)
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @link      https://pittica.com Pittica S.r.l.s.
 * @since     1.0.0
 */

namespace Pittica\PostSendGrid;

/**
 * ReCaptcha client.
 * @package Pittica\PostSendGrid
 * @author Lucio Benini <info@pittica.com>
 * @since 1.0.0
 */
class ReCaptcha
{
    /**
     * The configuration.
     * @var array
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    private $_config = [];

    /**
     * Application constructor.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function __construct()
    {
        $config = new Configuration;
        $this->_config = $config->get('recaptcha');
    }

    /**
     * Validates the captcha input.
     * @return bool A value indicating whether the request has been validated.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function validate(): bool
    {
        if (!empty($this->_config)) {
            $server = new Server;
            $response = $server->getField($this->_config['field']);

            if ($response) {
                $recaptcha = new \ReCaptcha\ReCaptcha($this->_config['key']);

                return $recaptcha->verify($response, $server->getRemoteAddress())->isSuccess();
            }

            return false;
        }

        return true;
    }
}
