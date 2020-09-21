<?php
/**
  * @project: PHP Video Downloader Class
  *
  * @purpose: This class automatically generates download links for HD and SD quality.
  * @version: 1.0
  *
  *
  * @author: Mohamed Riyad
  * @created on: 21 Sep, 2020
  *
  * @url: http://ryadpasha.com
  * @email: m@ryad.com
  * @license: MIT License
  *
  * @see: https://github.com/ryadpasha/fbdown
  */

class FBDown {
  private static $link2DL;

  public function __construct($link2DL = null) {
    self::setLink($link2DL);
  }

  public static function DL($link2DL = null) {
    self::setLink($link2DL);
    $response = [];

    try {
        if (empty(self::$link2DL))
          throw new Exception('Please provide the URL', 1);

        $context = [
          'http' => [
            'method' => 'GET',
            'header' => 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.47 Safari/537.36',
          ],
          'ssl' => [
            'allow_self_signed' => true,
            'verify_peer'       => false,
            'verify_peer_name'  => false
          ]
        ];
        $context  = stream_context_create($context);
        $data     = file_get_contents(self::$link2DL, false, $context);
        $title    = self::getTitle($data);

        if(strpos($data, 'captcha') !== false)
          throw new Exception('Captcha required', 2);

        if (strtolower($title) === 'sorry, this content isn\'t available at the moment'
        ||  count(explode(' ', $title)) === 1)
          throw new Exception('Video isn\'t available!', 3);

        $response['success'] = true;

        $response['id']    = self::generateId(self::$link2DL);
        $response['title'] = $title;
        $response['desc']  = trim(self::getDescription($data));

        if ($sdLink = self::getSDLink($data))
          $response['links']['low_quality'] = $sdLink;

        if ($hdLink = self::getHDLink($data))
          $response['links']['high_quality'] = $hdLink;

    } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = $e->getMessage();
    }
    return $response;
  }

  private static function setLink($url) {
    $url = str_replace('m.facebook.com', 'www.facebook.com', $url);
    if (!preg_match("~^(?:f|ht)tps?://~i", $url))
      $url = "https://" . $url;

    if(!empty($url))
      self::$link2DL = $url;
  }

  private static function generateId($url) {
      $id = '';
      parse_str(parse_url($url, PHP_URL_QUERY), $params);
      if (@number_format($url))
          $id = $url;
      elseif (@number_format($params['story_fbid']))
        $id = $params['story_fbid'];
      elseif (@number_format($params['v']))
        $id = $params['v'];
      elseif (preg_match('#(\d+)/?$#', preg_replace('/\?.*/','',$url), $matches))
        $id = $matches[1];

      return $id;
  }

  private static function cleanStr($str, $keep_newlines = false) {
    if ($keep_newlines) {
      $str = str_ireplace(array('<p>', '</p>'), array('', '<br>'), $str);  // Replace paragraphs with <br />
      $str = str_ireplace(array('<br />', '<br>', '<br/>'), "\r\n", $str); // Replace <br /> with newline
    }
    return html_entity_decode(strip_tags($str), ENT_QUOTES, 'UTF-8');
  }

  private static function getSDLink($curl_content) {
    $regexRateLimit = '/sd_src_no_ratelimit:"([^"]+)"/';
    $regexSrc = '/sd_src:"([^"]+)"/';

    if (preg_match($regexRateLimit, $curl_content, $match))
      return $match[1];
    elseif (preg_match($regexSrc, $curl_content, $match))
      return $match[1];
    else
      return false;
  }

  private static function getHDLink($curl_content) {
      $regexRateLimit = '/hd_src_no_ratelimit:"([^"]+)"/';
      $regexSrc = '/hd_src:"([^"]+)"/';

      if (preg_match($regexRateLimit, $curl_content, $match))
        return $match[1];
      elseif (preg_match($regexSrc, $curl_content, $match))
        return $match[1];
      else
        return false;
  }

  private static function getTitle($curl_content) {
      $title = null;
      if (preg_match('/h2 class="uiHeaderTitle"?[^>]+>(.+?)<\/h2>/', $curl_content, $matches))
        $title = $matches[1];
      elseif (preg_match('/title id="pageTitle">(.+?)<\/title>/', $curl_content, $matches))
        $title = $matches[1];

      return trim(self::cleanStr(str_replace('| Facebook', null, $title)));
  }

  private static function getDescription($curl_content) {
    if (preg_match('/div data-testid="post_message"?[^>]*>(.+?)<\/div>/', $curl_content, $matches))
      return self::cleanStr($matches[1], true);

    elseif (preg_match('/span class="hasCaption">(.+?)<\/span>/', $curl_content, $matches))
      return self::cleanStr($matches[1], true);

    elseif (preg_match('/div class="_44bj _5wj-"?[^>]*>(.+?)<\/div>/', $curl_content, $matches))
      return self::cleanStr($matches[1], true);

    return false;
  }
}
