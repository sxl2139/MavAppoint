<?php

if (!function_exists('config')) {
    /**
     * Gets the values in config file
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    function config($key, $default = null)
    {
        if (isset(Application::$container["config"])) {
            $config = Application::$container["config"];
            $keys = explode(".", $key);
            foreach ($keys as $key) {
                if (!isset($config[$key])) {
                    return $default;
                }
                $config = $config[$key];
            }
            return $config;
        }

        return $default;
    }
}

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return;
        }

        if (startsWith($value, '"') && endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('startsWith')) {
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string $haystack
     * @param  string|array $needles
     * @return bool
     */
    function startsWith($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle != '' && mb_strpos($haystack, $needle) === 0) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('endsWith')) {
    /**
     * Determine if a given string ends with a given substring.
     *
     * @param  string $haystack
     * @param  string|array $needles
     * @return bool
     */
    function endsWith($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ((string)$needle === mb_substr($haystack, mb_strlen($needle), null, 'UTF-8')) {
                return true;
            }
        }

        return false;
    }
}

if( !function_exists('mav_encrypt')) {
    /**
     * encrypt data
     *
     * @param $data
     * @return string
     */
    function mav_encrypt($data){
        return my_simple_crypt($data, "e");
    }
}

if( !function_exists('mav_decrypt')) {
    /**
     * decrypt data
     *
     * @param $encrypted
     * @return string
     */
    function mav_decrypt($encrypted){
        return my_simple_crypt($encrypted, "d");
    }
}

function my_simple_crypt( $string, $action = 'e' ) {
    // you may change these values to your own
//    $secret_key = 'my_simple_secret_key';
//    $secret_iv = 'my_simple_secret_iv';

    $output = false;
//    $encrypt_method = "AES-256-CBC";
//    $key = hash( 'sha256', $secret_key );
//    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

    if( $action == 'e' ) {
        $output = base64_encode($string);
    }
    else if( $action == 'd' ){
        $output = base64_decode($string);
    }

    return $output;
}

function mav_mail($subject, $content, $toArray) {
    include_once ROOT . "/lib/PHPMailerAutoload.php";
    $mail = new PHPMailer();

//    $mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';         // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    $mail->Username = config("emailUsername");                 // SMTP username
    $mail->Password = config("emailPassword");            // SMTP password
    $mail->CharSet = 'UTF-8';
    $mail->FromName= "CSESpring2017";
    $mail->Subject = $subject;
    $mail->Body =$content;
    $mail->isHTML(true);

    foreach ($toArray as $email){
        $mail->clearAllRecipients();
        $mail->addAddress($email);     // Add a recipient
        if(!$mail->send()) {
            return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    return "";
}

function convertMonth($month) {
    switch ($month) {
        case "Jan" : return "01";
        case "Feb" : return "02";
        case "Mar" : return "03";
        case "Apr" : return "04";
        case "May" : return "05";
        case "Jun" : return "06";
        case "Jul" : return "07";
        case "Aug" : return "08";
        case "Sep" : return "09";
        case "Oct" : return "10";
        case "Nov" : return "11";
        case "Dec" : return "12";
    }
    return null;
}

function generateRandomPassword() {
    $symbols = "0123456789abcdefghijklmnopqrstuvwxyz@#!_-";
    $length = 10;
    $password = "";
    for ($i = 0; $i < $length; $i++) {
        $password .= $symbols[mt_rand(0, 40)];
    }
    return $password;
}

function validateEmail($email) {
    return preg_match("#[\\w-_\\.+]*[\\w-_\\.]\\@([\\w]+\\.)+[\\w]+[\\w]#", $email);
}

function validatePhoneNumber($phoneNumber) {
    return preg_match("#\\d{3}-\\d{3}-\\d{4}#", $phoneNumber);
}

function validateStudentId($studentId) {
    return preg_match("#100\\d{7}#", $studentId) || preg_match("#6000\\d{6}#", $studentId);
}

function getUrlWithoutParameters() {
    $uri_parts = explode("?", $_SERVER['REQUEST_URI'], 2);
    return "http://" . $_SERVER['HTTP_HOST'] . $uri_parts[0];
}
