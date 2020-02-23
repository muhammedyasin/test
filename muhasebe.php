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
    ?>
    <div class="right_col" role="main">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <a class="btn btn-success" href="" data-toggle="modal" data-target="#gelirmodal"> Gelir Kayıdı Oluştur </a>
        </div> <div class="col-md-4 col-sm-4 col-xs-12">

        </div> <div class="col-md-4 col-sm-4 col-xs-12">
            <a class="btn btn-danger" href="" data-toggle="modal" data-target="#gidermodal"> Gider Kayıdı Oluştur </a>
        </div>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">
                    <div class="x_title">
                        <h2> Gelir <small>  </small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><?php echo date('d.m.Y H:i:s'); ?></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Müşteri/Firma</th>
                                <th>Açıklama</th>
                                <th>Tutar</th>
                                <th>Tarih</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sorgum = $vt->listele("gelir");
                            if($sorgum != null) foreach( $sorgum as $satir ) {
                                ?>
                                <tr>
                                    <td><?php
                                        $firmasorgu = $vt->listele("musteri");
                                        if($firmasorgu != null) foreach( $firmasorgu as $fr ) {
                                            if($fr['ID']==$satir['musteriID'])
                                            {
                                                echo $fr['firmadi'];
                                            }
                                        }
                                        ?></td>
                                    <td><?php echo $satir['aciklama']; ?></td>
                                    <td><?php echo $satir['tutar']; ?>₺</td>
                                    <td><?php echo $satir['tarih']; ?></td>
                                </tr>
                                <?php
                            }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">
                    <div class="x_title">
                        <center> <h2> Gider <small> </small></h2></center>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><?php echo date('d.m.Y H:i:s'); ?></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Müşteri/Firma</th>
                                <th>Açıklama</th>
                                <th>Tutar</th>
                                <th>Personel</th>
                                <th>Tarih</th>
                            </tr>
                            </thead>


                            <tbody>
                            <?php
                            $sorgum = $vt->listele("gider");
                            if($sorgum != null) foreach( $sorgum as $satir ) {
                                ?>
                                <tr>
                                    <td><?php
                                        $firmasorgu = $vt->listele("musteri");
                                        if($firmasorgu != null) foreach( $firmasorgu as $fr ) {
                                            if($fr['ID']==$satir['musteriID'])
                                            {
                                                echo $fr['firmadi'];
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $satir['aciklama']; ?></td>
                                    <td><?php echo $satir['tutar']; ?>₺</td>
                                    <td>
                                    <?php
                                        $yetkilisorgu = $vt->listele("kullanici");
                                        if($yetkilisorgu != null) foreach( $yetkilisorgu as $yet ) {
                                            if($yet['id']==$satir['perID'])
                                            {
                                                echo $yet['kuladi'];
                                            }
                                        }
                                        ?></td>
                                    <td><?php echo $satir['tarih']; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-4 col-sm-4 col-xs-12"></div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <?php
            $gdrtoplam = 0; $glrtoplam=0; $kar=0; $zarar=0;
            $sorgugider = $vt->ozellistele("SELECT SUM(tutar) AS toplamgider FROM gider");
            if($sorgugider != null) foreach( $sorgugider as $gdr ) {
            $gdrtoplam = $gdr['toplamgider'];
            }
            $sorgugelir = $vt->ozellistele("SELECT SUM(tutar) AS toplamgelir FROM gelir");
            if($sorgugelir != null) foreach( $sorgugelir as $glr ) {
                $glrtoplam = $glr['toplamgelir'];
            }

            $degson = $glrtoplam - $gdrtoplam;

            ?>
            <button class="btn btn-success col-lg-10" type="button">
                Toplam Gelir <span class="badge"><?php echo $glrtoplam; ?> ₺</span>
            </button>
            <button class="btn btn-danger col-lg-10" type="button">
                Toplam Gider <span class="badge"><?php echo $gdrtoplam; ?> ₺</span>
            </button><center>
            <?php
            if($degson>0)
            {
                $kar = $degson;
                echo '<button class="btn btn-info col-lg-10" type="button">
                Kâr <span class="badge">'. $kar .' ₺</span>
            </button>';
            }
            else if($degson<0)
            {
                $zarar = $degson;
                echo '<button class="btn btn-warning col-lg-10" type="button">
                Zarar <span class="badge">'. $zarar .' ₺</span>
            </button>';
            }
            else
            {
                $karzarar = "Herhangi Bir Kâr veya Zarar Bulunmuyor.";
                echo '<button class="btn btn-primary col-lg-10" type="button">
                 <span class="badge">'. $karzarar .' </span>
            </button>';
            }
            ?></center>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12"></div>
    </div>
    </div>
    <!--  Modallar -->


    !-- Proje Sayfası İçerik Bitiş -->
    <div class="modal fade" id="gelirmodal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <center><i class="fa fa-terminal" aria-hidden="true"></i> Gelir </center> </h4>
                </div>
                <div class="modal-body">

                    <form name="gelir" method="POST" action="" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Tutar  <span class="required">(₺)</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="tutar" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Açıklama <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="aciklama" class="form-control col-md-7 col-xs-12">Açıklama</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Müşteri</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="musteri"  required="required" class="form-control">
                                    <option disabled="disabled" onfocus="true"> Lütfen Müşteri Seçiniz...</option>
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
                                    <button type="submit" name="gelir" class="btn btn-success">Gelir Ekle</button>
                                </center>
                            </div>
                        </div>

                    </form>
                    <?php
                    if(isset($_POST['gelir'])) {
                        if(empty($_POST['tutar']) && empty($_POST['aciklama']) && empty($_POST['musteri'])) {



                        }
                        else
                        {
                            $sonuc = $vt->ekle("gelir",array("musteriID"=>$_POST['musteri'],"tutar"=>$_POST['tutar'],"aciklama"=>$_POST['aciklama']));
                            if ($sonuc)
                            {
                                echo "<script> alert('Gelir Girişi Yapıldı.')</script>";
                            }

                        }

                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    </div>


    !-- Proje Sayfası İçerik Bitiş -->
    <div class="modal fade" id="gidermodal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <center><i class="fa fa-terminal" aria-hidden="true"></i> Gider </center> </h4>
                </div>
                <div class="modal-body">

                    <form name="gelir" method="POST" action="" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Tutar  <span class="required">(₺)</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="tutar" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Açıklama <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="aciklama" class="form-control col-md-7 col-xs-12"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Müşteri</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="musteri"  required="required" class="form-control">
                                    <option disabled="disabled" onfocus="true"> Lütfen Müşteri Seçiniz...</option>
                                    <?php
                                    $firmasorgu = $vt->listele("musteri");
                                    if($firmasorgu != null) foreach( $firmasorgu as $fr ) {
                                        echo  '<option value="'.$fr['ID'].'"> '.strtoupper($fr['firmadi']).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Personel</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="personel"  required="required" class="form-control">
                                    <option disabled="disabled" onfocus="true"> Lütfen Personel Seçiniz...</option>
                                    <?php
                                    $yetkilisorgu = $vt->listele("kullanici");
                                    if($yetkilisorgu != null) foreach( $yetkilisorgu as $yet ) {
                                        echo  '<option value="'.$yet['id'].'"> '.strtoupper($yet['kuladi']).'</option>';
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
                                    <button type="submit" name="gider" class="btn btn-danger">Gider Ekle</button>
                                </center>
                            </div>
                        </div>

                    </form>
                    <?php
                    if(isset($_POST['gider'])) {
                        if(empty($_POST['tutar']) && empty($_POST['aciklama']) && empty($_POST['musteri'])&& empty($_POST['personel'])) {



                        }
                        else
                        {
                            $sonuc = $vt->ekle("gider",array("musteriID"=>$_POST['musteri'],"tutar"=>$_POST['tutar'],"aciklama"=>$_POST['aciklama'],"perID"=>$_POST['personel']));
                            if ($sonuc)
                            {
                                echo "<script> alert('Gider Girişi Yapıldı.')</script>";
                            }

                        }

                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    </div>


    <?php
include('footer.php');
}
?>