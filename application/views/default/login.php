	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="<?= STATIC_PATH?>images/login-page-img.png" alt="">
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary"></h2>
						</div>
						<!-- <form action="<?= LINK.'Login/checkLogin'?>" method="post"> -->
							<div class="input-group custom">
								<input type="text" name="username" class="form-control form-control-lg" placeholder="บัญชีผู้ใช้">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="password" name="password" class="form-control form-control-lg" placeholder="รหัสผ่าน">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>

							<input type="hidden"  name="csrfmiddlewaretoken" value="<?= $csrfmiddlewaretoken ?>">

							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<input class="btn btn-primary btn-lg btn-block" type="button" value="เข้าสู่ระบบ" onclick="window.location.href='<?= LINK.'management/Index'?>'">
									</div>
								</div>
							</div>
						<!-- </form> -->
					</div>
				</div>
			</div>
		</div>
	</div>
