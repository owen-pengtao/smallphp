<?php
class formB{
  private $arrRequire = array();
  private $arrColumn  = array();
  private $arrHtml    = array();
  private $arrFields  = array();
  private $strForm    = "";

  function setForm($action, $method="post", $class="form-horizontal", $other="") {
    $this->strForm = "<form class='$class' action='$action' method='$method' enctype='multipart/form-data' $other>";
  }
  function setColumn($arr){
    if ($arr) {
      $this->arrColumn  = array(
        "col-sm-".$arr[0],
        "col-sm-".$arr[1]
      );
    }
  }
  function setRequireList($arr){
    $this->arrRequire = $arr;
  }
  function addHtmlFor($name, $html, $position=""){
    $this->arrHtml[$name] = $html;
  }
  function addInput($type, $name, $value="", $label="", $other=""){
    $isRequired = in_array($name, $this->arrRequire);
    $str = "<div class='form-group'>";
    if ($label) {
      $str.= "  <label class='control-label ".($this->arrColumn[0] ? $this->arrColumn[0] : "")."'>$label ".($isRequired ? "<sup class='text-danger'>*</sup>" : "")."</label>";
    }
    $str.= $this->arrColumn[1] ? "  <div class='".$this->arrColumn[1]."'>" : "";
    $str.= "    <input type='$type' name='$name' value='$value'".($isRequired ? " required='required'" : "")." class='form-control' $other>";
    $str.= $this->arrHtml[$name];
    $str.= $this->arrColumn[1] ? "  </div>" : "";
    $str.= "</div>";
    $this->arrFields[] = $str."\n";
    return $str;
  }
  function addHidden($name, $value=""){
    $str = "<input type='hidden' name='$name' value='$value'>";
    $this->arrFields[] = $str."\n";
    return $str;
  }
  function addStaticHtml($value="", $label=""){
    $str = "<div class='form-group'>";
    $str.= "  <label class='control-label ".($this->arrColumn[0] ? $this->arrColumn[0] : "")."'>$label</label>";
    $str.= $this->arrColumn[1] ? "  <div class='".$this->arrColumn[1]."'>" : "";
    $str.= "    <p class='form-control-static'>$value</p>";
    $str.= $this->arrColumn[1] ? "  </div>" : "";
    $str.= "</div>";
    $this->arrFields[] = $str."\n";
    return $str;
  }

  function addTextarea(){

  }

  function addSelect($name, $value, $label, $arr, $multiple="0", $other=""){
    $isRequired = in_array($name, $this->arrRequire);
    $str = "<div class='form-group'>";
    $str .= "  <label class='control-label " . ($this->arrColumn[0] ? $this->arrColumn[0] : "") . "'>$label " . ($isRequired ? "<sup class='text-danger'>*</sup>" : "") . "</label>";
    $str .= $this->arrColumn[1] ? "  <div class='" . $this->arrColumn[1] . "'>" : "";
    $str .= "<select name='$name' class='form-control'".($multiple ? 'multiple' : "")." $other>";
    foreach ($arr as $k=>$v) {
      $str .= "<option".($value === $k ? ' selected="selected"' : '')." value='$k'>".$v."</option>";
    }
    $str .= "</select>";
    $str.= $this->arrHtml[$name];
    $str.= $this->arrColumn[1] ? "  </div>" : "";
    $str.= "</div>";
    $this->arrFields[] = $str."\n";
    return $str;
  }
  /*
   * $arr = array(
   *    array(0, "No")
   *    array(1, "Yes")
   * )
   */
  function addRadio($name, $value, $label, $arr, $direction="h", $other=""){
    $type = "radio";
    return $this->_radioCheckbox($type, $name, $value, $label, $arr, $direction, $other);
  }
  function addCheckbox($name, $value, $label, $arr, $direction="h", $other=""){
    $type = "checkbox";
    return $this->_radioCheckbox($type, $name, $value, $label, $arr, $direction, $other);
  }
  function _radioCheckbox($type, $name, $value, $label, $arr, $direction="h", $other=""){
    $isRequired = in_array($name, $this->arrRequire);
    $str = "<div class='form-group'>";
    $str .= "  <label class='control-label " . ($this->arrColumn[0] ? $this->arrColumn[0] : "") . "'>$label " . ($isRequired ? "<sup class='text-danger'>*</sup>" : "") . "</label>";
    $str .= $this->arrColumn[1] ? "  <div class='" . $this->arrColumn[1] . "'>" : "";
    foreach ($arr as $k=>$v) {
      $str .= $direction == "v" ? "<div class='$type'>" : "";
      $str .= "<label" . ($direction == "v" ? "" : " class='$type-inline'") . ">";
      $str .= "<input type='$type' name='$name' value='$k'" . ($value === $k ? ' checked="checked"' : '') . " $other>" . $v;
      $str .= "</label>";
      $str .= $direction == "v" ? "</div>" : "";
    }
    $str.= $this->arrHtml[$name];
    $str.= $this->arrColumn[1] ? "  </div>" : "";
    $str.= "</div>";
    $this->arrFields[] = $str."\n";
    return $str;
  }
  function addBtn($type, $value, $other=""){
    $arr = array($type, $value, $other);
    return $this->addGroupBtn(array($arr));
  }
  function addGroupBtn($arr){
    $str = "<div class='form-group'>";
    $str.= $this->arrColumn[1] ? "  <div class='col-sm-offset-2 ".$this->arrColumn[1]."'>" : "";
    foreach ($arr as $v) {
      $str.= "    <input type='".$v[0]."' value='".$v[1]."' ".$v[2]."/>";
    }
    $str.= $this->arrColumn[1] ? "  </div>" : "";
    $str.= "</div>";
    $this->arrFields[] = $str."\n";
    return $str;
  }
  function addSingleInput($type, $value, $other=""){
    $str = "<input type='".$type."' value='".$value."' ".$other."/>";
    $this->arrFields[] = $str."\n";
    return $str;
  }
  function render(){
    echo join($this->arrFields, "\n");
  }
}
?>