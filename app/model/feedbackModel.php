<?php
class feedbackModel extends model{
  function getFeedbackList(){
    $this->get_items_op($this->t_feedbacks);

    $pl = new pagelist($this->db);
    $arr = $pl->get_rows($this->t_feedbacks, $this->where, $this->by, $this->order);
    return $arr;
  }

  function getFeedbackById($id){
    return $this->db->row_select_one($this->t_feedbacks, 'id='.$id);
  }
  function updateFeedbackById($row, $id){
    return $this->db->row_update($this->t_feedbacks, $row, 'id='.$id);
  }
  function insertFeedback($row){
    return $this->db->row_insert($this->t_feedbacks, $row);
  }
  function deleteFeedbackById($id){
    return $this->db->row_delete($this->t_feedbacks, 'id='.$id);
  }
}
?>
