<!-- Bootstrap -->
<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<!-- NProgress -->
<br><br><br><br><br><br><br><br><br>
<section>
<div class="container">
<div class="row">
<div class="col-lg-12">
<?php
session_start();
ob_start();
session_destroy();
setcookie("idim", "", time()-3600);
echo '<div class="alert alert-danger" role="alert"><center>Güvenli Bir Şekilde Çıkış Yaptınız... <br> <small>Güvenlik Altyapınız SELF YAZILIM tarafından kriptolanmıştır..</small><hr> <h4 style="color:grey;">Yönlendiriliyorsunuz..</h4></center></div>';
echo '<script type="text/javascript">
							  window.location = "index.php"
							  </script>';
ob_end_flush();
?>
</div>
</div>
</div>
</section>
<div class="container">
<footer>
<div class="row">
<div class="col-lg-12">
<center><p>Copyright SELF YAZILIM 2017</p></center>
</div>
</div>
</footer>
</div>
