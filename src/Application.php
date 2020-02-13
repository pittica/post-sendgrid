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

use SendGrid\Mail\Mail;

/**
 * Application main class.
 * @package Pittica\PostSendGrid
 * @author Lucio Benini <info@pittica.com>
 * @since 1.0.0
 */
class Application
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
     * @throws \Exception Method is not POST.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function __construct()
    {
        $server = new Server;

        if (!$server->isPost()) {
            http_response_code(200);

            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Authorization, Content-Type, Accept, Origin');

            exit(0);
        }

        $config = new Configuration;
        $this->_config = $config->get();
    }

    /**
     * Runs the application.
     * @return void
     * @throws \SendGrid\Mail\TypeException
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function run(): void
    {
        $recaptha = new ReCaptcha;

        if ($recaptha->validate()) {
            $vars = new BodyParts();
            $message = new Mail();
            $email = $vars->getAddress();
            $subject = $vars->getSubject();
            $name = $vars->getName();

            if (!$name) {
                $name = $email;
            }

            $message->setFrom($email, $name);
            $message->setSubject($subject ? $subject : ('Message from: ' . $name));
            $message->addTo($this->_config['sender']['address'], $this->_config['sender']['name']);
            $message->addContent("text/plain", $vars->toString());
            $message->addContent("text/html", $vars->toHTML());
            $client = new \SendGrid($this->_config['api']['key']);

            header('Content-type:application/json;charset=utf-8');

            try {
                $this->_respond($client->send($message)->statusCode());
            } catch (\Exception $e) {
                $this->_respond(500);
            }
        }

        $this->_respond(403);
    }

    /**
     * Prepares and output the JSON response.
     * @param int $code HTTP code.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    protected function _respond(int $code): void
    {
        http_response_code($code);

        die(json_encode([
            'error' => $code < 200 || $code >= 300
        ]));
    }
}
