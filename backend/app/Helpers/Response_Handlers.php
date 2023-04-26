<?php
    namespace App\Helpers;

    class Response_Handlers
    {
        private static string $message = "";
        private static array $payload = [];

        private static function response()
        {
            return ([
                "message"=>self::$message,
                "payload"=>self::$payload,
            ]);
        }

        public static function setAndRespond($message, $payload=[])
        {
            self::$message = $message;
            self::$payload = $payload;
            return self::response();
        }
    }
?>
