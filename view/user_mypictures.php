<h3>Upload your pictures!</h3>
<form action="/Picture/upload" method="post" enctype="multipart/form-data">
	<input type="text" name="titel" placeholder="Title" required="true"><br>
	<input type="file" name="img">
	<br>
	<textarea name="desc" placeholder="Here you can write a description of your picture!"></textarea><br>
	<button type="submit">Send</button>
</form>