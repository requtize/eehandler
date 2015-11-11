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

use EEHandler\EEHandler\Renderer;
use EEHandler\EEHandler\FileSourceRetriever;
use EEHandler\EEHandler\Exception\ErrorException;

class EEHandler
{
    const VERSION = '0.1.0-alpha';

    public function __construct($environment = 'dev')
    {
        if($environment === 'dev')
        {
            error_reporting(-1);
            ini_set('display_errors', 'Off');
        }
        else
        {
            error_reporting(0);
            ini_set('display_errors', 'Off');
        }

        define('EEHANDLER_ENV', $environment);
        define('EEHANDLER_VERSION', self::VERSION);
    }

    public function register()
    {
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutdown']);
    }

    public function handleShutdown()
    {
        $lastError = error_get_last();

        if($lastError)
        {
            $this->handleError($lastError['type'], $lastError['message'], $lastError['file'], $lastError['line']);

            return false;
        }
    }

    public function handleError($errno, $errstr, $errfile, $errline)
    {
        $exception = new ErrorException($errstr, $errno, $errno, $errfile, $errline);
        $this->handleException($exception);

        return false;
    }

    public function handleException($exception)
    {
        $this->turnOffOutputBuffering();

        $sourceTrace = $exception->getTrace();

        if(isset($sourceTrace[0]['file']) && isset($sourceTrace[0]['line']) && $sourceTrace[0]['file'] != $exception->getFile() && $sourceTrace[0]['line'] != $exception->getLine())
        {
            array_unshift($sourceTrace, [
                'file' => $exception->getFile(),
                'line' => $exception->getLine()
            ]);
        }

        $preparedTrace = $this->createBacktraceData($sourceTrace);

        $renderer = new Renderer();
        $renderer->setBacktrace($preparedTrace);
        $renderer->setHeadline(get_class($exception));
        $renderer->setMessage($exception->getMessage());
        $renderer->setFileCousingError($exception->getFile());
        $renderer->setErrorLine($exception->getLine());
        $renderer->render();

        exit();
        return false;
    }

    /**
     * Turns of Output Buffering, if is turned on.
     * @return void
     */
    public function turnOffOutputBuffering()
    {
        if(ob_get_level())
        {
            ob_end_clean();
        }
    }

    public function createBacktraceData(array $backtrace)
    {
        foreach($backtrace as $key => $val)
        {
            if(isset($val['file']) && isset($val['line']) && is_file($val['file']))
            {
                $fsr = new FileSourceRetriever($val['file']);

                $backtrace[$key]['source'] = $fsr->getSourceAroundLine($val['line']);
                $backtrace[$key]['source-first-line'] = $fsr->getCalculatedFirstLine();
            }
            else
            {
                $backtrace[$key]['source'] = [];
                $backtrace[$key]['source-first-line'] = 0;
            }

            if(isset($val['file']) && is_file($val['file']))
            {
                $backtrace[$key]['file-extension'] = pathinfo($val['file'], PATHINFO_EXTENSION);
                $backtrace[$key]['file-name'] = pathinfo($val['file'], PATHINFO_FILENAME);
            }
            else
            {
                $backtrace[$key]['file-extension'] = '';
                $backtrace[$key]['file-name'] = 'unknown';
            }

            if(! isset($val['line']))
            {
                $backtrace[$key]['line'] = 'unknown';
            }

            if(! isset($val['file']))
            {
                if(isset($val['class']) && isset($val['function']))
                {
                    $backtrace[$key]['file'] = $val['class'].$val['type'].$val['function'].'()';
                    $backtrace[$key]['file-name'] = $val['class'];
                }
                else
                {
                    $backtrace[$key]['file'] = 'unknown';
                }
            }
        }

        return array_values($backtrace);
    }
}
