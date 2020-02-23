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
<!-- page content -->
<?php
    include_once("selfyazilim.php");
    $vt = new veritabani();
    $kulID = isset($_GET['id']) ? $_GET['id'] : $_SESSION['kid'];
    ?>
    <div class="right_col" role="main">
<center> <?php
    $kulsorgu = $vt->listele("kullanici","WHERE id=".$kulID."");
    if($kulsorgu != null) foreach( $kulsorgu as $bilgi ) {
        ?>
        <h1 style="text-shadow: #0f0f0f; color: #0D3349;"> <?php echo $bilgi['kuladi']; ?> </h1> </center>
                <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                            <div class="profile_img">
                                <div id="crop-avatar">
                                    <!-- Current avatar -->
                                    <img class="img-responsive avatar-view" src="<?php echo $bilgi['resim']; ?> " alt="Avatar" title="Change the avatar">
                                </div>
                                <h3> <?php echo $bilgi['kuladi']; ?>  </h3>

                                <ul class="list-unstyled user_data">
                                    <li><i class="fa fa-map-marker user-profile-icon"></i>

                                        <?php
                                        $hakkindasorgu = $vt->listele("kullanici_hakkinda","WHERE kul_id=".$kulID."");
                                        if($hakkindasorgu != null) foreach( $hakkindasorgu as $hak ) {

                                            echo $hak['il']." , ".$hak['ilce'];
                                            $eposta = $hak['eposta'];
                                        }
                                        ?>

                                    </li>

                                    <li>
                                        <i class="fa fa-briefcase user-profile-icon"></i> <?php echo $bilgi['vasif']; ?>
                                    </li>

                                    <li class="m-top-xs">
                                        <i class="fa fa-envelope-open user-profile-icon"></i>
                                        <a style="font-size: smaller" href="mailto:<?php if(isset($eposta)) { echo $eposta; } else {  echo "info@selfyazilim.net"; } ?>" target="_blank"><?php if(isset($eposta)) { echo $eposta; } else {  echo "info@selfyazilim.net"; } ?></a>
                                    </li>
                                </ul>

                                <?php
                                if(isset($_GET['id']))
                                {

                                }
                                else
                                {
                                    echo "<a class=\"btn btn-success\"><i class=\"fa fa-edit m-right-xs\"></i>Düzenle</a>";
                                }
                                ?>
                                <br />

                                <!-- start skills -->
                                <h4><b> Beceriler </b></h4>
                                <ul class="list-unstyled user_data">
                                    <?php
                                    $becerisorgu = $vt->listele("kullanici_beceri","WHERE kul_id=".$kulID."");
                                    $kayit = $becerisorgu->rowcount();
                                    if($becerisorgu != null) foreach( $becerisorgu as $beceri ) {
                                    ?>
                                    <li>
                                        <p style="color: #0D3349"><?php echo $beceri['beceri_adi']; ?></p>
                                        <span class="badge bg-blue" style="width: <?php echo $beceri['duzey']; ?>%;"><?php echo $beceri['duzey']; ?>% </span>
                                    </li>
                                    <?php }  // Beeri sorgusu bitiş.?>
                                </ul>
                                <?php
                                if(isset($_GET['id']))
                                {

                                }
                                else
                                {
                                    echo "<a class=\"btn btn-info\"><i class=\"fa fa-briefcase m-right-xs\"></i> Beceri Ekle</a>";
                                }
                                ?>
                                <!-- end of skills -->
                    </div>
                            <?php } //Kullanıcı sorgu bitiş. ?>
                        </div>
                    <div class="col-md-9">
                        <div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#hak" aria-controls="home" role="tab" data-toggle="tab">Hakkımda</a></li>
                                <li role="presentation"><a href="#proje" aria-controls="profile" role="tab" data-toggle="tab">Projeler</a></li>
                                <li role="presentation"><a href="#egitim" aria-controls="messages" role="tab" data-toggle="tab">Eğitim</a></li>
                                <li role="presentation"><a href="#ref" aria-controls="settings" role="tab" data-toggle="tab">Referans</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="hak">
                                    <p>  <?php
                                        $hakkindasorgu = $vt->listele("kullanici_hakkinda","WHERE kul_id=".$kulID."");
                                        $sayisi = $hakkindasorgu->rowcount();
                                        if($hakkindasorgu != null) foreach( $hakkindasorgu as $hak ) {

                                            echo $hak['hakkinda']."<br><br><hr>";
                                            echo "<b> Telefon :</b> ".$hak['iletisim']."<br>";
                                            echo "<b> Adres :</b> ".$hak['adres']."<br>";

                                        }
                                        ?>
                                        <?php
                                        if(isset($_GET['id']))
                                        {

                                        }
                                        else
                                        {
                                            if($sayisi==0)
                                            {
                                                echo "<a class=\"btn btn-info\"><i class=\"fa fa-briefcase m-right-xs\"></i> Hakkında Bilgisi Ekle</a>";
                                            }
                                            else
                                            {
                                                echo "<a class=\"btn btn-info\"><i class=\"fa fa-briefcase m-right-xs\"></i> Hakkında Bilgilerini Güncelle</a>";
                                            }

                                        }
                                        ?></p>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="proje">

                                    <!-- start project list -->
                                    <table class="table table-striped projects">
                                        <thead>
                                        <tr>
                                            <th style="width: 20%">Proje İsmi</th>
                                            <th>Şirket</th>
                                            <th>Durum</th>
                                        </tr>
                                        </thead>
                                        <?php
                                         $projekip = $vt->listele("proje_ekip","WHERE kul_ID=".$kulID."");
                                         if($projekip != null) foreach( $projekip as $projem ) {
                                             $projesorgukul = $vt->listele("proje", "WHERE ID=".$projem['projeID']."");
                                             if ($projesorgukul != null) foreach ($projesorgukul as $proje) {
                                                 ?>
                                                 <tbody>
                                                 <tr>
                                                     <td>
                                                         <a><?php echo $proje['projeadi']; ?></a>
                                                         <br/>
                                                         <small><?php $tarih = explode(" ", $proje['kayittarih']);
                                                             echo $tarih[0]; ?> Tarihinde Oluşturuldu
                                                         </small>
                                                     </td>
                                                     <td>
                                                         <?php
                                                 $musterisorgu = $vt->listele("musteri","WHERE ID=".$proje['firma']."");
                                                 if($musterisorgu != null) foreach( $musterisorgu as $mus ) {

                                                            echo $mus['firmadi'];
                                                 }
                                                         ?>
                                                     </td>
                                                     <?php
                                                     $durumsorgu = $vt->listele("proje_durum", "WHERE projeID=" . $proje['ID'] . "");
                                                     if ($durumsorgu != null) foreach ($durumsorgu as $drm) {
                                                         ?>
                                                         <td class="project_progress">
                                                             <div style="text-align: left">
                                                                 <span class="badge bg-green"
                                                                       style="width: <?php echo $drm['arge']; ?>%;"><?php echo $drm['arge']; ?>
                                                                     % </span>
                                                             </div>
                                                         </td>
                                                     <?php }
                                                     ?>
                                                 </tr>
                                                 </tbody>
                                             <?php }
                                         }
                                         ?>
                                    </table>

                                </div>
                                <div role="tabpanel" class="tab-pane" id="egitim">
                                    <table>
                                        <tr>
                                            <th style="width: 28%" > Eğitim </th>
                                            <th style="width: 28%" > Detay </th>
                                            <th style="width: 28%" > Başlama Tarihi </th>
                                            <th style="width: 28%" > Bitiş Tarihi </th>
                                        </tr>
                                        <?php
                                        $egitimsorgu = $vt->listele("kullanici_egitim","WHERE kul_id=".$kulID."");
                                        $ks = $egitimsorgu->rowcount();
                                        if($egitimsorgu != null) foreach( $egitimsorgu as $es ) {
                                            ?>
                                          <tr>
                                            <td><?php echo $es['egitim_adi']; ?></td>
                                            <td><?php echo $es['egitim_hakkinda']; ?></td>
                                            <td><?php $tarih1 = explode(" ",$es['bastarih']); echo $tarih1[0];?> </td>
                                            <td><?php  $tarih2 = explode(" ",$es['bittarih']); echo $tarih2[0]; ?> </td>
                                        </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                    <?php
                                    if(isset($_GET['id']))
                                    {

                                    }
                                    else
                                    {
                                        if($ks==0)
                                        {
                                            echo "<a class=\"btn btn-info\"><i class=\"fa fa-briefcase m-right-xs\"></i> Eğitim Bilgisi Ekle</a>";
                                        }
                                        else
                                        {
                                            echo "<a class=\"btn btn-info\"><i class=\"fa fa-briefcase m-right-xs\"></i> Eğitim Bilgilerini Güncelle</a>";
                                        }

                                    }
                                    ?>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="ref">
                                    <table>
                                        <tr>
                                            <th style="width: 20%" > İsim </th>
                                            <th style="width: 20%" > Telefon </th>
                                            <th style="width: 20%" > Mail </th>
                                            <th style="width: 20%" > Başlama Tarihi </th>
                                            <th style="width: 20%" > Bitiş Tarihi </th>
                                        </tr>
    <?php
    $refsorgu = $vt->listele("kullanici_referans","WHERE kul_id=".$kulID."");
    $refsay = $refsorgu->rowcount();
    if($refsorgu != null) foreach( $refsorgu as $ref ) {
        ?>
                                        <tr>
                                            <td> <?php echo $ref['referans_ismi']; ?> </td>
                                            <td> <?php echo $ref['referans_tel']; ?> </td>
                                            <td> <?php echo $ref['referans_mail']; ?> </td>
                                            <td> <?php $tarih1 = explode(" ",$ref['referans_bastarih']); echo $tarih1[0];?> </td>
                                            <td> <?php  $tarih2 = explode(" ",$ref['referans_bittarih']); echo $tarih2[0]; ?></td>
                                        </tr>
        <?php } ?>
                                    </table>
                                    <?php
                                    if(isset($_GET['id']))
                                    {

                                    }
                                    else
                                    {
                                        if($refsay==0)
                                        {
                                            echo "<a class=\"btn btn-info\"><i class=\"fa fa-briefcase m-right-xs\"></i> Referans Bilgisi Ekle</a>";
                                        }
                                        else
                                        {
                                            echo "<a class=\"btn btn-info\"><i class=\"fa fa-briefcase m-right-xs\"></i> Referans Bilgilerini Güncelle</a>";
                                        }

                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
    </div>

    </div>
<!-- Page Content -->
<?php
include('footer.php');
}
?>