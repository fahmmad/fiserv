<table>

<?php
foreach($items as $item) {
    echo "<tr><td colspan=" . $item["location"] . ">&nbsp;</td><td>" . $item["value"] . "</tr></td>";
}
?>

</table>

<hr/>
<form action="./index.php" method="post">
<div>
    <div><h3>Search</h3></div>
    <div><input type="text" name="search"></div>
    <div><input type="submit" value="search"></div>
</div>    
</form>