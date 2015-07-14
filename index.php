<?php
	include 'ClassLoader.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Tripzor</title>
</head>
<body>
<pre>
<?php
    ClassLoader::loadAll();
    if(!empty($_POST)){
        if(isset($_POST['action'])){
            ClassLoader::loadClass($_POST['action'], 'module');
        }
    }  
?>
</pre>
</body>
</html>