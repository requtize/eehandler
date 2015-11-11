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

class FileSourceRetriever
{
    protected $lines = [];
    protected $linesArroundMax = 8;
    protected $calculatedFirstLine = 0;

    public function __construct($filepath)
    {
        $this->lines = file($filepath, FILE_IGNORE_NEW_LINES);
    }

    public function getSourceAroundLine($line, $asLines = true)
    {
        $lines = [];

        $limitUp = $line - $this->linesArroundMax;
        $limitUp = $limitUp <= 0 ? 0 : $limitUp;

        $limitDown = $line + $this->linesArroundMax;
        $limitDown = $limitDown >= count($this->lines) ? count($this->lines) - 1 : $limitDown;

        /**
         * If in first line is a multiline comment, we must decrease limitUp number until
         * we find comment start.
         */
        while(isset($this->lines[$limitUp]) && $this->hasComment($this->lines[$limitUp]))
        {
            $limitUp--;
        }

        /**
         * The same thing we do with limitDown value.
         */
        while(isset($this->lines[$limitDown]) && $this->hasComment($this->lines[$limitDown]))
        {
            $limitDown++;
        }

        for($i = $limitUp; $i <= $limitDown; $i++)
        {
            $lines[] = $this->lines[$i];
        }

        $this->calculatedFirstLine = $limitUp + 1;

        $lines = $this->prepareLines($lines);

        return $asLines ? $lines : implode("\n", $lines);
    }

    private function prepareLines(array $lines)
    {
        foreach($lines as $i => $line)
        {
            $lines[$i] = str_replace(['<', '>', '"'], ['&lt;', '&gt;', '&quot;'], $line);

            $lines[$i] = trim($lines[$i]) == '' ? '&nbsp;' : $lines[$i];
        }

        return $lines;
    }

    private function hasComment($line)
    {
        // Remove whitespaces from begin.
        $line = trim($line);

        if(substr($line, 0, 1) === '*')
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getCalculatedFirstLine()
    {
        return $this->calculatedFirstLine;
    }
}
