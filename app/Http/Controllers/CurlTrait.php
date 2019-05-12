<?php

namespace App\Http\Controllers;

trait CurlTrait {
  private static $TIMEOUT_SECONDS = 30;

  protected function curlCallGet($url, $option = []) {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$TIMEOUT_SECONDS);
      curl_setopt($ch, CURLOPT_TIMEOUT, self::$TIMEOUT_SECONDS);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      if (!empty($option['CURLOPT_USERPWD'])) {
        curl_setopt($ch, CURLOPT_USERPWD, $option['CURLOPT_USERPWD']);
      }
        
      if (isset($option['header'])) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $option['header']);
      }
      curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cacert.pem');
      $res = curl_exec($ch);

      if (isset($option['log']) && $option['log']) {
        if ($res === false) {
          $res = [
            'error' => true,
            'message' => curl_error($ch)
          ];
          return json_encode($res);
        }
      }
      //var_dump(curl_error($ch));
      //var_dump($res);exit;
      return $res;
  }

  protected function curlGetHeaders($url, $option = []) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$TIMEOUT_SECONDS);
    curl_setopt($ch, CURLOPT_TIMEOUT, self::$TIMEOUT_SECONDS);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    if (!empty($option['CURLOPT_USERPWD'])) {
      curl_setopt($ch, CURLOPT_USERPWD, $option['CURLOPT_USERPWD']);
    }
    if (isset($option['header'])) {
      curl_setopt($ch, CURLOPT_HTTPHEADER, $option['header']);
    }
    curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cacert.pem');
    $response = curl_exec($ch);
    
    if (isset($option['log']) && $option['log']) {
      if ($response === false) {
        $response = [
          'error' => true,
          'message' => curl_error($ch)
        ];
        return json_encode($response);
      }
    }

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $header_size);
    $headers = explode("\n", $headers);

    return $headers;
  }

  protected function curlCallPost($url, $param, $option = []) {
      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      if (isset($option['method'])) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $option['method']);
      } else {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      }
      curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$TIMEOUT_SECONDS);
      curl_setopt($ch, CURLOPT_TIMEOUT, self::$TIMEOUT_SECONDS);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

      if (isset($option['header'])) {
        if (is_array($option['header'])) {
          curl_setopt($ch, CURLOPT_HTTPHEADER, $option['header']);
        }
      } else {
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Content-type: application/json'
          ));
      }
      
      if (!empty($option['CURLOPT_USERPWD'])) {
        curl_setopt($ch, CURLOPT_USERPWD, $option['CURLOPT_USERPWD']);
      }

      curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cacert.pem');

      $res = curl_exec($ch);
      
      if (isset($option['log']) && $option['log']) {
        if ($res === false) {
          $res = [
            'error' => true,
            'message' => curl_error($ch)
          ];
          $res = json_encode($res);
        }
      }

      if (isset($option['json']) && $option['json']) {
        $res = json_decode($res, true);
        if (is_null($res) && isset($option['header'])) {
          $res = ['error' => true, 'header' => $option['header']];
        }
      }

      return $res;
  }

  protected function curlPostWithUserPwd($url, $username, $password, $param) {
  }

  protected function curlSaveImage($url, $saveto) {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
      $raw = curl_exec($ch);
      curl_close ($ch);
      if (!$raw) {
        return ;
      }
      if (file_exists($saveto)) {
          unlink($saveto);
      }
      $fp = fopen($saveto,'x');
      fwrite($fp, $raw);
      fclose($fp);
  }

  protected function curlCallXML($url, $input_xml) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
// Following line is compulsary to add as it is:
    curl_setopt($ch, CURLOPT_POSTFIELDS,
                "xmlRequest=" . $input_xml);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}
}