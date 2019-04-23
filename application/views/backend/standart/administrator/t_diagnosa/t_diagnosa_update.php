
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
        T Diagnosa        <small>Edit T Diagnosa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/t_diagnosa'); ?>">T Diagnosa</a></li>
        <li class="active">Edit</li>
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
                            <h3 class="widget-user-username">T Diagnosa</h3>
                            <h5 class="widget-user-desc">Edit T Diagnosa</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/t_diagnosa/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_t_diagnosa', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_t_diagnosa', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="noreg" class="col-sm-2 control-label">Noreg 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="noreg" id="noreg" placeholder="Noreg" value="<?= set_value('noreg', $t_diagnosa->noreg); ?>">
                                <small class="info help-block">
                                <b>Input Noreg</b> Max Length : 11.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="subjective" class="col-sm-2 control-label">Subjective 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="subjective" name="subjective" rows="5" class="textarea"><?= set_value('subjective', $t_diagnosa->subjective); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="diag_awal" class="col-sm-2 control-label">Diagnosa Awal (ICD) 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="diag_awal" id="diag_awal" data-placeholder="Select Diag Awal" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('icd') as $row): ?>
                                    <option <?=  $row->code ==  $t_diagnosa->diag_awal ? 'selected' : ''; ?> value="<?= $row->code ?>"><?= $row->description; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                                                 
                                                <div class="form-group ">
                            <label for="objective" class="col-sm-2 control-label">Objective 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="objective" name="objective" rows="5" class="textarea"><?= set_value('objective', $t_diagnosa->objective); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="asessment" class="col-sm-2 control-label">Asessment 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="asessment" name="asessment" rows="5" class="textarea"><?= set_value('asessment', $t_diagnosa->asessment); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="plan" class="col-sm-2 control-label">Planning 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="plan" name="plan" rows="5" class="textarea"><?= set_value('plan', $t_diagnosa->plan); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="diag_akhir" class="col-sm-2 control-label">Diagnosa Akhir (ICD) 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="diag_akhir" id="diag_akhir" data-placeholder="Select Diag Akhir" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('icd') as $row): ?>
                                    <option <?=  $row->code ==  $t_diagnosa->diag_akhir ? 'selected' : ''; ?> value="<?= $row->code ?>"><?= $row->description; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                <b>Input Diag Akhir</b> Max Length : 50.</small>
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
            title: "Are you sure?",
            text: "the data that you have created will be in the exhaust!",
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
              window.location.href = BASE_URL + 'administrator/t_diagnosa';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_t_diagnosa = $('#form_t_diagnosa');
        var data_post = form_t_diagnosa.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_t_diagnosa.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#t_diagnosa_image_galery').find('li').attr('qq-file-id');
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            $('.data_file_uuid').val('');
    
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