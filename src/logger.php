<?php 

class Logger {

    private CONST LOG_PATH = "/path/to/logs/";

    private static $template = "{date} {level} {message} {context}";
    private static $dateFormat = \DateTime::RFC2822;

    private static function getDate()
    {
        return (new \DateTime())->format(self::$dateFormat);
    }

    private static function contextStringify($context)
    {
        //$context = (array)($context);
        $context = print_r($context, 1);
        return $context;
        //return !empty($context) ? json_encode($context, JSON_PRETTY_PRINT) : null;
    }

    /**
     * log
     *
     * @param  mixed $level для удобства уровни можно классифицировать на категории - info, error, critical, debug
     * @param  mixed $message описание логируемого события
     * @param  mixed $context данные лога
     *
     * @return void
     */
    public static function log($level, $message, $context)
    {
        file_put_contents(self::LOG_PATH.date("d-m-y")."log.txt", trim(strtr(self::$template, [
            '{date}' => self::getDate(),
            '{level}' => $level,
            '{message}' => $message,
            '{context}' => self::contextStringify($context),
        ])) . PHP_EOL, FILE_APPEND);
    }

}
