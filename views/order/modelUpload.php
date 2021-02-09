<?php
?>


<div class="orderContent">

	<div id="fileUpload">
		<form action="index.php?c=order&a=configurator" method="POST" enctype="multipart/form-data">
			Select model to upload (only .stl):
			<input type="file" name="uploadFile" id="uploadFile" required>
			<br>

			<input type="submit" value="Upload php" name="submit">

		</form>
	</div>
</div>
