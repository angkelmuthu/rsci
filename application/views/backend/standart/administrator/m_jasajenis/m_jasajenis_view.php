
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
      M Jasajenis      <small><?= cclang('detail', ['M Jasajenis']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= site_url('administrator/m_jasajenis'); ?>">M Jasajenis</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row" >
     
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">

               <!-- Widget: user widget style 1 -->
               <div class="box box-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header ">
                    
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username">M Jasajenis</h3>
                     <h5 class="widget-user-desc">Detail M Jasajenis</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal" name="form_m_jasajenis" id="form_m_jasajenis" >
                   
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Kdjasajenis </label>

                        <div class="col-sm-8">
                           <?= _ent($m_jasajenis->kdjasajenis); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Jasa Jenis </label>

                        <div class="col-sm-8">
                           <?= _ent($m_jasajenis->jasajenis); ?>
                        </div>
                    </div>
                                        
                    <br>
                    <br>

                    <div class="view-nav">
                        <?php is_allowed('m_jasajenis_update', function() use ($m_jasajenis){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit m_jasajenis (Ctrl+e)" href="<?= site_url('administrator/m_jasajenis/edit/'.$m_jasajenis->kdjasajenis); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['M Jasajenis']); ?> </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/m_jasajenis/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['M Jasajenis']); ?></a>
                     </div>
                    
                  </div>
               </div>
            </div>
            <!--/box body -->
         </div>
         <!--/box -->

      </div>
   </div>
</section>
<!-- /.content -->
