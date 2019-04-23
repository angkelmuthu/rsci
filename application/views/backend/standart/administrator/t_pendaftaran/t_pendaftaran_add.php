
<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
    function domo(){
     
       // Binding keys
       $('*').bind('keydown', 'Ctrl+s', function assets() {
          $('#btn_save').trigger('click');
           return false;
       });
    
       $('*').bind('keydown', 'Ctrl+x', function assets() {
          $('#btn_cancel').trigger('click');
           return false;
       });
    
      $('*').bind('keydown', 'Ctrl+d', function assets() {
          $('.btn_save_back').trigger('click');
           return false;
       });
        
    }
    
    jQuery(document).ready(domo);
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        T Pendaftaran        <small><?= cclang('new', ['T Pendaftaran']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/t_pendaftaran'); ?>">T Pendaftaran</a></li>
        <li class="active"><?= cclang('new'); ?></li>
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
                                <img class="img-circle" src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                            </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username">T Pendaftaran</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['T Pendaftaran']); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_t_pendaftaran', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_t_pendaftaran', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="nomr" class="col-sm-2 control-label">Nomr 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nomr" id="nomr" placeholder="Nomr" value="<?= $this->uri->segment('5'); ?>" readonly>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group  wrapper-options-crud">
                            <label for="kdcarabayar" class="col-sm-2 control-label">Kdcarabayar 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                    <?php foreach (db_get_all_data('m_carabayar') as $row): ?>
                                    <div class="col-md-3 padding-left-0">
                                    <label>
                                    <input type="radio" class="flat-red" name="kdcarabayar" value="<?= $row->kdcarabayar ?>"> <?= $row->carabayar; ?>
                                    </label>
                                    </div>
                                    <?php endforeach; ?>  
                                </select>
                                <div class="row-fluid clear-both">
                                <small class="info help-block">
                                <b>Input Kdcarabayar</b> Max Length : 11.</small>
                                </div>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="kdpoli" class="col-sm-2 control-label">Kdpoli 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="kdpoli" id="kdpoli" data-placeholder="Select Kdpoli" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('m_poli') as $row): ?>
                                    <option value="<?= $row->kdpoli ?>"><?= $row->poli; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                <b>Input Kdpoli</b> Max Length : 11.</small>
                            </div>
                        </div>

                                <input type="hidden" class="form-control" name="kdjenispasien" id="kdjenispasien" placeholder="Kdjenispasien" value="<?= $this->uri->segment('4'); ?>">
                                                 
                                                <div class="form-group ">
                            <label for="kdjenisdatang" class="col-sm-2 control-label">Kdjenisdatang 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="kdjenisdatang" id="kdjenisdatang" data-placeholder="Select Kdjenisdatang" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('m_datang') as $row): ?>
                                    <option value="<?= $row->kddatang ?>"><?= $row->datang; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                <b>Input Kdjenisdatang</b> Max Length : 11.</small>
                            </div>
                        </div>

                                                 
                        
                        <div class="message"></div>
                        <div class="row-fluid col-md-7">
                           <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                            <i class="fa fa-save" ></i> <?= cclang('save_button'); ?>
                            </button>
                            <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                            <i class="ion ion-ios-list-outline" ></i> <?= cclang('save_and_go_the_list_button'); ?>
                            </a>
                            <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                            <i class="fa fa-undo" ></i> <?= cclang('cancel_button'); ?>
                            </a>
                            <span class="loading loading-hide">
                            <img src="<?= BASE_ASSET; ?>/img/loading-spin-primary.svg"> 
                            <i><?= cclang('loading_saving_data'); ?></i>
                            </span>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
                <!--/box body -->
            </div>
            <!--/box -->
        </div>
    </div>
</section>
<!-- /.content -->
<!-- Page script -->
<script>
    $(document).ready(function(){
                   
      $('#btn_cancel').click(function(){
        swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = BASE_URL + 'administrator/t_pendaftaran';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_t_pendaftaran = $('#form_t_pendaftaran');
        var data_post = form_t_pendaftaran.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: BASE_URL + '/administrator/t_pendaftaran/add_save',
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            resetForm();
            $('.chosen option').prop('selected', false).trigger('chosen:updated');
                
          } else {
            $('.message').printMessage({message : res.message, type : 'warning'});
          }
    
        })
        .fail(function() {
          $('.message').printMessage({message : 'Error save data', type : 'warning'});
        })
        .always(function() {
          $('.loading').hide();
          $('html, body').animate({ scrollTop: $(document).height() }, 2000);
        });
    
        return false;
      }); /*end btn save*/
      
       
 
       
    
    
    }); /*end doc ready*/
</script>