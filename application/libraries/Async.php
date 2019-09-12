<?php

class Async
{
    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function execute($url, $params) {
        // Create HTTP query string data
        $postData = http_build_query($params);

        // Dissect the URL to an assoc array
        $parts = parse_url($url);

        // Vars required for fsock error handling
        $errno = 0;
        $errstr = "";

        // Open a new socket
        $socket = fsockopen('' . $parts['host'], '80', $errno, $errstr, 30);

        // If init fails, return
        if (!$socket) {
            return false;
        }

        // Else, we construct the headers
        $out = "POST ".$parts['path']." HTTP/1.1\r\n";
        $out.= "Host: ".$parts['host']."\r\n";
        $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out.= "Content-Length: ".strlen($postData)."\r\n";
        $out.= "Connection: Close\r\n\r\n";

        // Construct the body
        if (isset($postData)) $out.= $postData;

        // Write to the socket
        fwrite($socket, $out);

        // Close the socket without waiting for response making call asynchronous
        fclose($socket);

        // Yayy! Success
        return true;
    }
}
