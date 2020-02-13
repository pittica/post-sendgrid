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
 * Represents the form variables and message body parts.
 * @package Pittica\PostSendGrid
 * @author Lucio Benini <info@pittica.com>
 * @since 1.0.0
 */
class BodyParts
{
    /**
     * The configuration.
     * @var array
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    private $_config = [];

    /**
     * The variables.
     * @var array
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    private $_vars = [];

    /**
     * The formatted variables.
     * @var array
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    private $_parts = [];

    /**
     * BodyParts constructor.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function __construct()
    {
        $config = new Configuration;

        $this->_config = $config->get('fields');
        $this->_vars = $this->_processFields();
        $this->_parts = $this->_formatFields();
    }

    /**
     * Gets the e-mail address.
     * @return string The e-mail address.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function getAddress(): string
    {
        return $this->_getValue('email');
    }

    /**
     * Gets the sender's name.
     * @return string The sender's name.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function getName(): string
    {
        return $this->_getValue('name');
    }

    /**
     * Gets the subject.
     * @return string The subject.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function getSubject(): string
    {
        return $this->_getValue('subject');
    }

    /**
     * Gets a value from the raw variables.
     * @param string $key The key of the associated value.
     * @return string A value from the raw variables.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    protected function _getValue(string $key): string
    {
        return !empty($this->_vars[$this->_config[$key]]) ? $this->_vars[$this->_config[$key]] : '';
    }

    /**
     * Returns an HTML representation of the current object.
     * @return string An HTML representation of the current object.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function toHTML(): string
    {
        $out = '';

        foreach ($this->_vars as $label => $var) {
            $out .= '<li><h4>' . $label . '</h4>' . $var . '</li>';
        }

        return $out;
    }

    /**
     * Returns a string representation of the current object.
     * @return string A string representation of the current object.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function toString(): string
    {
        $out = '';

        foreach ($this->_vars as $label => $var) {
            $out .= $label . ':' . PHP_EOL . $var . PHP_EOL . PHP_EOL;
        }

        return $out;
    }

    /**
     * Returns a string representation of the current object.
     * @return string A string representation of the current object.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Formats an array of form variables in an array of label/value.
     * @return array An array of label/value.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    protected function _formatFields(): array
    {
        if (!empty($this->_config['labels'])) {
            $res = [];

            foreach ($this->_vars as $key => $value) {
                if (!empty($this->_config['labels'][$key])) {
                    $res[$this->_config['labels'][$key]] = $value;
                }
            }

            return $res;
        }

        return $this->_vars;
    }

    /**
     * Processes an array of form variables.
     * @return array An array of variables.
     * @author Lucio Benini <info@pittica.com>
     * @since 1.0.0
     */
    protected function _processFields(): array
    {
        $res = [];
        $fields = array_merge([$this->_config['email'], $this->_config['subject'], $this->_config['name']], $this->_config['whitelisted']);

        if (!empty($fields)) {
            $server = new Server;

            foreach ($server->getFields() as $key => $var) {
                if (in_array($key, $fields)) {
                    $res[$key] = $var;
                }
            }
        }

        return $res;
    }
}
