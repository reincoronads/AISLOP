<?php
  $page_title = 'Add New Medicine';
  require_once('../../includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $categories = find_all('categories');
?>

<?php
// Add New Medicine
if(isset($_POST['add_medicine'])) {
    $req_fields = array('name','category','quantity','unit');
    validate_fields($req_fields);
    
    if(empty($errors)){
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
        
        $sql = "INSERT INTO products (
                name, brand, categorie_id, quantity, unit, 
                batch_number, expiry_date, supplier, storage_location, 
                low_stock_alert, description, created_at
                ) VALUES (
                '{$name}', '{$brand}', '{$category}', '{$quantity}', '{$unit}',
                '{$batch_number}', '{$expiry_date}', '{$supplier}', '{$storage_location}',
                '{$low_stock_alert}', '{$description}', NOW()
                )";
         
        $result = $db->query($sql);
        
        if($result && $db->affected_rows() === 1){
            $session->msg('s',"New medicine added successfully");
            redirect('/BIHIS/modules/inventory/inventory.php', false);
        } else {
            $session->msg('d','Sorry, failed to add new medicine!');
            redirect('/BIHIS/modules/inventory/add_item.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('/BIHIS/modules/inventory/add_item.php', false);
    }
}
?>

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
          <i class="fas fa-plus-circle"></i>
          Add New Medicine
        </strong>
      </div>
      <div class="card-body">
        <form method="post" action="/BIHIS/modules/inventory/add_item.php" class="clearfix">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label">Medicine Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="brand" class="form-label">Brand/Manufacturer</label>
                <input type="text" class="form-control" name="brand" value="<?php echo isset($_POST['brand']) ? $_POST['brand'] : ''; ?>" placeholder="Optional">
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
                  <option value="<?php echo (int)$cat['id']; ?>" <?php echo (isset($_POST['category']) && $_POST['category'] == $cat['id']) ? 'selected' : ''; ?>>
                    <?php echo remove_junk(ucwords($cat['name'])); ?>
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="quantity" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : '0'; ?>" min="0" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                <select class="form-control" name="unit" required>
                  <option value="">Select Unit</option>
                  <option value="tablets" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'tablets') ? 'selected' : ''; ?>>Tablets</option>
                  <option value="capsules" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'capsules') ? 'selected' : ''; ?>>Capsules</option>
                  <option value="bottles" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'bottles') ? 'selected' : ''; ?>>Bottles</option>
                  <option value="vials" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'vials') ? 'selected' : ''; ?>>Vials</option>
                  <option value="tubes" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'tubes') ? 'selected' : ''; ?>>Tubes</option>
                  <option value="boxes" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'boxes') ? 'selected' : ''; ?>>Boxes</option>
                  <option value="packs" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'packs') ? 'selected' : ''; ?>>Packs</option>
                  <option value="units" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'units') ? 'selected' : ''; ?>>Units</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="batch_number" class="form-label">Batch Number</label>
                <input type="text" class="form-control" name="batch_number" value="<?php echo isset($_POST['batch_number']) ? $_POST['batch_number'] : ''; ?>" placeholder="Optional">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="expiry_date" class="form-label">Expiry Date</label>
                <input type="date" class="form-control" name="expiry_date" value="<?php echo isset($_POST['expiry_date']) ? $_POST['expiry_date'] : ''; ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="supplier" class="form-label">Supplier</label>
                <input type="text" class="form-control" name="supplier" value="<?php echo isset($_POST['supplier']) ? $_POST['supplier'] : ''; ?>" placeholder="Optional">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="storage_location" class="form-label">Storage Location</label>
                <input type="text" class="form-control" name="storage_location" value="<?php echo isset($_POST['storage_location']) ? $_POST['storage_location'] : ''; ?>" placeholder="e.g., Shelf A1, Refrigerator">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="low_stock_alert" class="form-label">Low Stock Alert Level</label>
                <input type="number" class="form-control" name="low_stock_alert" value="<?php echo isset($_POST['low_stock_alert']) ? $_POST['low_stock_alert'] : '10'; ?>" min="1" placeholder="Default: 10">
                <div class="form-text">System will alert when stock falls below this number</div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description / Notes</label>
            <textarea class="form-control" name="description" rows="3" placeholder="Any additional notes about this medicine..."><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
          </div>

          <div class="mb-3">
            <button type="submit" name="add_medicine" class="btn btn-primary">
              <i class="fas fa-save me-1"></i>Add Medicine
            </button>
            <a href="/BIHIS/modules/inventory/inventory.php" class="btn btn-secondary">
              <i class="fas fa-arrow-left me-1"></i>Back to Inventory
            </a>
            <button type="reset" class="btn btn-outline-secondary">
              <i class="fas fa-undo me-1"></i>Reset Form
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Quick Info Card -->
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <strong><i class="fas fa-info-circle"></i> Adding New Medicine</strong>
      </div>
      <div class="card-body">
        <p class="text-muted">
          <i class="fas fa-exclamation-circle text-warning me-1"></i>
          Fields marked with <span class="text-danger">*</span> are required.
        </p>
        <hr>
        <p><strong>Required Fields:</strong></p>
        <ul class="small">
          <li>Medicine Name</li>
          <li>Category</li>
          <li>Quantity</li>
          <li>Unit</li>
        </ul>
        <p><strong>Recommended Fields:</strong></p>
        <ul class="small">
          <li>Expiry Date</li>
          <li>Low Stock Alert</li>
          <li>Storage Location</li>
        </ul>
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
          <a href="/BIHIS/modules/inventory/manage_categories.php" class="btn btn-outline-info btn-sm">
            <i class="fas fa-tags me-1"></i>Manage Categories
          </a>
        </div>
      </div>
    </div>

    <!-- Recent Additions Card -->
    <div class="card mt-3">
      <div class="card-header">
        <strong><i class="fas fa-clock"></i> Recent Additions</strong>
      </div>
      <div class="card-body">
        <p class="text-muted small">
          New medicines will appear in the inventory list immediately after being added.
        </p>
        <p class="text-muted small">
          Don't forget to set appropriate low stock alerts for better inventory management.
        </p>
      </div>
    </div>
  </div>
</div>

<?php include_once('../../layouts/footer.php'); ?>