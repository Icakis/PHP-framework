<form method="post" id="searchFormId">
    <input type="text" name="search" placeholder=<?php
//    var_dump($data);
    if($data['search_placeholder']){
        echo "'".$data['search_placeholder']."'";
    }else{
        echo 'search...';
    } ?>>
    <input type="submit" value="Search"/>
</form>
