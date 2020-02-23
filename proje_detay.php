<?php 
ob_start();
session_start();
if(empty($_SESSION['yetki']))
{
	 header('Location: index.php');
}
else
{
if (isset($_SESSION['yetki'])) {
    if ($_SESSION['yetki'] == 1 || $_SESSION['yetki'] == 2 ) {
		include 'header.php';
    }
} else {
    header('Location: index.php');
    exit();
}
?>
    <!-- Proje Detay Başlnagıc -->
    <?php
    $_SESSION['DetayID'] = @$_GET['id'];
    if (isset($_SESSION['DetayID'])) {
        include_once("selfyazilim.php");
        $vt = new veritabani();
        $projesorgu = $vt->listele("proje","WHERE ID=".$_SESSION['DetayID']."");
        if($projesorgu != null) foreach( $projesorgu as $bilgi ) {


            ?>
            <!-- page content -->
            <div class="right_col" role="main">
            <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Proje Detay
                        <small></small>
                    </h3>
                </div>


            </div>

            <div class="clearfix"></div>

            <div class="row">
            <div class="col-md-12">
            <div class="x_panel">
            <div class="x_title">
                <h2> <?php echo $bilgi['projeadi']; ?> </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                    </li>
                    <li class="dropdown">
                    </li>
                    <li>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

            <div class="col-md-9 col-sm-9 col-xs-12">
            <?php
            $butcesorgu = $vt->listele("proje_butce", "WHERE projeID=" . $bilgi['ID'] . "");
            if ($butcesorgu != null) foreach ($butcesorgu as $butce) {

                ?>
                <ul class="stats-overview">
                    <li>
                        <span class="name"> Proje Fiyatı </span>
                        <span class="value text-info"> <?php echo $butce['ucret']; ?> </span>
                    </li>
                    <li>
                        <span class="name"> Alınan Ücret </span>
                        <span class="value text-success"> <?php echo $butce['alinanucret']; ?>  </span>
                    </li>
                    <li class="hidden-phone">
                        <span class="name"> Kalan Ücret </span>
                        <span class="value text-danger"> <?php echo $butce['kalanucret']; ?>  </span>
                    </li>
                </ul>
                <br/>
                <?php
            }
            ?>
            <div id="mainb" style="height:350px;"></div>

            <div>

            <h4>Proje Hakkında Görüşler</h4>
                <?php
                $sorgum = $vt->listele("proje_gorus","WHERE projeID=".$bilgi['ID']."");
               $kayitsayisi = $sorgum->rowCount();
                $lim = 3;
                $ofset = isset($_POST['syf']) ? $_POST['syf'] : 0;
                $gorussorgu = $vt->listele("proje_gorus", "WHERE projeID=" . $bilgi['ID'] . " ORDER BY ID DESC LIMIT ".$lim." OFFSET ".$ofset."");
                if ($gorussorgu != null) foreach ($gorussorgu as $gorus) {

                        ?>
                        <!-- end of user messages -->
                        <ul class="messages">
                            <li>
                                <?php
                                $kulsorgu = $vt->listele("kullanici", "WHERE id=" . $gorus['goruskul_ID'] . "");
                                if ($kulsorgu != null) foreach ($kulsorgu as $kul) {

                                    echo '<img src="' . $kul['resim'] . '" class="avatar" alt="' . $kul['kuladi'] . '">';
                                }
                                ?>

                                <div class="message_date">
                                    <?php $gorus['tarih'] = explode(" ", $gorus['tarih']);
                                    $tarih = explode("-", $gorus['tarih'][0]);
                                    $gun = $tarih[2];
                                    $ay = $tarih[1];
                                    $yil = $tarih[0];
                                    ?>
                                    <h3 class="date text-info"><?php echo $gun; ?></h3>
                                    <p class="month"><?php
                                        switch ($ay) {
                                            case 01:
                                                echo "Ocak";
                                                break;
                                            case 02:
                                                echo "Şubat";
                                                break;
                                            case 03:
                                                echo "Mart";
                                                break;
                                            case 04:
                                                echo "Nisan";
                                                break;
                                            case 05:
                                                echo "Mayıs";
                                                break;
                                            case 06:
                                                echo "Haziran";
                                                break;
                                            case 07:
                                                echo "Temmuz";
                                                break;
                                            case '08':
                                                echo "Ağustos";
                                                break;
                                            case '09':
                                                echo "Eylül";
                                                break;
                                            case 10:
                                                echo "Ekim";
                                                break;
                                            case 11:
                                                echo "Kasım";
                                                break;
                                            case 12:
                                                echo "Aralık";
                                                break;
                                            default:
                                                echo "System Error: Not found mounth.";
                                        }
                                        echo "<br>";
                                        echo "<small>" . $yil . "</small>";
                                        ?></p>
                                </div>
                                <div class="message_wrapper">
                                    <h4 class="heading"><?php
                                        $kulsorgu = $vt->listele("kullanici", "WHERE id=" . $gorus['goruskul_ID'] . "");
                                        if ($kulsorgu != null) foreach ($kulsorgu as $kul) {

                                            echo strtoupper($kul['kuladi']);
                                        }
                                        ?></h4>
                                    <p class="title"> <?php echo $gorus['konu']; ?> </p>
                                    <blockquote class="message">
                                        <?php echo $gorus['detay']; ?>
                                    </blockquote>
                                    <br/>
                                    <!-- <p class="url">
                                      <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                         <a href="#"><i class="fa fa-paperclip"></i> User Acceptance
                                             Test.doc </a>
                                     </p> -->
                                </div>
                            </li>
                        </ul>
                        <!-- end of user messages -->

                        <?php

                }
                if(($gorussorgu->rowCount())>0)
                {
                    echo "";
                }
                else
                {
                    echo "<h3><center><span style='color: red' class='glyphicon glyphicon-ban-circle'></span> Bu Proje Hakkında Kimse Görüş Belirtmemiş</center></h3>";
                }
            ?>

                                        </div>

                <?php
                if ($kayitsayisi > $lim) {

                    echo '<form name="sayfalama" action="" method="POST">';
                    echo '<center><nav aria-label="Page navigation">
  <ul class="pagination">
    ';
                    $x = 0;
                    echo '<li><button class="pagination" name="syf" value="'.$x.'"> <span class="glyphicon glyphicon-backward"></span> </button></li>';
                    for ($i = 0; $i < $kayitsayisi; $i += $lim) {
                        $x++;
                        echo '<li><button class="pagination" name="syf"  value="'.$i.'">'.$x.'</button></li>';
                    }
                    echo '<li><button class="pagination" name="syf" value="'.($i-$lim).'"> <span class="glyphicon glyphicon-forward"></span> </button></li>';
                    echo '</ul>
                          </nav>
                          </center>
                          </form>';

                }
                ?>

                                    </div>

                                    <!-- start project-detail sidebar -->
                                    <div class="col-md-3 col-sm-3 col-xs-12">

                                        <section class="panel">

                                            <div class="x_title">
                                                <h2>Proje Hakkında</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="panel-body">
                                                <h3 class="green"><center><i class="fa fa-paint-brush"></i> <?php $_SESSION['projeadi']=$bilgi['projeadi']; echo $bilgi['projeadi']; ?> </center></h3>

                                                <p><?php echo $bilgi['projedetayi']; ?> </p>
                                                <br/>

                                                <div class="project_detail">

                                                    <p class="title">Firma</p>
                                                    <p>
                                                        <?php
                                                        $firmasorgu = $vt->listele("musteri");
                                                        if($firmasorgu != null) foreach( $firmasorgu as $fr ) {
                                                            if( $bilgi['firma']==$fr['ID'])
                                                            {
                                                                echo strtoupper($fr['firmadi']);
                                                            }

                                                        }
                                                        ?></p>
                                                    <p class="title">Yetkili Kişi</p>
                                                    <p>
                                                        <?php
                                                        $yetkilisorgu = $vt->listele("kullanici");
                                                        if($yetkilisorgu != null) foreach( $yetkilisorgu as $yet ) {
                                                            if($bilgi['yetkili']==$yet['id'])
                                                            {
                                                               echo strtoupper($yet['kuladi']);
                                                            }
                                                        }
                                                        ?></p>
                                                    <p class="title">Başlama Tarihi</p>
                                                    <p><?php $bilgi['kayittarih'] = explode(" ",$bilgi['kayittarih']); echo strtoupper($bilgi['kayittarih'][0]); ?></p>
                                                    <p class="title">Teslim Tarihi</p>
                                                    <p><?php $bilgi['teslimtarih'] = explode(" ",$bilgi['teslimtarih']); echo strtoupper($bilgi['teslimtarih'][0]); ?></p>
                                                    <p class="title">İletişim Bilgileri</p>
                                                    <p>
                                                        <?php
                                                        $firmasorgu = $vt->listele("musteri");
                                                        if($firmasorgu != null) foreach( $firmasorgu as $fr ) {
                                                            if( $bilgi['firma']==$fr['ID'])

                                                            {
                                                                $_SESSION['musterid']=$fr['ID'];

                                                                echo "Tel :".$fr['tel']."<br>Adres : ".$fr['adres']."<br>";

                                                            }

                                                        }
                                                        ?>
                                                    </p>
                                                </div>

                                                <br/>
                                                <h5 class="title">Proje Dosyaları</h5>
                                                <ul class="list-unstyled project_files">
                                                    <?php
                                                    $dosyasorgu = $vt->listele("proje_dosya","WHERE projeID=".$bilgi['ID']);
                                                    if($dosyasorgu != null) foreach( $dosyasorgu as $dsy ) {

                                                        echo '<li><a href="'.$dsy['dosyayolu'].'"><i class="fa fa-file"></i>
                                                               '.$dsy['dosyaadi'].'</a>
                                                                </li>';

                                                    }
                                                    if($dosyasorgu->rowCount()>0)
                                                    {
                                                    echo "";
                                                    }
                                                    else
                                                    {
                                                        echo "<div class=\"alert alert-warning\" role=\"alert\">Dosya Eki Bulunmuyor.</div>";
                                                    }
                                                    ?>
                                                </ul>
                                                <br/>

                                                <div class="text-center mtop20">
                                                    <a href="#" class="btn btn-md btn-primary" data-toggle="modal" data-target="#duzenlemodal">Detay Düzenle</a>
                                                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#dosyamodal">Dosya Ekle</a>
                                                    <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#gorusmodal">Görüş Ekle</a>
                                                    <a href="#" class="btn btn-md btn-success" data-toggle="modal" data-target="#odememodal">Ödeme Al</a>
                                                </div>
                                            </div>

                                        </section>

                                    </div>
                                    <!-- end project-detail sidebar -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
            <?php
        }
    }
    else
    {
        echo "burada";
        //header("location:proje.php");
    }
        ?>

    <!-- Proje Detay Bitiş -->


    <!-- Detay Düzenle Modal -->

    <!-- Modal -->
    <div class="modal fade" id="duzenlemodal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><center> Proje Detay Düzenle </center></h4>
                </div>
                <div class="modal-body">

                    <form action="" method="post" name="duzenle">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Proje Durumu <span class="required">%</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $argesorgu = $vt->listele("proje_durum","WHERE projeID=".$bilgi['ID']);
                                if($argesorgu != null) foreach( $argesorgu as $arge ) {

                                    echo '<input type="number" name="argem" min="0" max="100" value="'.$arge['arge'].'" required="required" class="form-control col-md-7 col-xs-12">';
                                }
                                ?>

                            </div>
                        </div><br>
                        <div class="ln_solid"></div>

                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <center>
                               <button type="submit" name="argegun" class="btn btn-dark"> Güncelle </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                              </center>
                            </div>
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['argegun']))
                    {

                        $guncelle = $vt->guncelle("proje_durum",array("arge"=>$_POST['argem']),"projeID = ".$bilgi['ID']);

                    }
                    ?>
                </div>
                <div class="modal-footer">

                </div>
            </div>

        </div>
    </div>

    <!-- Detay Düzenle Modal Bitiş -->

    <!-- Detay Dosya Modal -->

    <!-- Modal -->
    <div class="modal fade" id="dosyamodal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><center> Proje Dosya Ekleme </center></h4>
                </div>
                <div class="modal-body">

                    <form action="" method="post" name="gorus">

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Görüş Modal -->

    <!-- Modal -->
    <div class="modal fade" id="gorusmodal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><center> Proje Görüş Ekle </center></h4>
                </div>
                <div class="modal-body">

                    <form action="" method="post" name="dosya" class="form-horizontal form-label-left">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Konu <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="konu" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Detay <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="detay" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="submit" name="gonder" value="Görüş Ekle"  class="btn btn-block btn-primary col-md-7 col-xs-12">
                            </div>
                        </div>
                    </form>
                    <?php
                    if(@$_POST['gonder'])
                    {
                        $projem = $_GET['id'];
                        $kullanici = $_SESSION['kid'];
                        $konu = $_POST['konu'];
                        $detay = $_POST['detay'];
                        $sonucdurum = $vt->ekle("proje_gorus",array("projeID"=>$projem,"goruskul_ID"=>$kullanici,"konu"=>$konu,"detay"=>$detay));
                        if($sonucdurum>0)
                            echo '<script> alert("Görüş Eklendi."); </script>';
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Görüş Modal -->

    <!-- Ödeme Al -->
    <div class="modal fade" id="odememodal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><center> Proje Görüş Ekle </center></h4>
                </div>
                <div class="modal-body">

                    <form action="" method="post" name="dosya" class="form-horizontal form-label-left">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Alınan Tutar <span class="required">₺</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="odemetutar" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="submit" name="odemeal" value="Ödeme Al"  class="btn btn-block btn-primary col-md-7 col-xs-12">
                            </div>
                        </div>
                    </form>

                    <?php
                    if(@$_POST['odemeal'])
                    {
                        $projem = $_GET['id'];
                        $yenitutar= $_POST['odemetutar'];
                        /// Verileri Al ///
                        $butcesorgu = $vt->listele("proje_butce","WHERE projeID=".$projem);
                        if($butcesorgu != null) foreach( $butcesorgu as $butce ) {
                            $toplamucret = $butce['ucret'];
                            $alinanucret = $butce['alinanucret'];
                            $kalanucret = $butce['kalanucret'];

                        }
                        $alinanucret = $alinanucret + $yenitutar;
                        $kalanucret = $toplamucret - $alinanucret;

                        $guncelle = $vt->guncelle("proje_butce",array("alinanucret"=>$alinanucret,"kalanucret"=>$kalanucret),"projeID = ".$projem);

                        if($yenitutar>0)
                        {
                            $sonuc = $vt->ekle("gelir",array("musteriID"=>$_SESSION['musterid'],"tutar"=>$yenitutar,"aciklama"=>"<b>".$_SESSION['projeadi']."</b> Projesi İçin Ödeme."));
                        }
                        else
                        {
                            $tutarlar = explode("-",$yenitutar);
                            $sonuc = $vt->ekle("gider",array("musteriID"=>$_SESSION['musterid'],"tutar"=>$tutarlar[1],"perID"=>$_SESSION['kid'],"aciklama"=>"<b>".$_SESSION['projeadi']."</b> Projesi İçin Geri Ödeme."));
                        }

                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Ödeme Al Bitiş-->

    <!-- Detay Dosya Modal Bitiş -->

<?php
include('footer.php');
}
?>