<?php
include( "../config/config.php" );
include( "../functions.php" );

if ( ( $_SESSION[ 'id' ] ) )
	header( 'Location:' . $baseurl . 'controlgear/dashboard' );

if ( isset( $_POST[ 'login' ] ) ) {
	$email = $_POST[ 'userEmail' ];
	$password = $_POST[ 'userPassword' ];

	$sql = mysqli_query( $conn, "SELECT * FROM users WHERE email = '" . $email . "'" );
	$row = mysqli_fetch_assoc( $sql );

	if ( $email != $row[ 'email' ] ) {
		$errMsg = '<div class="alert alert-danger" role="alert">User <b>' . $email . '</b> not found.</div>';
	} elseif ( $email != $row[ 'email' ] && md5( $password ) != $row[ 'password' ] ) {
		$errMsg = '<div class="alert alert-danger" role="alert">Incorrect Email or Password.</div>';
	} elseif ( $email == "" && $password == ""
		or $email == ""
		or $password == "" ) {
		$errMsg = '<div class="alert alert-danger" role="alert">Please Enter Email or Password.</div>';
	} elseif ( $row[ 'status' ] == 1 ) {
		if ( $row[ 'password' ] == md5( $password ) ) {
			$_SESSION[ 'id' ] = $row[ 'id' ];
			$old_session_id = session_id();
			session_start();
			$_SESSION[ 'id' ];
			$old_session_id;

			mysqli_close( $conn );
			session_write_close();

			header( 'Location: ' . $baseurl . 'controlgear/dashboard' );
			exit;
		} else {
			$errMsg = '<div class="alert alert-danger" role="alert">Incorrect email or password</div>';
		}
	} else {
		$errMsg = '<div class="alert alert-danger" role="alert">Your account not Active</div>';
	}
}

$email = $_REQUEST[ 'userEmail' ];
$pass = $_REQUEST[ 'userPassword' ];
?>
<?php include("header.php"); ?>
<main>
	<section class="section bg-lightgrey">
		<div class="container pt-130">
			<div class="row justify-content-center">
				<div class="col-md-5">
					<div class="registerForm bs-30 br-7 bg-white">
						<div class="heading font22 bg-blue text-white fw-500 pt-3 pb-3 text-center">Login to Your Account</div>
						<div class="pt-4 pb-5 pl-3 pr-3">
							<?php if(isset($errMsg)){ echo "".$errMsg.""; } ?>
							<form action="" method="post">
								<div class="form-group">
									<label class="label">Email Address <span class="required">*</span></label>
									<input type="email" name="userEmail" id="userEmail" class="form-control" value="<?php echo $email; ?>">
								</div>
								<div class="form-group">
									<label class="label w-100">
										<div class="d-flex flex-row">Password <span class="required">*</span> </div>
									</label>
									<input type="password" name="userPassword" id="userPassword" class="form-control" value="<?php echo $pass; ?>">
								</div>

								<div class="form-group text-center mt-4">
									<input type="submit" name="login" id="login" class="btn btn-blue" value="Login">
<div class="mt-4 fw-400"> Or <a href="<?php echo $baseurl; ?>controlgear/forgot" class="text-underline">Forgot Password</a></div>
								</div>
							</form>
						</div>

					</div>


				</div>
			</div>
		</div>
	</section>
</main>
<?php include("footer.php"); ?>
<?php mysqli_close($conn); ?>