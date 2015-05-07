<form method="post" id="pageSizeFormId">
    <label>Show on page:</label>
    <select name='items_per_page' onchange='this.form.submit()'>
        <option value="2" <?php if ($this->pageSize === 2) echo 'selected'; ?>>2</option>
        <option value="5" <?php if ($this->pageSize === 5) echo 'selected'; ?>>5</option>
        <option value="10" <?php if ($this->pageSize === 10) echo 'selected'; ?>>10</option>
        <option value="20" <?php if ($this->pageSize === 20) echo 'selected'; ?>>20</option>
        <option value="50" <?php if ($this->pageSize === 50) echo 'selected'; ?>>50</option>
        <option value="100" <?php if ($this->pageSize === 100) echo 'selected'; ?>>100</option>
    </select>
    <noscript><input type="submit" value="Submit"></noscript>
</form>
