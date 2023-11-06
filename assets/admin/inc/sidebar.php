<div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= ($page_title_code == "main") ? "active" : "" ?>" aria-current="page" href="./index.php">
                                <span data-feather="home" class="align-text-bottom"></span>
                                메인
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($page_title_code == "c_manager") ? "active" : "" ?>" href="./category_manager.php">
                                <span data-feather="file" class="align-text-bottom"></span>
                                카테고리 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($page_title_code == "product") ? "active" : "" ?>" href="./product.php">
                                <span data-feather="file" class="align-text-bottom"></span>
                                상품 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($page_title_code == "order") ? "active" : "" ?>" href="./order.php">
                                <span data-feather="shopping-cart" class="align-text-bottom"></span>
                                주문 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($page_title_code == "member") ? "active" : "" ?>" href="./user.php">
                                <span data-feather="users" class="align-text-bottom"></span>
                                회원 관리
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>