<div class="row" id="paginationContainer" data-ng-controller="paginationController">
    <div class="col-md-12">
        <ul class="pagination">
            <?php
            if ($data['num_pages'] > 1) {
                ?>
                <li>
                    <a href=<?php echo DX_ROOT_URL . $this->contollerName.'/'.$this->methodName ."/{$this->pageSize}/1"; ?>>First</a>
                </li>
                <?php

                for ($i = 0; $i < $data['num_pages']; $i++) {
                    $page_num = $i + 1;
                    ?>
                    <li <?php if ($page_num == $data['page']) echo "class='active'" ?>>
                        <a href=<?php echo DX_ROOT_URL . $this->contollerName.'/'.$this->methodName ."/{$this->pageSize}/{$page_num}"; ?>><?php echo $page_num; ?></a>
                    </li>
                <?php
                }
                ?>
                <li>
                    <a href=<?php echo DX_ROOT_URL .$this->contollerName.'/'.$this->methodName ."/{$data['num_pages']}"; ?>>Last</a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>