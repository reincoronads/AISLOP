<?php
  $page_title = 'Edit Medicine';
  require_once('../../includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  $e_product = find_by_id('products',(int)$_GET['id']);
  $categories = find_all('categories');
  
  if(!$e_product){
    $session->msg("d","Missing medicine id.");
    redirect('/BIHIS/modules/inventory/inventory.php');
  }
?>

<?php
//Update Medicine basic info
if(isset($_POST['update'])) {
    $req_fields = array('name','category','quantity','unit');
    validate_fields($req_fields);
    
    if(empty($errors)){
        $id = (int)$e_product['id'];
        $name = remove_junk($db->escape($_POST['name']));
        $brand = remove_junk($db->escape($_POST['brand']));
        $category = (int)$db->escape($_POST['category']);
        $quantity = (int)$db->escape($_POST['quantity']);
        $unit = remove_junk($db->escape($_POST['unit']));
        $batch_number = remove_junk($db->escape($_POST['batch_number']));
        $expiry_date = remove_junk($db->escape($_POST['expiry_date']));
        $supplier = remove_junk($db->escape($_POST['supplier']));
        $storage_location = remove_junk($db->escape($_POST['storage_location']));
        $low_stock_alert = (int)$db->escape($_POST['low_stock_alert']);
        $description = remove_junk($db->escape($_POST['description']));
        
        $sql = "UPDATE products SET 
                name ='{$name}', 
                brand ='{$brand}',
                categorie_id ='{$category}',
                quantity ='{$quantity}',
                unit ='{$unit}',
                batch_number ='{$batch_number}',
                expiry_date ='{$expiry_date}',
                supplier ='{$supplier}',
                storage_location ='{$storage_location}',
                low_stock_alert ='{$low_stock_alert}',
                description ='{$description}'
                WHERE id='{$db->escape($id)}'";
         
        $result = $db->query($sql);
        
        if($result && $db->affected_rows() === 1){
            $session->msg('s',"Medicine updated successfully");
            redirect('/BIHIS/modules/inventory/inventory.php', false);
        } else {
            $session->msg('d','Sorry, failed to update medicine!');
            redirect('/BIHIS/modules/inventory/edit_item.php?id='.(int)$e_product['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('/BIHIS/modules/inventory/edit_item.php?id='.(int)$e_product['id'],false);
    }
}
?>

<?php include_once('../../layouts/header.php'); ?>

<?php include_once('../../layouts/header.php'); ?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <strong>
          <i class="fas fa-edit"></i>
          Update <?php echo remove_junk(ucwords($e_product['name'])); ?>
        </strong>
      </div>
      <div class="card-body">
        <form method="post" action="/BIHIS/modules/inventory/edit_item.php?id=<?php echo (int)$e_product['id'];?>" class="clearfix">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label">Medicine Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" value="<?php echo remove_junk($e_product['name']); ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="brand" class="form-label">Brand/Manufacturer</label>
                <input type="text" class="form-control" name="brand" value="<?php echo remove_junk($e_product['brand'] ?? ''); ?>" placeholder="Optional">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                <select class="form-control" name="category" required>
                  <option value="">Select Category</option>
                  <?php foreach ($categories as $cat): ?>
                  <option value="<?php echo (int)$cat['id']; ?>" <?php echo ($e_product['categorie_id'] == $cat['id']) ? 'selected' : ''; ?>>
                    <?php echo remove_junk(ucwords($cat['name'])); ?>
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="quantity" value="<?php echo (int)$e_product['quantity']; ?>" min="0" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                <select class="form-control" name="unit" required>
                  <option value="">Select Unit</option>
                  <option value="tablets" <?php echo ($e_product['unit'] == 'tablets') ? 'selected' : ''; ?>>Tablets</option>
                  <option value="capsules" <?php echo ($e_product['unit'] == 'capsules') ? 'selected' : ''; ?>>Capsules</option>
                  <option value="bottles" <?php echo ($e_product['unit'] == 'bottles') ? 'selected' : ''; ?>>Bottles</option>
                  <option value="vials" <?php echo ($e_product['unit'] == 'vials') ? 'selected' : ''; ?>>Vials</option>
                  <option value="tubes" <?php echo ($e_product['unit'] == 'tubes') ? 'selected' : ''; ?>>Tubes</option>
                  <option value="boxes" <?php echo ($e_product['unit'] == 'boxes') ? 'selected' : ''; ?>>Boxes</option>
                  <option value="packs" <?php echo ($e_product['unit'] == 'packs') ? 'selected' : ''; ?>>Packs</option>
                  <option value="units" <?php echo ($e_product['unit'] == 'units') ? 'selected' : ''; ?>>Units</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="batch_number" class="form-label">Batch Number</label>
                <input type="text" class="form-control" name="batch_number" value="<?php echo remove_junk($e_product['batch_number'] ?? ''); ?>" placeholder="Optional">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="expiry_date" class="form-label">Expiry Date</label>
                <input type="date" class="form-control" name="expiry_date" value="<?php echo $e_product['expiry_date'] ?? ''; ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="supplier" class="form-label">Supplier</label>
                <input type="text" class="form-control" name="supplier" value="<?php echo remove_junk($e_product['supplier'] ?? ''); ?>" placeholder="Optional">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="storage_location" class="form-label">Storage Location</label>
                <input type="text" class="form-control" name="storage_location" value="<?php echo remove_junk($e_product['storage_location'] ?? ''); ?>" placeholder="e.g., Shelf A1, Refrigerator">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="low_stock_alert" class="form-label">Low Stock Alert Level</label>
                <input type="number" class="form-control" name="low_stock_alert" value="<?php echo (int)($e_product['low_stock_alert'] ?? 10); ?>" min="1" placeholder="Default: 10">
                <div class="form-text">System will alert when stock falls below this number</div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description / Notes</label>
            <textarea class="form-control" name="description" rows="3" placeholder="Any additional notes about this medicine..."><?php echo remove_junk($e_product['description'] ?? ''); ?></textarea>
          </div>

          <div class="mb-3">
            <button type="submit" name="update" class="btn btn-success">
              <i class="fas fa-save me-1"></i>Update Medicine
            </button>
            <a href="/BIHIS/modules/inventory/inventory.php" class="btn btn-secondary">
              <i class="fas fa-arrow-left me-1"></i>Back to Inventory
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Quick Info Card -->
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <strong><i class="fas fa-info-circle"></i> Medicine Information</strong>
      </div>
      <div class="card-body">
        <p><strong>Created:</strong> 
          <?php echo isset($e_product['created_at']) ? read_date($e_product['created_at']) : 'Unknown'; ?>
        </p>
        <p><strong>Last Updated:</strong> 
          <?php echo isset($e_product['updated_at']) ? read_date($e_product['updated_at']) : 'Unknown'; ?>
        </p>
        <p><strong>Current Status:</strong> 
          <?php 
          $quantity = $e_product['quantity'] ?? 0;
          $low_stock = $e_product['low_stock_alert'] ?? 10;
          
          if($quantity == 0) {
            echo '<span class="badge bg-danger">Out of Stock</span>';
          } elseif($quantity <= $low_stock) {
            echo '<span class="badge bg-warning text-dark">Low Stock</span>';
          } else {
            echo '<span class="badge bg-success">In Stock</span>';
          }
          ?>
        </p>
      </div>
    </div>
    
    <!-- Quick Actions Card -->
    <div class="card mt-3">
      <div class="card-header">
        <strong><i class="fas fa-bolt"></i> Quick Actions</strong>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <a href="/BIHIS/modules/inventory/inventory.php" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-list me-1"></i>View All Medicines
          </a>
          <a href="/BIHIS/modules/inventory/add_item.php" class="btn btn-outline-success btn-sm">
            <i class="fas fa-plus me-1"></i>Add New Medicine
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('../../layouts/footer.php'); ?>