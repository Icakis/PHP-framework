<?php
if (count($this->items) > 0) {
    ?>
    <ul>
        <?php
        foreach ($this->items as $item) {
            ?>
            <li><?php echo $item['todo_item'] ?> <a href=<?php echo DX_ROOT_URL . 'todos/delete/' . $item['id'] ?>>Delete</a>
            </li>
        <?php
        }
        ?>
    </ul>

<?php
} else {
    echo "<p>No Todo Items</p>";
}
?>
<form method="Post" action=<?php echo DX_ROOT_URL . 'todos/add' ?>>
    <input type="text" name="todo_item">
    <input type="submit" value="Add Item">
</form>