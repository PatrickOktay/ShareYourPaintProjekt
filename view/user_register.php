<div class="registration">
<h2>Registration</h2>
	<form id="register" name="register" method="post" action="/User/saveUser">
		<input id="username" name="username" type="text" maxlength="12" placeholder="Username (at least 4 characters)" size="30" required="true">
		<br>
		<input type="password" id="password" name="password" placeholder="Password (at least 5 characters)" size="30" required="true">
		<br>
		<input type="password" id="password2" name="password2" placeholder="Repeat password" size="30" required="true">
		<br>
		<textarea type="text" id="description" name="description" placeholder="If you want you can write a description about you :)"></textarea>
		<br>
		<button type="button" onclick="check()">Sign in</button>
		<button type="reset" onclick="reset()">Reset</button>
	</form>
</div>

<script type="text/javascript">
function check() {
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	var password2 = document.getElementById("password2").value;

	if (username.length < 4) {
  		alert("Username is too short!");
  		return false;
	}

	if (password.length < 5) {
		alert("Password is too short!");
		return false;
	}

	if (password2 != password) {
		alert("The passwords are not equal!");
		return false;
	}

	else {
    	document.getElementById("register").submit();
    }
}

function reset() {
	var warning = window.confirm("Do you really want to reset the form?");
	if(warning) {
		document.getElementById("register").reset();
	}
}
</script>