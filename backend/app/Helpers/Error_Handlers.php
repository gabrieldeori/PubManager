<?php
    namespace App\Helpers;

    class Error_Handlers
    {
        public static function logError($e, $title)
        {
            $log_file = fopen(storage_path("logs/api.log"), "a");
            // get time
            $date = date('Y-m-d H:i:s');
            fwrite(
                $log_file,
                '# '. $date. ' ' .  $title . '\n'
                . '```php\n'
                . $e . '\n'
                . '```\n\n'
            );
            fclose($log_file);
        }
    }
?>
