<ul class="list-unstyled mt-3">
  <li class="mb-1">
    <a href="/BIHIS/dashboard.php" class="nav-link d-block px-3 py-2">
      <i class="fas fa-tachometer-alt me-2"></i>
      <span>Dashboard</span>
    </a>
  </li>
  
  <li class="mb-1">
    <a href="/BIHIS/modules/users/users.php" class="nav-link d-block px-3 py-2">
      <i class="fas fa-users-cog me-2"></i>
      <span>User Management</span>
    </a>
  </li>
  
  <li class="mb-1">
      <a href="/BIHIS/modules/inventory/inventory.php" class="nav-link d-block px-3 py-2">
        <i class="fas fa-pills me-2"></i>
        <span>Medicines</span>
      </a>
  </li>

  <li class="mb-1">
    <a href="#" class="nav-link d-block px-3 py-2 dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#dispenseSubmenu">
      <i class="fas fa-hand-holding-medical me-2"></i>
      <span>Dispense</span>
      <i class="fas fa-chevron-down float-end mt-1"></i>
    </a>
    <ul class="nav submenu collapse list-unstyled ms-3" id="dispenseSubmenu">
      <li class="my-1">
        <a href="/BIHIS/modules/transactions/issue_items.php" class="nav-link d-block px-2 py-1">
          <i class="fas fa-paper-plane me-2"></i>
          Issue Items
        </a>
      </li>
      <li class="my-1">
        <a href="/BIHIS/modules/transactions/history.php" class="nav-link d-block px-2 py-1">
          <i class="fas fa-history me-2"></i>
          Transaction History
        </a>
      </li>
    </ul>
  </li>
  
  <li class="mb-1">
    <a href="#" class="nav-link d-block px-3 py-2 dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#reportsSubmenu">
      <i class="fas fa-chart-bar me-2"></i>
      <span>Reports</span>
      <i class="fas fa-chevron-down float-end mt-1"></i>
    </a>
    <ul class="nav submenu collapse list-unstyled ms-3" id="reportsSubmenu">
      <li class="my-1">
        <a href="/BIHIS/modules/reports/stock_report.php" class="nav-link d-block px-2 py-1">
          <i class="fas fa-cubes me-2"></i>
          Stock Report
        </a>
      </li>
      <li class="my-1">
        <a href="/BIHIS/modules/reports/expiry_report.php" class="nav-link d-block px-2 py-1">
          <i class="fas fa-calendar-times me-2"></i>
          Expiry Report
        </a>
      </li>
    </ul>
  </li>
</ul>