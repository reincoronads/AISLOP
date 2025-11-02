<?php
  $page_title = 'Medicine Inventory';
  require_once('../../includes/load.php');
?>
<?php
// Checkin What level user has permission to view this page
 page_require_level(1);
//pull out all inventory items from database
 $all_medicines = find_all('products'); // You might need to adjust this function
?>
<?php include_once('../../layouts/header.php'); ?>

<!-- Page Content -->
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <strong class="card-title">
          <i class="fas fa-pills me-2"></i>
          Medicine Inventory
        </strong>
        <a href="add_item.php" class="btn btn-success">
          <i class="fas fa-plus-circle me-1"></i>Add New Medicine
        </a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Medicine Name</th>
                <th class="text-center">Category</th>
                <th class="text-center" style="width: 100px;">Quantity</th>
                <th class="text-center" style="width: 120px;">Expiry Date</th>
                <th class="text-center" style="width: 100px;">Status</th>
                <th class="text-center" style="width: 120px;">Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($all_medicines as $medicine): ?>
              <?php
              // Determine status based on quantity and expiry
              $current_date = date('Y-m-d');
              $expiry_date = $medicine['expiry_date'];
              $quantity = $medicine['quantity'];
              
              $status = 'good';
              $status_text = 'In Stock';
              $status_class = 'bg-success';
              
              if ($quantity <= 10) {
                $status = 'low';
                $status_text = 'Low Stock';
                $status_class = 'bg-warning';
              }
              
              if ($quantity == 0) {
                $status = 'out';
                $status_text = 'Out of Stock';
                $status_class = 'bg-danger';
              }
              
              if ($expiry_date && strtotime($expiry_date) <= strtotime('+30 days')) {
                $status = 'expiring';
                $status_text = 'Expiring Soon';
                $status_class = 'bg-warning text-dark';
              }
              
              if ($expiry_date && strtotime($expiry_date) < strtotime($current_date)) {
                $status = 'expired';
                $status_text = 'Expired';
                $status_class = 'bg-danger';
              }
              ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <strong><?php echo remove_junk(ucwords($medicine['name']))?></strong>
                  <?php if(!empty($medicine['brand'])): ?>
                    <br><small class="text-muted"><?php echo remove_junk($medicine['brand'])?></small>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <span class="badge bg-info"><?php echo remove_junk(ucwords($medicine['categorie_id'] ?? 'General'))?></span>
                </td>
                <td class="text-center">
                  <span class="fw-bold <?php echo $quantity <= 10 ? 'text-warning' : ''; ?>">
                    <?php echo (int)$medicine['quantity']?>
                  </span>
                  <small class="text-muted"><?php echo $medicine['unit'] ?? 'pcs'?></small>
                </td>
                <td class="text-center">
                  <?php if($medicine['expiry_date']): ?>
                    <span class="<?php echo strtotime($medicine['expiry_date']) < strtotime('+30 days') ? 'text-warning fw-bold' : ''; ?>">
                      <?php echo read_date($medicine['expiry_date'])?>
                    </span>
                  <?php else: ?>
                    <span class="text-muted">N/A</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                </td>
                <td class="text-center">
                  <div class="btn-group" role="group">
                    <a href="/BIHIS/modules/inventory/edit_item.php?id=<?php echo (int)$medicine['id'];?>" 
                      class="btn btn-sm btn-warning" 
                      data-bs-toggle="tooltip" 
                      title="Edit Medicine">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="/BIHIS/modules/inventory/delete_item.php?id=<?php echo (int)$medicine['id'];?>" 
                      class="btn btn-sm btn-danger" 
                      data-bs-toggle="tooltip" 
                      title="Delete Medicine"
                      onclick="return confirm('Are you sure you want to delete this medicine?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('../../layouts/footer.php'); ?>