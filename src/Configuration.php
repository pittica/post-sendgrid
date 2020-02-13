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
 * Configuration reader.
 * @package Pittica\PostSendGrid
 * @author Lucio Benini <info@pittica.com>
 * @since 1.0.0
 */
class Configuration
{
    /**
     * The configuration data.
     * @var array
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    private $_data = [];

    /**
     * Configuration constructor.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->_data = include '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'app.php';
    }

    /**
     * Gets configuration data.
     * @param $key string Configuration key.
     * @return array|string|null The configuration data.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function get(string $key = '')
    {
        if (empty($key)) {
            return $this->_data;
        }

        return !empty($this->_data[$key]) ? $this->_data[$key] : null;
    }
}