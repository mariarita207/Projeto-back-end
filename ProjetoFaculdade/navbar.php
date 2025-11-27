<nav class="navbar navbar-dark" style="background-color: #392666;">
    <div class="container-fluid d-flex align-items-center justify-content-between">

        <!-- LOGO -->
        <a href="home.php" class="navbar-brand d-flex align-items-center">
            <img 
                src="https://raw.githubusercontent.com/mariarita207/Projeto-back-end/refs/heads/main/ProjetoFaculdade/assets/images/logo%2Bnome.png"
                alt="Logo"
                style="width: 150px; height: auto;"
            >
        </a>

        <!-- DROPDOWN DE ORDENAÇÃO -->
        <div class="dropdown">
            <button class="btn btn-light btn-sm dropdown-toggle small" 
                    type="button" data-bs-toggle="dropdown">
                Ordenar
            </button>

            <ul class="dropdown-menu dropdown-menu-end p-1 small">
                <li><a class="dropdown-item small" href="#" data-ordem="">Todos</a></li>
                <li><a class="dropdown-item small" href="#" data-ordem="asc">Nome A–Z</a></li>
                <li><a class="dropdown-item small" href="#" data-ordem="desc">Nome Z–A</a></li>
            </ul>
        </div>

        
    </div>
</nav>
