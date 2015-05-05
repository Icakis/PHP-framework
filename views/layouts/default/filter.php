<form method="post">
    <label>Show on page:</label>
    <select name='items_per_page' onchange='this.form.submit()'>
        <option value="2" <?php if($data['items_per_page']=== 2) echo 'selected'; ?>>2</option>
        <option value="5" <?php if($data['items_per_page']=== 5) echo 'selected'; ?>>5</option>
        <option value="10" <?php if($data['items_per_page']=== 10) echo 'selected'; ?>>10</option>
        <option value="20" <?php if($data['items_per_page']=== 20) echo 'selected'; ?>>20</option>
        <option value="50" <?php if($data['items_per_page']=== 50) echo 'selected'; ?>>50</option>
        <option value="100" <?php if($data['items_per_page']=== 100) echo 'selected'; ?>>100</option>
    </select>
    <noscript><input type="submit" value="Submit"></noscript>
</form>
