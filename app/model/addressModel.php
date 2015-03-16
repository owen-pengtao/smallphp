<?php
class addressModel extends model{
  function getAddressList(){
    $this->get_items_op($this->t_address);

    $pl = new pagelist($this->db);
    $arr = $pl->get_rows($this->t_address, $this->where, $this->by, $this->order);
    return $arr;
  }
  function getAddressById($id){
    return $this->db->row_select_one($this->t_address, 'id='.$id);
  }
  function updateAddressById($row, $id){
    return $this->db->row_update($this->t_address, $row, 'id='.$id);
  }
  function insertAddress($row){
    return $this->db->row_insert($this->t_address, $row);
  }
  function insertModifyAddress($row){
    return $this->db->row_insert($this->t_address_modify, $row);
  }
  function deleteAddressById($id){
    return $this->db->row_delete($this->t_address, 'id='.$id);
  }


  function getMyAddressList($uid){
    $pl = new pagelist($this->db);
    $where = 'uid='.$uid;

    $arr = $pl->get_rows($this->t_address, $where);
    unset($arr['page']);
    return $arr;
  }
  function markItHelp($id){
    $sql = 'UPDATE '.$this->t_address.' SET help_sum=help_sum+1 WHERE id='.$id;
    return $this->db->query($sql);
  }
  function markItWrong($id){
    $sql = 'UPDATE '.$this->t_address.' SET wrong_sum=wrong_sum+1 WHERE id='.$id;
    return $this->db->query($sql);
  }

  function getAreaAddress($search_name, $search_type, $arr_lng, $arr_lat, $crt_point, $s){
    $min_lng = $arr_lng[0];
    $max_lng = $arr_lng[1];
    $min_lat = $arr_lat[0];
    $max_lat = $arr_lat[1];
    $crt_lng = $crt_point[0];
    $crt_lat = $crt_point[1];

    $sql = 'SELECT count(id) AS sum, ';
    $sql.= '('.$this->_get_dist($crt_lng, $crt_lat).') AS distance FROM '.$this->t_address;
    $sql.= ' WHERE ';
    $sql.= $search_type ? 'search_type="'.$search_type.'" AND ' : '';
    $sql.= $search_name ? '(title LIKE "%'.$search_name.'%" OR address LIKE "%'.$search_name.'%")  AND ' : '';
    $sql.= '(x>='.$min_lng.' AND x<='.$max_lng.')';
    $sql.= ' AND (y>='.$min_lat.' AND y<='.$max_lat.')';
    $sql.= ' HAVING distance <= '.$s;
    $row = $this->db->row_query_one($sql);
    $sum = $row['sum'];

    $sql = 'SELECT *, ';
    $sql.= '('.$this->_get_dist($crt_lng, $crt_lat).') AS distance FROM '.$this->t_address;
    $sql.= ' WHERE ';
    $sql.= $search_type ? 'search_type="'.$search_type.'" AND ' : '';
    $sql.= $search_name ? '(title LIKE "%'.$search_name.'%" OR address LIKE "%'.$search_name.'%")  AND ' : '';
    $sql.= '(x>='.$min_lng.' AND x<='.$max_lng.')';
    $sql.= ' AND (y>='.$min_lat.' AND y<='.$max_lat.')';
    $sql.= ' HAVING distance <= '.$s.' ORDER BY distance ASC, id DESC';
    $pl = new pagelist($this->db);
    $arr = $pl->get_rows_sql($sql, $sum);
    unset($arr['page']);

    return $arr;
  }
  function _get_dist($crt_lng, $crt_lat){
    $a = 'pow(sin(RADIANS(y - '.$crt_lat.') / 2), 2) +
         cos(RADIANS('.$crt_lat.')) * cos(RADIANS(y)) *
         pow(sin(RADIANS(x - '.$crt_lng.') / 2), 2)';

    return  R.' * 2 * atan2(sqrt('.$a.'), sqrt(1 - '.$a.'))';
  }
}
?>
