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
<!-- Proje Sayfası İçerik Başla -->
<div class="right_col" role="main">
<div class="row">
    <a href="" class="btn btn-success" data-toggle="modal" data-target="#yeniproje">  Yeni Proje Başlat</a>
</div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Projeler</h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <p>Tüm projeleri buradan görüntüleyebilirsiniz.</p>

            <!-- start project list -->
            <table class="table table-striped projects">
                <thead>
                <tr>
                    <th style="width: 1%">ID</th>
                    <th style="width: 20%">Proje İsmi</th>
                    <th>Ekip</th>
                    <th>Tamamlanan</th>
                    <th>Durum</th>
                    <th style="width: 20%">  </th>
                </tr>
                </thead>
                <?php
                include_once("selfyazilim.php");
                $vt = new veritabani();
                $projesorgu = $vt->listele("proje","ORDER BY ID DESC");
                if($projesorgu != null) foreach( $projesorgu as $bilgi ) {
                    ?>
                    <tbody>
                    <tr>
                        <td><?php echo $bilgi['ID']; ?></td>
                        <td>
                            <a><?php echo $bilgi['projeadi']; ?></a>
                            <br />
                            <small><?php $tarih = explode(" ",$bilgi['kayittarih']); echo $tarih[0]; ?> Tarihinde Oluşturuldu</small>
                        </td>
                        <td>
                            <ul class="list-inline">
                                <?php
                                $ekipsorgu = $vt->listele("proje_ekip","WHERE projeID=".$bilgi['ID']."");
                                if($ekipsorgu != null) foreach( $ekipsorgu as $ekip ) {

                                    $kullanici = $vt->listele("kullanici","WHERE id=".$ekip['kul_ID']."");
                                    if($kullanici != null) foreach( $kullanici as $kul ) {
                                        if(@$ekip['sef']!=1)
                                        {
                                            echo '<li>
                                            <img src="'.$kul['resim'].'" class="avatar" alt="Avatar" title="'.$kul['kuladi'].'">
                                          </li>';
                                        }
                                        else {
                                            echo '<li>
                                            <img src="' . $kul['resim'] . '" class="avatar" style="border-color:green;" alt="Avatar" title="Proje Şefi - ' . $kul['kuladi'] . '">
                                          </li>';
                                        }

                                    }

                                }
                                ?>
                            </ul>
                        </td>
                        <?php
                        $durumsorgu = $vt->listele("proje_durum","WHERE projeID=".$bilgi['ID']."");
                        if($durumsorgu != null) foreach( $durumsorgu as $drm ) {


                            ?>
                            <td class="project_progress">
                                <div style="text-align: left">
                                    <span class="badge bg-green" style="width: <?php echo $drm['arge']; ?>%;"><?php echo $drm['arge']; ?>% </span>
                                </div>
                            </td>
                            <td>
                                <?php
                                if($drm['arge']==100)
                                {
                                    echo '<button type="button" class="btn btn-success btn-xs">Tamamlandı</button>';
                                }
                                else if ($drm['arge']==0)
                                {
                                    echo '<button type="button" class="btn btn-danger btn-xs">Sorun Var!</button>';
                                }
                                else if($drm['arge']>0 && $drm['arge']<100)
                                {
                                    echo '<button type="button" class="btn btn-info btn-xs">Devam Ediyor</button>';
                                }
                                else
                                {
                                    echo "Durum Bilgisi Atanmadı.";
                                }

                                ?>
                            </td>
                        <?php }
                        ?>
                        <td>
                            <a href="proje_detay.php?id=<?php echo $bilgi['ID']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Detay </a>
                            <a href="proje_detay.php?id=<?php echo $bilgi['ID']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Düzenle </a>
                            <a href="?sil=<?php echo $bilgi['ID']; ?>" class="btn btn-danger btn-xs" ><i class="fa fa-trash-o"></i> Sil </a>
                        </td>
                    </tr>
                    </tbody>
                <?php } ?>
            </table>
            <!-- end project list -->
            <?php
            if(@$_GET['sil'])
            {
                $sonuc = $vt->sil("proje","ID=".$_GET['sil']);
                $sonuc1 = $vt->sil("proje_butce","projeID=".$_GET['sil']);
                $sonuc2 = $vt->sil("proje_dosya","projeID=".$_GET['sil']);
                $sonuc3 = $vt->sil("proje_durum","projeID=".$_GET['sil']);
                $sonuc4 = $vt->sil("proje_ekip","projeID=".$_GET['sil']);
                $sonuc5 = $vt->sil("proje_gorus","projeID=".$_GET['sil']);
                echo "<script> alert('Silme İşlemi Başarılı.'); </script>";
            }
            ?>
        </div>
    </div>
</div>
<!-- Proje Sayfası İçerik Bitiş -->
    <div class="modal fade" id="yeniproje" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <center><i class="fa fa-terminal" aria-hidden="true"></i> Proje Başlat</center> </h4>
                </div>
                <div class="modal-body">

                    <form name="pbaslat" method="POST" action="" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Proje İsmi <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="pad" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Proje Detayı <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="pdetay" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Proje Fiyatı  <span class="required">(₺)</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="pfiyat" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Proje Ekibi  <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $yetkilisorgu = $vt->listele("kullanici");
                                if($yetkilisorgu != null) foreach( $yetkilisorgu as $yet ) {
                                    echo  '<input type="checkbox" name="ekip[]" value="'.$yet['id'].'">  '.strtoupper($yet['kuladi']).'<br>';
                                }
                                ?>
                                <p>* Proje Şefini Yetkili Alanında Seçiniz, Şef için tekrar buradan seçim yapmayınız.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Teslim Tarihi <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="date" name="ptes" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Yetkili</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="pyet"  required="required" class="form-control">
                                    <option disabled="disabled" onfocus="true"> Lütfen Yetkili Seçiniz...</option>
                                    <?php
                                    $yetkilisorgu = $vt->listele("kullanici");
                                if($yetkilisorgu != null) foreach( $yetkilisorgu as $yet ) {
                                    echo  '<option value="'.$yet['id'].'"> '.strtoupper($yet['kuladi']).'</option>';
                                }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Firma</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="pfirma"  required="required" class="form-control">
                                    <option disabled="disabled" onfocus="true"> Lütfen Firma Seçiniz...</option>
                                    <?php
                                    $firmasorgu = $vt->listele("musteri");
                                    if($firmasorgu != null) foreach( $firmasorgu as $fr ) {
                                        echo  '<option value="'.$fr['ID'].'"> '.strtoupper($fr['firmadi']).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
                                <center>
                                <button class="btn btn-primary" type="reset"> Vazgeç </button>
                                <button type="submit" name="baslat" class="btn btn-success">Başlat</button>
                                </center>
                            </div>
                        </div>

                    </form>
                    <?php
                    if(isset($_POST['baslat'])) {
                        if(empty($_POST['pad']) && empty($_POST['pfiyat']) && empty($_POST['pdetay']) && empty($_POST['pyet']) && empty($_POST['pfirma']) && empty($_POST['ptes'])  ) {



                        }
                        else
                        {
                            $sonuc = $vt->ekle("proje",array("projeadi"=>$_POST['pad'],"projedetayi"=>$_POST['pdetay'],"yetkili"=>$_POST['pyet'],"firma"=>$_POST['pfirma'],"teslimtarih"=>$_POST['ptes']));
                           // echo $sonuc;
                            $sonucdurum = $vt->ekle("proje_durum",array("projeID"=>$sonuc,"arge"=>1,"kul_id"=>$_POST['pyet']));

                            $sonucbutce = $vt->ekle("proje_butce",array("projeID"=>$sonuc,"ucret"=>$_POST['pfiyat'],"kalanucret"=>$_POST['pfiyat']));

                            $sonucekip = $vt->ekle("proje_ekip",array("projeID"=>$sonuc,"kul_ID"=>$_POST['pyet'],"sef"=>1));
                            foreach($_POST['ekip'] as $ekip) {
                                $sonucekip1 = $vt->ekle("proje_ekip",array("projeID"=>$sonuc,"kul_ID"=>$ekip,"sef"=>0));
                            }
                            header( 'refresh: 0; url=' );
                        }

                    }
                    ?>

                </div>
            </div>
        </div>
        </div>


<?php
include('footer.php');
}
?>