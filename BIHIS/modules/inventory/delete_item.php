<?php
  require_once('../../includes/load.php');
  page_require_level(1);
?>
<?php
  $delete_id = delete_by_id('products',(int)$_GET['id']);
  if($delete_id){
      $session->msg("s","Medicine deleted successfully.");
      redirect('/BIHIS/modules/inventory/inventory.php');
  } else {
      $session->msg("d","Medicine deletion failed or missing parameter.");
      redirect('/BIHIS/modules/inventory/inventory.php');
  }
?>