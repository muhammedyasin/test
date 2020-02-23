<?php
/*ob_start();
session_start();*/
if(empty($_SESSION['yetki']))
{
	 header('Location: index.php');
}
else
{ 
include_once("selfyazilim.php"); 
$vt = new veritabani(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Self Yazılım </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
      <!-- Chart.js -->
      <script src="vendors/Chart.js/dist/Chart.min.js"></script
              <!-- jQuery -->
      <script src="vendors/jquery/dist/jquery.min.js"></script>

  </head>
  <div style="padding:0; margin:0;" >
  <body class="nav-md">
    <div class="container body" style="padding:0; margin:0;" >
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="#" class="site_title"><img src="images/250x250logo.png" width="45px" height="45px"><span><img src="images/yazim.png" width="150px" height="45px"></span></a>
            </div>

            <div class="clearfix" ></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
			  <?php 
				$sorgu = $vt->listele("kullanici","WHERE id=".$_SESSION['kid']."");
if($sorgu != null) foreach( $sorgu as $satir ) {
	echo '<img src="'.$satir["resim"].'" alt="'.$satir["kuladi"].' Adlı Kullanıcının Profil Fotoğrafı" class="img-circle profile_img">';
 ?>
              </div>
              <div class="profile_info">
                <span>Hoşgeldin,</span>
                <h2> <?php 	echo "<b>".$satir["kuladi"]."</b>";} ?>
				</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
			   <br />
                <h3>Menu </h3>
                <ul class="nav side-menu">
                  <li><a href="panel.php"><i class="fa fa-home"></i> Ana Sayfa </a></li>
				  <li><a href="mesaj.php"><i class="fa fa-envelope-o"></i> İletiler </a></li>
                  <li><a href="cm.php"><i class="fa fa-edit"></i> Çalışma Masası </a></li>
                  <li><a href="proje.php"><i class="fa  fa-cube"></i> Projeler </a></li>
                    <li><a href="muhasebe.php"><i class="fa fa-calculator"></i> Muhasebe </a></li>
                  <li><a href="evrak.php"><i class="fa fa-file-archive-o"></i> Evraklar </a></li>
				  <li><a href="musteri.php"><i class="fa fa-cubes"></i> Müşteriler </a></li>
                    <li><a href="#.php"><i class="fa fa-users"></i> Ekip </a></li>
                </ul>
              </div>
                <div class="menu_section">
                    <h3> Ön Sayfa İşlemleri</h3>
                    <ul class="nav side-menu">
                        <li><a ><i class="fa  fa-keyboard-o"></i> Yazılar <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="#">Yazı İşlemleri</a></li>
                                <li><a href="#">Kategoriler</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa  fa-male"></i> Referanslar </a></li>
                        <li><a><i class="fa  fa-suitcase"></i> Projeler </a></li>
                        <li><a><i class="fa  fa-users"></i> Kurumsal <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="#">Hakkımızda</a></li>
                                <li><a href="#">Misyon</a></li>
                                <li><a href="#">Vizyon</a></li>
                                <li><a href="#">Logo ve Kurumsal Görseller</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-bullhorn"></i> Duyurular </a></li>
                        <li><a href="javascript:void(0)" disabled="disabled"><i class="fa fa-laptop"></i> Siteyi Göster <span class="label label-success pull-right">Yakında!</span></a></li>
                    </ul>
                </div>
              <div class="menu_section">
                <h3> Yönetici İşlemleri </h3>
                <ul class="nav side-menu">
                  <li><a data-toggle="modal" data-target="#yonetici" ><i class="fa fa-cog"></i> Kullanıcı Ekle </a></li>

                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Ayarlar">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
			  <a data-toggle="tooltip" data-placement="top" id="tamekran-button" title="Tam Ekran">
			 <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
			  </a>
              <a data-toggle="tooltip" data-placement="top" title="Oturumu Kapat" href="oturumkapat.php">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Çıkış" href="cikis.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav" >
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
<?php $sorgu = $vt->listele("kullanici","WHERE id=".$_SESSION['kid']."");
if($sorgu != null) foreach( $sorgu as $satir ) {
 ?>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <?php  echo '<img src="'.$satir["resim"].'" alt=""> '.$satir["kuladi"].''; } ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="profil.php"> Profil</a></li>
                    <li><a href="javascript:;">Yardım</a></li>
                    <li><a href="cikis.php"><i class="fa fa-sign-out pull-right"></i> Çıkış </a></li>
                  </ul>
                </li>
				
                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
					<?php $mesajsorgu = $vt->listele("mesajlar","WHERE alici=".$_SESSION['kid']." AND durum=1");
					?>
                    <span class="badge bg-green"><?php $sayi = $mesajsorgu->rowCount(); echo $sayi;  ?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
					<?php if($mesajsorgu != null) foreach( $mesajsorgu as $satir ) { ?>
                      <a href="mesaj.php?icerik=<?php echo $satir['id']; ?>">
                        <span class="image"><?php         
						  $mesajsorgu1 = $vt->listele("kullanici");
						  if($mesajsorgu1 != null) foreach( $mesajsorgu1 as $bilgi ) {
							if($bilgi['id']==$satir['gon']){
								echo '<img src="'.$bilgi['resim'].'" width="35px" height="35px" alt="profilresim" />';
						  ?></span>
                        <span>
                          <span><?php echo "<b>".$bilgi['kuladi']."</b>"; }
						  } ?></span>
                          <span class="time"><?php echo $satir['tarih'];?></span>
                        </span>
                        <span class="message">
                         <?php echo $satir['konu'];  }  ?>
                        </span>
                      </a>
					  
                    </li>
                    <li>
                      <div class="text-center">
                        <a href="mesaj.php">
                          <strong>Tümünü Gör</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
<?php } ?>