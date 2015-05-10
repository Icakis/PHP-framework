<?php
use \Lib\TokenGenerator;

if($this->isGet()){
    include_once 'lib/tokenGenerator.php';
    $randnum = new TokenGenerator();
    $randnum->getToken();
    $_SESSION['search_token'] = $randnum->getToken();
}

?>

<form method="post" id="searchFormId">
    <input type="hidden" name="search_token" value="<?php echo $_SESSION['search_token']; ?>">
    <input type="text" name="search" placeholder=<?php
//    var_dump($data);
    if(isset($data['search_placeholder'])){
        echo "'".htmlentities($data['search_placeholder'])."'";
    }else{
        echo 'search...';
    } ?>>
    <input type="submit" value="Search"/>
</form>
