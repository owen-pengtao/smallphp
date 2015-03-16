<?php
class curl {
  var $headers;
  var $user_agent;
  var $compression;
  var $cookie_file;
  var $proxy;
  function curl($cookies = TRUE, $cookie = 'cookies.txt', $compression = 'gzip', $proxy = '') {
    $this->headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
    $this->headers[] = 'Connection: Keep-Alive';
    $this->headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
    $this->user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
    $this->compression = $compression;
    $this->proxy = $proxy;
    $this->cookies = $cookies;
    if ($this->cookies == TRUE)
      $this->cookie($cookie);
  }
  function cookie($cookie_file) {
    if (file_exists($cookie_file)) {
      $this->cookie_file = $cookie_file;
    } else {
      $h = fopen($cookie_file, 'w') or $this->error('The cookie file could not be opened. Make sure this directory has the correct permissions');
      $this->cookie_file = $cookie_file;
      fclose($h);
    }
  }
  function get($url) {
    ob_start();
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_file);
    curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, FALSE);
    curl_exec($ch);
    curl_close($ch);

    $return = ob_get_clean();
    return $return;
  }
  function post($url, $data) {
    ob_start();
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_file);
    curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, FALSE);


    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    
    curl_exec($ch);
    curl_close($ch);

    $return = ob_get_clean();
    return $return;
  }
  function error($error) {
    echo "<center><div style='width:500px;border: 3px solid #FFEEFF; padding: 3px; background-color: #FFDDFF;font-family: verdana; font-size: 10px'><b>cURL Error</b><br>$error</div></center>";
    die;
  }
}
?>