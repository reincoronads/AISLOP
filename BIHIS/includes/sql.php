<?php

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/
function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }

  /*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/
 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Find group level
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Function for cheaking which user level has access to page
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     
     //if user not login
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Please login...');
            redirect('index.php', false);
      //cheackin log in User level and Require level is Less than or equal to
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "Sorry! you dont have permission to view the page.");
            redirect('home.php', false);
        endif;
     }

/*--------------------------------------------------------------*/
/* INVENTORY MANAGEMENT FUNCTIONS
/*--------------------------------------------------------------*/

  /*--------------------------------------------------------------*/
  /* Function for Finding all medicines with categories
  /*--------------------------------------------------------------*/
  function find_all_medicines(){
     global $db;
     $sql  = "SELECT p.*, c.name as category_name ";
     $sql .= "FROM products p ";
     $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
     $sql .= "ORDER BY p.name ASC";
     return find_by_sql($sql);
   }

  /*--------------------------------------------------------------*/
  /* Function for Update product quantity (for dispensing)
  /*--------------------------------------------------------------*/
  function update_product_qty($qty, $p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity = quantity - '{$qty}' WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);
  }

  /*--------------------------------------------------------------*/
  /* Function for Update product quantity (for receiving/adding stock)
  /*--------------------------------------------------------------*/
  function add_product_qty($qty, $p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity = quantity + '{$qty}' WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);
  }

  /*--------------------------------------------------------------*/
  /* Function for Display Recent medicines Added
  /*--------------------------------------------------------------*/
 function find_recent_medicines_added($limit){
   global $db;
   $sql   = "SELECT p.id, p.name, p.quantity, p.unit, c.name AS category_name, p.expiry_date ";
   $sql  .= "FROM products p ";
   $sql  .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
   $sql  .= "ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
   return find_by_sql($sql);
 }

  /*--------------------------------------------------------------*/
  /* Function for Find low stock medicines
  /*--------------------------------------------------------------*/
  function find_low_stock_medicines($threshold = 10){
    global $db;
    $sql = "SELECT p.*, c.name as category_name ";
    $sql .= "FROM products p ";
    $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
    $sql .= "WHERE p.quantity <= p.low_stock_alert ";
    $sql .= "OR p.quantity <= {$threshold} ";
    $sql .= "ORDER BY p.quantity ASC";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for Find expiring medicines
  /*--------------------------------------------------------------*/
  function find_expiring_medicines($days = 30){
    global $db;
    $future_date = date('Y-m-d', strtotime("+{$days} days"));
    $sql = "SELECT p.*, c.name as category_name, DATEDIFF(p.expiry_date, CURDATE()) as days_until_expiry ";
    $sql .= "FROM products p ";
    $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
    $sql .= "WHERE p.expiry_date IS NOT NULL ";
    $sql .= "AND p.expiry_date <= '{$future_date}' ";
    $sql .= "AND p.expiry_date >= CURDATE() ";
    $sql .= "ORDER BY p.expiry_date ASC";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for Find expired medicines
  /*--------------------------------------------------------------*/
  function find_expired_medicines(){
    global $db;
    $sql = "SELECT p.*, c.name as category_name ";
    $sql .= "FROM products p ";
    $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
    $sql .= "WHERE p.expiry_date IS NOT NULL ";
    $sql .= "AND p.expiry_date < CURDATE() ";
    $sql .= "ORDER BY p.expiry_date ASC";
    return find_by_sql($sql);
  }

/*--------------------------------------------------------------*/
/* USER MANAGEMENT FUNCTIONS
/*--------------------------------------------------------------*/

/*--------------------------------------------------------------*/
/* Function to check if username exists
/*--------------------------------------------------------------*/
function is_username_exists($username){
  global $db;
  $username = $db->escape($username);
  $sql = "SELECT id FROM users WHERE username = '{$username}' LIMIT 1";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 1);
}

/*--------------------------------------------------------------*/
/* Function to register new user
/*--------------------------------------------------------------*/
function register_user($name, $username, $password){
  global $db;
  
  $name = $db->escape($name);
  $username = $db->escape($username);
  $password_hash = sha1($password);
  
  $sql = "INSERT INTO users (name, username, password, user_level, status) ";
  $sql .= "VALUES ('{$name}', '{$username}', '{$password_hash}', 2, 1)";
  
  if($db->query($sql)){
    return $db->insert_id();
  } else {
    return false;
  }
}

?>