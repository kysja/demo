
<ul class="nav nav-pills mt-1">
    
    <li class="nav-item"><a href="/" class="nav-link <?= $viewGlobal['uri'] === '/' ? 'active' : ''  ?>">Dashboard</a></li>
    <li class="nav-item"><a href="/import" class="nav-link <?= str_starts_with($viewGlobal['uri'], '/import') === true ? 'active' : ''  ?>">Import</a></li>
    <li class="nav-item"><a href="/logout" class="nav-link">Log Out</a></li>

</ul>