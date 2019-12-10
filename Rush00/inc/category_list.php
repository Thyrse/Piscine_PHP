        <div class="category-block">
            <div class="category_title">
                <h3>Catégories</h3>
            </div>

            <div class="category-list">
                <ul>
                    <li><a href="index.php">Tous</a></li>
                <?php 
                $req = "SELECT id, name FROM category";
                $que = mysqli_query($link, $req);
                if ($que AND mysqli_num_rows($que) > 0) {
                    while ($data = mysqli_fetch_assoc($que))
                        echo '<li><a href="index.php?id='.$data['id'].'">'.$data['name'].'</a></li>';
                }
                ?>
                </ul>
            </div>
        </div>