<?php
  class clear_html{
    private $_tag;
    private $_tag_close;
    private $_attr;

    /**
     * clear all html tag, except some tag in $arr_tag_attr
     * @param string $str
     * @param array $arr_tag_attr
     * array(
     *   "img" => "src",
     *   "a"   => "href"
     * )
     */
    function clear_str_tag($str, $arr_tag_attr=array()){
      $this->arr_tag = array();
      $this->str = $str;
      if(empty($arr_tag_attr)){
        $arr_tag_attr = array(
          "img" => "src",
          "a" => "href"
        );
      }
      foreach($arr_tag_attr AS $tag=>$attr){
        $this->_tag = $tag;
        $this->_tag_close = '</'.$this->_tag.'>';
        $this->_attr = $attr;
        $this->arr_tag[$tag] = array();
        $this->clear_all_tag($this->str);
      }
      $this->str = $this->keep_html($this->str);
      return $this->str;
    }

    function clear_all_tag($str_source){
      $i = stripos($str_source, '<'.$this->_tag);
      if($i !== false){
        $str_tag = substr($str_source, $i);
        $j = stripos($str_tag, '>');
        $str_scop = substr($str_source, $i, $j+1);
        $src = $this->get_attr_url($str_scop, $this->_attr);
        $sum = count($this->arr_tag[$this->_tag]);
        $str_source = str_ireplace($str_scop, '{'.$this->_tag.':'.$sum.'}', $str_source);
        if(stripos($str_source, $this->_tag_close)){
          $str_source = str_ireplace($this->_tag_close, '{/'.$this->_tag.'}', $str_source);
        }
        $this->str = $str_source;
        $this->arr_tag[$this->_tag][] = $src;
        $this->clear_all_tag($str_source);
      }
    }
    function get_attr_url($str, $attr){
      preg_match_all("/$attr(\s)*=[\"|'|\s]*(.*?)[\"|'|\s]/is", $str, $arr);
      $url = trim($arr[2][0]);
      if($url == ''){
        preg_match_all("/$attr(\s)*=(.*?) /is", $str, $arr);
        $url = trim($arr[2][0]);
      }
      return $url;
    }
    function keep_html($str){
      $str = trim($str);
      $search = array (
                  "'<script[^>]*?>.*?</script>'si",
                  "'<[\/\!]*?[^<>]*?>'si",
      						"/\t/",
      						"/(&nbsp;)*[\n|\r]/s",
                  "/(\n){2,}/si",
                );
      $replace = array (
      						"",
      						"",
      						"",
      						"\n",
                  "\n",
                );
      $text = preg_replace($search, $replace, $str);
      $text = trim($text);

      $text = str_replace("\n", "</p>\n<p>", $text);
      $text = $text ? "<p>".$text.'</p>' : '';

      return $text;
    }
  }
?>