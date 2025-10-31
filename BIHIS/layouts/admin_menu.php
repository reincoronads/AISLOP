<ul class="list-unstyled mt-3">
  <li class="mb-1">
    <a href="admin.php" class="text-white text-decoration-none d-block px-3 py-2 rounded hover-bg">
      <i class="fas fa-tachometer-alt me-2"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li class="mb-1">
    <a href="#" class="submenu-toggle text-white text-decoration-none d-block px-3 py-2 rounded hover-bg dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#userManagementSubmenu">
      <i class="fas fa-users-cog me-2"></i>
      <span>User Management</span>
      <i class="fas fa-chevron-down float-end mt-1"></i>
    </a>
    <ul class="nav submenu collapse list-unstyled ms-3" id="userManagementSubmenu">
      <li class="my-1">
        <a href="users.php" class="text-white-50 text-decoration-none d-block px-2 py-1 rounded hover-bg-sm">Manage Users</a>
      </li>
    </ul>
  </li>
</ul>

<style>
.hover-bg:hover {
  background-color: #34495e;
  transition: background-color 0.3s ease;
}
.hover-bg-sm:hover {
  background-color: #3d566e;
  transition: background-color 0.3s ease;
}
.submenu-toggle[aria-expanded="true"] .fa-chevron-down {
  transform: rotate(180deg);
  transition: transform 0.3s ease;
}
.collapse.show {
  background-color: #2c3e50;
  border-radius: 0.375rem;
  margin: 0.25rem 0;
}
</style>