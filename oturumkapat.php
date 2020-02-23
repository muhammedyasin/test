<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Self Yazılım </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>
  <?php
  session_start();
  ob_start();
  $idicik = $_SESSION['kid'];
  session_destroy();
  ob_end_flush();
  ?>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
        <?php
        include_once("selfyazilim.php");
        $ciktimesaj="";
        if(@$_POST)
        {
            session_start();
            ob_start();
            $ka = $_POST['kad'];
            $sifre = $_POST['sifre'];
            $vt = new veritabani();
            $sorgu = $vt->listele("kullanici","WHERE kuladi='".$ka."' and sifre='".$sifre."'");
            if($sorgu != null) foreach( $sorgu as $satir ) {
                if($ka==$satir['kuladi'] && $sifre==$satir['sifre'])
                {
                    $_SESSION['kid'] = $satir['id'];
                    $_SESSION['kadi'] = $satir['kuladi'];
                    $_SESSION['gorev'] = $satir['gorev'];
                    $_SESSION['yetki'] = $satir['yetki'];
                    $_SESSION['kt'] = $satir['kayittarihi'];
                    echo '<script type="text/javascript">
							  window.location = "panel.php"
							  </script>';
                }
            }

            $ciktimesaj=" Kullanıcı Adı ve Şifre Yanlış! ";
        }
        ?>
      <div class="login_wrapper">
       <div class="animate form login_form">
          <section class="login_content">
			<form  action="" method="POST">
                <?php
                $vt = new veritabani();
                $id = $_COOKIE["idim"];
                $sorgum = $vt->listele("kullanici","WHERE id='".$idicik."'");
                if($sorgum != null) foreach( $sorgum as $bilgi ) {
                    echo "<img src='".$bilgi['resim']."' width='120px' height='120px'> <hr>";
                ?>

              <div>
                <input type="text" class="form-control" value="<?php echo $bilgi['kuladi']; ?>" name="kad" required="" readonly/>
              </div>
                <?php } ?>
              <div>
                <input type="password" class="form-control" placeholder="Şifre" name="sifre" required="" />
              </div>
              <div><br>
               <center> <input type="submit" class="btn btn-primary submit col-lg-8" name="giris" value="Oturum Aç">   <?php echo "<font color='red'>".$ciktimesaj."</font>"; ob_end_flush();  ?></center>
              </div>
			</form>
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><img src="images/250x250logo.png" width="45px" height="45px">Self Yazılım </h1>
                  <p>©2017 Tüm Hakları Saklıdır.</p>
                </div>
              </div>
          </section>
        </div>
		

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Şifre Sıfırla</h1>
              <div>
                <input type="text" class="form-control" placeholder="Kullanıcı Adı" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="E-Mail" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Şifre" required="" />
              </div>
              <div>
                <a class="btn btn-default submit" href="#">Şifreyi Sıfırla</a>
              </div>

              <div class="clearfix"></div>
			
              <div class="separator">
                <div class="clearfix"></div>
				<a href="#signin" class="to_register">  Giriş Yap </a>
                <br />

                <div>
                   <h1><img src="images/250x250logo.png" width="45px" height="45px"> Self Yazılım </h1>
                  <p>©2017 Tüm Hakları Saklıdır.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
