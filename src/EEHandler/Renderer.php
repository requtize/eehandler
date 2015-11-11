<?php
/**
 * This file is part of the EEHandler - PHP Error and Exception Handler.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Copyright (c) 2015 by Adam Banaszkiewicz
 *
 * @license   MIT License
 * @copyright Copyright (c) 2015, Adam Banaszkiewicz
 * @link      https://github.com/requtize/eehandler
 */

namespace EEHandler\EEHandler;

class Renderer
{
    protected $backtrace = [];
    protected $headline = null;
    protected $message = null;
    protected $fileCousingError = null;
    protected $errorLine = null;

    public function render()
    {
        if(! headers_sent())
        {
            header('HTTP/1.0 500 Internal Server Error');
        }

        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            $filepath = 'Resources/template-ajax-'.EEHANDLER_ENV.'.php';
        }
        else
        {
            $filepath = 'Resources/template-'.EEHANDLER_ENV.'.php';
        }

        $ROOT = realpath(__DIR__);

        @include $filepath;
    }

    /**
     * Gets the value of backtrace.
     *
     * @return mixed
     */
    public function getBacktrace()
    {
        return $this->backtrace;
    }

    /**
     * Sets the value of backtrace.
     *
     * @param array $backtrace the backtrace
     *
     * @return self
     */
    public function setBacktrace(array $backtrace)
    {
        $this->backtrace = $backtrace;

        return $this;
    }

    /**
     * Gets the headline.
     *
     * @return mixed
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Sets the $headline.
     *
     * @param mixed $headline the headline
     *
     * @return self
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
  
        return $this;
    }

    /**
     * Gets the value of message.
     *
     * @return array
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the value of message.
     *
     * @param mixed $message the message
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Gets the value of fileCousingError.
     *
     * @return mixed
     */
    public function getFileCousingError()
    {
        return $this->fileCousingError;
    }

    /**
     * Sets the value of fileCousingError.
     *
     * @param mixed $fileCousingError the file cousing error
     *
     * @return self
     */
    public function setFileCousingError($fileCousingError)
    {
        $this->fileCousingError = $fileCousingError;

        return $this;
    }

    /**
     * Gets the value of errorLine.
     *
     * @return mixed
     */
    public function getErrorLine()
    {
        return $this->errorLine;
    }

    /**
     * Sets the value of errorLine.
     *
     * @param mixed $errorLine the error line
     *
     * @return self
     */
    public function setErrorLine($errorLine)
    {
        $this->errorLine = $errorLine;

        return $this;
    }
}
