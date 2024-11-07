<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-heading">Management</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/quiztype">
                <i class="bi bi-list-columns"></i>
                <span>Quiz Type</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-question-octagon-fill"></i><span>Quiz</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/quiz">
                        <i class="bi bi-circle"></i><span>ALL</span>
                    </a>
                </li>
                @foreach ($types as $type)
                    <li>
                        <a href="/quiz?type={{ $type->id }}">
                            <i class="bi bi-circle"></i><span>{{ $type->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/paper">
                <i class="bi bi-envelope-paper-fill"></i>
                <span>Paper</span>
            </a>
        </li>
        <li class="nav-heading">Utility</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/setting">
                <i class="bi bi-gear-fill"></i>
                <span>Setting</span>
            </a>
        </li>
    </ul>
</aside>
