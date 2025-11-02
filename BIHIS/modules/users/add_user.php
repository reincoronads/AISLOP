<?php
  $page_title = 'Add User';
  require_once('../../includes/load.php');  // Updated path - go up 2 levels
  // Checkin What level user has permission to view this page
  page_require_level(1);
  $groups = find_all('user_groups');
?>
<?php
  if(isset($_POST['add_user'])){

   $req_fields = array('full-name','username','password','level' );
   validate_fields($req_fields);

   if(empty($errors)){
       $name   = remove_junk($db->escape($_POST['full-name']));
       $username   = remove_junk($db->escape($_POST['username']));
       $password   = remove_junk($db->escape($_POST['password']));
       $user_level = (int)$db->escape($_POST['level']);
       $password = sha1($password);
        $query = "INSERT INTO users (";
        $query .="name,username,password,user_level,status";
        $query .=") VALUES (";
        $query .=" '{$name}', '{$username}', '{$password}', '{$user_level}','1'";
        $query .=")";
        if($db->query($query)){
          //sucess
          $session->msg('s',"User account has been created! ");
          redirect('../../modules/users/add_user.php', false);  // Updated path
        } else {
          //failed
          $session->msg('d',' Sorry failed to create account!');
          redirect('../../modules/users/add_user.php', false);  // Updated path
        }
   } else {
     $session->msg("d", $errors);
      redirect('../../modules/users/add_user.php',false);  // Updated path
   }
 }
?>
<?php include_once('../../layouts/header.php'); ?>  <!-- Updated path -->

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
          <i class="fas fa-user-plus"></i>
          <span>Add New User</span>
       </strong>
      </div>
      <div class="card-body">
        <form method="post" action="add_user.php">  <!-- Kept same - relative to current file -->
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="full-name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="full-name" placeholder="Enter full name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Choose username" required>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="level" class="form-label">User Role</label>
                <select class="form-select" name="level" required>
                  <option value="">Select Role</option>
                  <?php foreach ($groups as $group ):?>
                   <option value="<?php echo $group['group_level'];?>">
                     <?php echo ucwords($group['group_name']);?>
                   </option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <button type="submit" name="add_user" class="btn btn-success">
              <i class="fas fa-save me-1"></i>Create User
            </button>
            <a href="users.php" class="btn btn-secondary">  <!-- Relative to current folder -->
              <i class="fas fa-arrow-left me-1"></i>Back to Users
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Quick Help Card -->
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <strong><i class="fas fa-info-circle"></i> User Roles</strong>
      </div>
      <div class="card-body">
        <small class="text-muted">
          <strong>Admin:</strong> Full system access<br>
          <strong>Health Staff:</strong> Inventory and transactions<br>
          <strong>Clerk:</strong> Basic data entry (if applicable)
        </small>
      </div>
    </div>
  </div>
</div>

<?php include_once('../../layouts/footer.php'); ?>  <!-- Updated path -->