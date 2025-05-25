<?php
const navigations = [
    ['name'=>'Dashboard', 'icon' => 'speedometer2', 'link'=>'/dashboard'],
    ['name'=>'Vehicles', 'icon' => 'speedometer2', 'link'=>'/vehicles'],
    ['name'=>'Warehouses', 'icon' => 'speedometer2', 'link'=>'/warehouses'],
    ['name'=>'Products', 'icon' => 'speedometer2', 'link'=>'/products'],
    ['name'=>'Stock Transactions', 'icon' => 'speedometer2', 'link'=>'/stock-transactions'],
];

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>

<div id="side-nav" class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark vh-100 offcanvas-md offcanvas-start" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi pe-none me-2" style="width: 40px; height: 32px;" aria-hidden="true"><use xlink:href="#bootstrap"></use></svg> <span class="fs-4">Sidebar</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <?php
        foreach (navigations as $nav) {
            $isActive = ($currentPath === $nav['link']);
            echo '<li class="nav-item">';
            echo '<a href="'. $nav['link'] . '" class="nav-link text-white ' . ($isActive ? 'active' : '') . '">';
            echo '<svg class="bi pe-none me-2" width="16" height="16" aria-hidden="true">';
            echo sprintf('<use xlink:href="#%s"></use>', $nav['icon']);
            echo '</svg>';
            echo $nav['name'];
            echo '</a>';
            echo '</li>';
        }
        ?>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="javascript:void(0);" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="/assets/images/avatar.png" alt="" width="32" height="32" class="rounded-circle">
            <strong class="ps-2 pe-2">omurefeguclu</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="/auth/logout">Sign out</a></li>
        </ul>
    </div>
</div>