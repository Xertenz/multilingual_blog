	<?php
	if(preg_match('/admin/', $_SERVER['REQUEST_URI'])) {
		echo '<script src="../public/assets/js/bootstrap.min.js"></script>';
		echo '<script src="public/assets/js/tinymce/tinymce.min.js"></script>';
		echo '<script src="public/assets/js/main.js"></script>';
	}else{
		echo '<script src="public/assets/js/bootstrap.min.js"></script>';
	}
	?>

</body>
</html>