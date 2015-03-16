<?php
class categoryModel extends model{
  function __construct(){
    parent::__construct();
    $this->t_category_table = $this->t_address_categories;
  }
  function setCategoryTable($category_table){
    $this->t_category_table = $category_table;
  }
  function getAllCategory() {
    $sql = "SELECT * FROM `".$this->t_category_table."` ORDER BY ranking ASC ,id ASC";
    return $this->db->row_query($sql);
  }
  function getRootCategory() {
    $sql = "SELECT * FROM `".$this->t_category_table."` WHERE pid=0 ORDER BY ranking ASC ,id ASC";
    return $this->db->row_query($sql);
  }
  function getChildCategory($pid) {
    $sql = "SELECT * FROM `".$this->t_category_table."` WHERE pid=".$pid." ORDER BY ranking ASC ,id ASC";
    return $this->db->row_query($sql);
  }
  function getCategoryById($id){
    return $this->db->row_select_one($this->t_category_table, 'id='.$id);
  }
  function updateCategoryById($row, $id){
    return $this->db->row_update($this->t_category_table, $row, 'id='.$id);
  }
  function insertCategory($row){
    return $this->db->row_insert($this->t_category_table, $row);
  }
  function deleteCategoryById($id){
    $row = array(
      'status' => 0
    );
    return $this->db->row_update($this->t_category_table, $row, 'id='.$id);
  }
}
?>
