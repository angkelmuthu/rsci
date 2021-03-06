
<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
//This page is a result of an autogenerated content made by running test.html with firefox.
function domo(){
 
   // Binding keys
   $('*').bind('keydown', 'Ctrl+e', function assets() {
      $('#btn_edit').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
      $('#btn_back').trigger('click');
       return false;
   });
    
}


jQuery(document).ready(domo);
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      T Pendaftaran      <small><?= cclang('detail', ['T Pendaftaran']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= site_url('administrator/t_pendaftaran'); ?>">T Pendaftaran</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row" >
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="<?= BASE_ASSET; ?>../uploads/user/default.png" alt="User profile picture">

            <h3 class="profile-username text-center"><?= _ent($t_pendaftaran->pasien); ?></h3>

            <p class="text-muted text-center">No. MR : <?= _ent($t_pendaftaran->nomr); ?></p>

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>
<?
  $biday = new DateTime($t_pendaftaran->tgl_lhr);
  $today = new DateTime();
  $diff = $today->diff($biday);  
  $usia = $diff->y." Tahun ".$diff->m." Bulan ".$diff->d." Hari";  
?>   
      <div class="col-md-9">
         <div class="box box-warning">        
            <div class="box-body ">
                 
                  <div class="form-horizontal" name="form_t_pendaftaran" id="form_t_pendaftaran" >
                  <div class="row">
                  <div class="col-md-6"> 
                    <div class="form-group ">
                        <label for="content" class="col-sm-4 control-label">KTP </label>

                        <div class="col-sm-6">
                           <?= _ent($t_pendaftaran->nik); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-4 control-label">Tempat Lahir </label>

                        <div class="col-sm-6">
                           <?= _ent($t_pendaftaran->tmp_lhr); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-4 control-label">Tanggal Lahir </label>

                        <div class="col-sm-6">
                           <?= _ent($t_pendaftaran->tgl_lhr); ?>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="content" class="col-sm-4 control-label">Usia </label>

                        <div class="col-sm-6">
                           <?= $usia; ?>
                        </div>
                    </div>
                                         

                    </div>
                    <div class="col-md-6">   
                    <div class="form-group ">
                        <label for="content" class="col-sm-4 control-label">Cara Bayar </label>

                        <div class="col-sm-6">
                           <?= _ent($t_pendaftaran->carabayar); ?>
                        </div>
                    </div>                                      
                    <div class="form-group ">
                        <label for="content" class="col-sm-4 control-label">Poliklinik </label>

                        <div class="col-sm-6">
                           <?= _ent($t_pendaftaran->poli); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-4 control-label">Kunjungan </label>

                        <div class="col-sm-6">
                           <?= _ent($t_pendaftaran->datang); ?>
                        </div>
                    </div>

                   </div>
                   </div>
                  </div>
            </div>
            <!--/box body -->
         </div>
         <!--/box -->

      </div>
      <div class="col-md-12">
      <center>
        <a class="btn btn-block btn-info"><i class="fa fa-info"></i> Electronik Medical Record (EMR)</a>
        <br><br>
      </center>   
      </div>  

      <div class="col-md-12">
      <center>
        <a href="<?= site_url('administrator/t_asessment/add/'.$t_pendaftaran->noreg); ?>" class="btn btn-primary btn-lg"><i class="fa fa-heartbeat"></i> Asessment</a>
        <a href="<?= site_url('administrator/t_diagnosa/add/'.$t_pendaftaran->noreg); ?>" class="btn btn-info btn-lg"><i class="fa fa-user-md"></i> Diagnosa</a>
        <a class="btn btn-success btn-lg"><i class="fa fa-stethoscope"></i> Tindakan</a>
        <a class="btn btn-warning btn-lg"><i class="fa fa-flask"></i> Laboratorium</a>
        <a class="btn btn-danger btn-lg"><i class="fa fa-puzzle-piece"></i> Radiologi</a>
        <a class="btn bg-navy btn-lg"><i class="fa fa-sign-out"></i> Resume</a>
        <a class="btn bg-olive btn-lg"><i class="fa fa-credit-card"></i> Billing</a> 
        <br><br>
      </center>   
      </div>
      <div class="col-md-12">
      <center>
        <?php is_allowed('t_pendaftaran_update', function() use ($t_pendaftaran){?>      
        <!-- <a class="btn btn-app" id="btn_edit" data-stype='back' title="edit t_pendaftaran (Ctrl+e)" href="<?= site_url('administrator/t_pendaftaran/edit/'.$t_pendaftaran->noreg); ?>"><i class="fa fa-edit"></i> <?= cclang('update', ['T Pendaftaran']); ?></a> -->
        <?php }) ?>
        <!-- <a class="btn btn-default" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/t_pendaftaran/'); ?>"><?= cclang('go_list_button', ['T Pendaftaran']); ?></a> -->
        <a class="btn btn-default" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/t_pendaftaran/'); ?>">Kembali</a>
      </center>   
      </div>      
   </div>

</section>
<!-- /.content -->
