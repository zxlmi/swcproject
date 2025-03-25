<style>
    /* Elegant Hero Section */
    .masthead {
        position: relative;
        background: url('path/to/your/luxury-pizza-background.jpg') no-repeat center center;
        background-size: cover;
        height: 40vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
    }

    .masthead::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .masthead h1 {
        position: relative;
        color: #ffcc00;
        font-size: 2.8rem;
        font-weight: bold;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
        font-family: 'Playfair Display', serif;
    }

    .masthead .divider {
        position: relative;
        width: 70px;
        border-top: 3px solid #ffcc00;
        margin: 15px auto;
    }

    .masthead .btn {
        position: relative;
        font-size: 1.3rem;
        padding: 12px 35px;
        border-radius: 30px;
        background: linear-gradient(135deg, #ff8800, #e63946);
        border: none;
        color: white;
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 3px 8px rgba(255, 136, 0, 0.5);
    }

    .masthead .btn:hover {
        background: linear-gradient(135deg, #e63946, #ff8800);
        transform: scale(1.05);
    }

    /* Premium Menu Section */
    .page-section {
        background: #121212;
        color: #f8f8f8;
        padding: 80px 0;
    }

    .page-section h1 {
        font-size: 3.5em;
        font-weight: bold;
        color: #ffcc00;
        font-family: 'Playfair Display', serif;
    }

    .menu-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 columns */
        grid-template-rows: repeat(2, auto);  /* 2 rows */
        gap: 20px;
        justify-content: center;
        padding: 20px;
    }

    .menu-item {
        background: #222;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
        padding: 20px;
        text-align: center;
    }

    .menu-item:hover {
        transform: scale(1.05);
        box-shadow: 0px 6px 15px rgba(255, 204, 0, 0.3);
    }

    .menu-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-bottom: 4px solid #ffcc00;
        border-radius: 10px;
    }

    .menu-item h5 {
        font-size: 1.3rem;
        color: #ffcc00;
        font-weight: bold;
        margin-top: 10px;
    }

    .menu-item p {
        font-size: 1rem;
        color: #bbb;
        margin-bottom: 15px;
    }

    .menu-btn {
        font-size: 1rem;
        background: #e63946;
        border: none;
        color: white;
        border-radius: 5px;
        padding: 10px 15px;
        transition: all 0.3s ease-in-out;
    }

    .menu-btn:hover {
        background: #ff8800;
        transform: scale(1.1);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .pagination-btn {
        background: #e63946;
        color: white;
        padding: 10px 15px;
        margin: 5px;
        border-radius: 5px;
        text-decoration: none;
        transition: all 0.3s ease-in-out;
    }

    .pagination-btn:hover {
        background: #ff8800;
    }

    .page-number {
        color: #ffcc00;
        font-weight: bold;
        margin: 0 15px;
    }

    @media (max-width: 992px) {
        .menu-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .menu-container {
            grid-template-columns: repeat(1, 1fr);
        }
    }
</style>

<!-- Hero Section -->
<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
                <h1>Welcome to <?php echo $_SESSION['setting_name']; ?></h1>
                <hr class="divider my-4" />
                <a class="btn btn-xl" href="#menu">Order Now</a>
            </div>
        </div>
    </div>
</header>

<!-- Menu Section -->
<section class="page-section" id="menu">
    <h1 class="text-center">Our Premium Menu</h1>
    <div class="d-flex justify-content-center">
        <hr class="border-light" width="5%">
    </div>

    <div class="container mt-4">
        <div class="menu-container">
            <?php 
                include 'admin/db_connect.php';

                // Pagination setup
                $limit = 6; // 3x2 grid = 6 items per page
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                // Count total products
                $total_qry = $conn->query("SELECT COUNT(*) as total FROM product_list");
                $total_result = $total_qry->fetch_assoc();
                $total_products = $total_result['total'];
                $total_pages = ceil($total_products / $limit);

                // Fetch menu items for current page
                $qry = $conn->query("SELECT * FROM product_list ORDER BY name ASC LIMIT $limit OFFSET $offset");

                while ($row = $qry->fetch_assoc()):
            ?>
            <div class="menu-item shadow-sm">
                <img src="assets/img/<?php echo $row['img_path']; ?>" alt="Pizza Image">
                <h5><?php echo $row['name']; ?></h5>
                <p class="text-muted"><?php echo $row['description']; ?></p>
                <button class="btn menu-btn view_prod" data-id="<?php echo $row['id']; ?>">
                    <i class="fa fa-eye"></i> View
                </button>
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination Controls -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>" class="pagination-btn">← Previous</a>
            <?php endif; ?>

            <span class="page-number">Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo ($page + 1); ?>" class="pagination-btn">Next →</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.view_prod').forEach(button => {
            button.addEventListener('click', function() {
                let productId = this.getAttribute('data-id');
                uni_modal_right('Product Details', 'view_prod.php?id=' + productId);
            });
        });
    });
</script>
