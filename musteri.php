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
        <div class="right_col" role="main">
            <?php

$resim = new resim();
$vt = new veritabani();
?>
    <div class="row">
        <div class="col-md-12">
            <a href="" class="btn btn-block btn-success" data-toggle="modal" data-target="#yenimusteri"> Yeni Müşteri Ekle </a>
        </div>
    </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                    <ul class="pagination pagination-split">
                                        <?php
                                        for($harf="a";$harf<="z";$harf++)
                                        {

                                            echo '<li><a href="?harfsorgu='.$harf.'">'.strtoupper($harf).'</a></li>';
                                            //echo $harf;
                                            if($harf=="z")
                                            {
                                                break;
                                            }

                                        }
                                        ?>
                                    </ul>
                                </div>

                                <div class="clearfix"></div>

                                <?php
                                $harfim = isset($_GET['harfsorgu']) ? $_GET['harfsorgu'] : "a";
                               $sorgu = $vt->listele("musteri","WHERE firmadi like '".$harfim."%'");
                            if($sorgu != null) foreach( $sorgu as $satir ) {
                                ?>
                                <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                                    <div class="well profile_view">
                                        <div class="col-sm-12">
                                            <h4 class="brief"><center><strong><?php echo strtoupper($satir['firmadi']); ?></strong></center></h4>
                                            <div class="left col-xs-7">
                                                <h2><?php echo $satir['sahibi']; ?></h2>
                                                <p><strong>Faliyet Alanı: </strong> <?php echo $satir['falani']; ?> </p>
                                                <ul class="list-unstyled">
                                                    <li><i class="fa fa-building"></i><strong> Adres: </strong> <p> <?php echo $satir['adres']; ?></p> </li>
                                                    <li><i class="fa fa-phone"></i> <strong> Telefon: </strong><p><?php echo $satir['tel']; ?> </p></li>
                                                </ul>
                                            </div>
                                            <div class="right col-xs-5 text-center">
                                                <img src="<?php echo $satir['resim']; ?>" alt="" class="img-circle img-responsive"> <?// Logo?>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 bottom text-center">
                                            <div class="col-xs-12 col-sm-6 emphasis">

                                            </div>
                                            <div class="col-xs-12 col-sm-6 emphasis">
                                                <a href="?sil=<?php echo $satir['ID']; ?>" class="btn btn-danger btn-xs" title="Sil"> <i class="fa fa-user">
                                                    </i> <i class="fa fa-eraser"> </i> </a>
                                                <a href="?goster=<?php echo $satir['ID']; ?>" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-user"> </i> Profil
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

		</div>
    <div class="modal fade" id="yenimusteri" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <center><i class="fa  fa-users" aria-hidden="true"></i> Yeni Müşteri Ekle</center> </h4>
                </div>
                <div class="modal-body">

                    <form name="pbaslat" method="POST" action="" id="demo-form2" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Firma Adı <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="firma" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Sahibi <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="sahip" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Faliyet Alanı <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="faliyet" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Telefon <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="tel" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Adres <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="adres" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Firma Logo <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="file" required="required" name="resim" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12  col-md-offset-2">
                                <center> <input type="submit" name="ekle"  value="EKLE" class="btn btn-block btn-success"> </center>
                            </div>
                        </div>
                    </form>

                    <?php
                    if(@$_POST['ekle'])
                    {
                        $logo = @$_FILES["resim"];//resim çekme.
                        $logom = $resim->upload($logo,"firmalar/");
                        $sonuc = $vt->ekle("musteri",array("firmadi"=>$_POST['firma'],"sahibi"=>$_POST['sahip'], "falani"=>$_POST['faliyet'],"tel"=>$_POST['tel'],"adres"=>$_POST['adres'],"resim"=>$logom));
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
<!-- Ekleme Modal End -->
<?php
include('footer.php');
}
?>