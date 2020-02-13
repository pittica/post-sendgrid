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

require dirname(__DIR__) . '/vendor/autoload.php';

use Pittica\PostSendGrid\Application;

$application = new Application();
$application->run();