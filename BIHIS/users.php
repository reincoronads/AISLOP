<?php
  $page_title = 'All Users';
  require_once('includes/load.php');
?>
<?php
// Checkin What level user has permission to view this page
 page_require_level(1);
//pull out all user form database
 $all_users = find_all_user();
?>
<?php include_once('layouts/header.php'); ?>

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
          <i class="fas fa-users me-2"></i>
          Users Management
        </strong>
        <a href="add_user.php" class="btn btn-success">
          <i class="fas fa-user-plus me-1"></i>Add New User
        </a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Name</th>
                <th>Username</th>
                <th class="text-center" style="width: 15%;">User Role</th>
                <th class="text-center" style="width: 10%;">Status</th>
                <th style="width: 20%;">Last Login</th>
                <th class="text-center" style="width: 120px;">Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($all_users as $a_user): ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td><?php echo remove_junk(ucwords($a_user['name']))?></td>
                <td><?php echo remove_junk(ucwords($a_user['username']))?></td>
                <td class="text-center">
                  <span class="badge bg-primary"><?php echo remove_junk(ucwords($a_user['group_name']))?></span>
                </td>
                <td class="text-center">
                <?php if($a_user['status'] === '1'): ?>
                  <span class="badge bg-success">Active</span>
                <?php else: ?>
                  <span class="badge bg-danger">Inactive</span>
                <?php endif;?>
                </td>
                <td>
                  <?php echo read_date($a_user['last_login'])?>
                </td>
                <td class="text-center">
                  <div class="btn-group" role="group">
                    <a href="edit_user.php?id=<?php echo (int)$a_user['id'];?>" 
                       class="btn btn-sm btn-warning" 
                       data-bs-toggle="tooltip" 
                       title="Edit User">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="delete_user.php?id=<?php echo (int)$a_user['id'];?>" 
                       class="btn btn-sm btn-danger" 
                       data-bs-toggle="tooltip" 
                       title="Delete User"
                       onclick="return confirm('Are you sure you want to delete this user?')">
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

<?php include_once('layouts/footer.php'); ?>