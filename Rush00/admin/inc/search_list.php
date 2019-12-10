        <div class="category-block">
            <div class="category_title">
                <h3>Liste des <?php echo $what;?></h3>
            </div>

            <div class="category-list">
                <ul>
                    <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                    <li><a href="<?php echo $page.'?id='.$data['id'];?>"><?php echo $data['name'];?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>