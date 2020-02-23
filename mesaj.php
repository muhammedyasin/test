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
		include ('header.php');
    }
} else {
    header('Location: index.php');
    exit();
}
?>
<style>
.ozel{border:1px dashed silver; border-top:1px dashed silver ; padding-top:10px; padding: 3px;}
.mesaj{border:1px dotted silver; border-top:1px dotted silver ;  padding: 10px;}
</style>
<!-- page content -->
         <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="page-title">
              <div class="title_left">
                <h3>Gelen Kutusu <small><span class="fa fa-envelope-o"></span></small></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Arayacağınız Kelimeyi Yazınız...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Ara!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Gelen Mesajlar<small> Kullanıcı Adını Yazacak Buraya</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Ayar 1</a>
                          </li>
                          <li><a href="#">Ayar 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-sm-3 mail_list_column">
                        <button id="compose" class="btn btn-sm btn-success btn-block" type="button">Yeni Mesaj</button><br>
						<?php 
						include_once("selfyazilim.php");
						$vt = new veritabani();
						$mesajsorgu = $vt->listele("mesajlar","WHERE alici=".$_SESSION['kid']."");
						if($mesajsorgu != null) foreach( $mesajsorgu as $bilgi ) {
							//echo $bilgi['id'];
							echo '<a href="?icerik='.$bilgi['id'].'">
                          <div class="mail_list">
                            <div class="left">
                              <i class="fa fa-circle"></i> <i class="fa fa-edit"></i>
                            </div>
                            <div class="right">
                              <h3>';?> <?php
                            $ic1 = $vt->listele("kullanici","WHERE id=".$bilgi['gon']."");
                            if($ic1 != null) foreach( $ic1 as $icb ) {
                                echo strtoupper($icb['kuladi']);
                            }
                            ?> <?php echo '<small>'.$bilgi['tarih'].'</small></h3>
                              <p>'.$bilgi['konu'].'</p>
                            </div>
                          </div>
                        </a>';
							
						}
						?>
                      </div>
                      <!-- /MAIL LIST -->
					<?php 
					@$geldimesaj=$_GET['icerik'];
					if(@$_GET)
					{
					?>
					<?php 
					$sorgum = $vt->listele("mesajlar","WHERE id=".$geldimesaj."");
						if($sorgum != null) foreach( $sorgum as $bilgi ) {
					?>
                      <!-- CONTENT MAIL -->
                      <div class="col-sm-9 mail_view">
                        <div class="inbox-body">
                          <div class="mail_heading row">
                            <div class="col-md-8">
                              <div class="btn-group">
                                <button id="compose" class="btn btn-sm btn-primary" type="button"><i class="fa fa-reply"></i> Cevapla </button>
                                <button class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title=" "><i class="fa fa-share"></i></button>
                                <button class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Yazdır"><i class="fa fa-print"></i></button>
                                <button class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Sil"><i class="fa fa-trash-o"></i></button>
                              </div>
                            </div>
                            <div class="col-md-4 text-right">
                              <p class="date"> <?php echo $bilgi['tarih']; ?></p>
                            </div>
                            <div class="col-md-12">
                              <h4> <?php echo $bilgi['konu']; ?></h4>
                            </div>
                          </div>
                          <div class="sender-info">
                            <div class="row">
                              <div class="col-md-12">
                             <div class="ozel"> Gön :   <strong><?php
						$ic1 = $vt->listele("kullanici","WHERE id=".$bilgi['gon']."");
						if($ic1 != null) foreach( $ic1 as $icb ) {
							echo $icb['kuladi'];
						}
							?>
							</strong><br>Alıcı : <b>Ben</b> </div>
                                <span>
                              </div>
                            </div>
                          </div><br>
						   <div class="mesaj">
                          <div class="view-mail">
                            <?php echo $bilgi['mesaj']; ?>
                          </div>
						  </div>
						  <hr>
                          <div class="attachment">
                            <p>
                              <span><i class="fa fa-paperclip"></i><b> Ekler —</b> </span>
                              <a href="#">İndir</a> |
                              <a href="#">Görüntüle</a>
                            </p>
                            <ul>
                              <li>
                                <a href="#" class="atch-thumb">
                                </a>

                                <div class="file-name">
                                  <b> Alıntı: </b><?php  echo $bilgi['via']; ?>
                                </div>
                                <span>  </span>
                              </li>
							  </ul>
                          </div>
                          <div class="btn-group">
                            <button id="compose" class="btn btn-sm btn-primary" type="button"><i class="fa fa-reply"></i> Cevapla</button>
                            <button class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Diğer Mesaj"><i class="fa fa-share"></i></button>
                            <button class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Yazdır"><i class="fa fa-print"></i></button>
                            <button class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Sil"><i class="fa fa-trash-o"></i></button>
                          </div>
                        </div>

                      </div>
					<?php }?>
                      <!-- /CONTENT MAIL -->
					  <?php
                        if($bilgi['durum']==1) {
                            $guncelle = $vt->guncelle("mesajlar", array("durum" => 0), "id = " . $bilgi['id']);
                        }
					}
					else{
						
					}	
					?>
					
					 <!-- compose - Bu olay üzerine gidilip javascriptle eşleştirilip yapılacak. -->
    <div class="compose col-md-6 col-xs-12">
      <div class="compose-header">
        Yeni Mesaj
        <button type="button" class="close compose-close">
          <span>×</span>
        </button>
      </div>

      <div class="compose-body">
	  <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
			<form action="" method="POST">
			<div class="form-group">
			<!-- Ad -->
            <label for="recipient-name" class="control-label">Kullanıcı : </label>
			<select class="form-control" name="kul">
			<?php 
			$sorgum = $vt->listele("kullanici");
			$ben = $_SESSION['kid'];
			if($sorgum != null) foreach( $sorgum as $s ) {
				if($ben!=$s['id'])
			echo '<option value="'.$s['id'].'">'.$s['kuladi'].'</option>';
			
			}
			?>
			</select>
			<!-- Ad -->
			<!-- Konu -->
			<label for="recipient-name" class="control-label">Konu : </label>
			<input class="form-control" type="text" name="konu">
			<!-- Konu -->
			<!-- Ek -->
			<label for="recipient-name" class="control-label">Ek : </label>
			<input class="form-control" type="file" name="ek">
			<!-- Ek -->
			<!-- Ek -->
			<label for="recipient-name" class="control-label">Alıntı : </label>
			<input class="form-control" type="text" name="alinti">
			<!-- Ek -->
			</div>
			<form action="" method="POST">
			 <div class="btn-group">
			</div>
			</div>
        <div id="editor" class="editor-wrapper"> 
		<textarea class="form-control" rows="8" name="mesaj"  ></textarea>
		</div><br>
      </div>

      <div class="compose-footer">
        <input type="submit" class="btn btn-sm btn-success" name="gonder" value="GÖNDER">
      </div>
	 </form>
	 <?php 
	 if(@$_POST['gonder'])
	 {
		 $gon = $_SESSION['kid'];
		 $al = $_POST['kul'];
		 $konu = $_POST['konu'];
		 $ek = isset($_POST['ek']) ? $_POST['ek']: "YOK";
		 $alinti = isset($_POST['alinti']) ? $_POST['alinti']: "YOK";
		 $mesaj = $_POST['mesaj'];
		
		 $sonuc = $vt->ekle("mesajlar",array("gon"=>$gon,"alici"=>$al,"konu"=>$konu,"mesaj"=>$mesaj,"via"=>$alinti,"ek"=>$ek)); 
		 
	 }
	 ?>
    </div>
    <!-- /compose -->
					
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		<!-- PAGE CONTENT -->
<?php
include('footer.php');
}
?>