
<script src="<?= BASE_ASSET; ?>js/custom.js"></script>


<?= form_open('', [
    'name'    => 'form_form_asessment', 
    'class'   => 'form-horizontal form_form_asessment', 
    'id'      => 'form_form_asessment',
    'enctype' => 'multipart/form-data', 
    'method'  => 'POST'
]); ?>
 
<div class="form-group ">
    <label for="noreg" class="col-sm-2 control-label">Noreg 
    <i class="required">*</i>
    </label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="noreg" id="noreg" placeholder=""  >
        <small class="info help-block">
        <b>Format Noreg must</b> Valid Number.</small>
    </div>
</div>
 
<div class="form-group ">
    <label for="berat_badan" class="col-sm-2 control-label">Berat Badan 
    <i class="required">*</i>
    </label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="berat_badan" id="berat_badan" placeholder=""  >
        <small class="info help-block">
        <b>Format Berat Badan must</b> Valid Number.</small>
    </div>
</div>
 
<div class="form-group ">
    <label for="tinggi" class="col-sm-2 control-label">Tinggi 
    <i class="required">*</i>
    </label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="tinggi" id="tinggi" placeholder=""  >
        <small class="info help-block">
        <b>Format Tinggi must</b> Valid Number.</small>
    </div>
</div>
 
<div class="form-group ">
    <label for="tekanan_darah" class="col-sm-2 control-label">Tekanan Darah 
    <i class="required">*</i>
    </label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="tekanan_darah" id="tekanan_darah" placeholder=""  >
        <small class="info help-block">
        <b>Format Tekanan Darah must</b> Valid Number.</small>
    </div>
</div>


<div class="row col-sm-12 message">
</div>
<div class="col-sm-2">
</div>
<div class="col-sm-8 padding-left-0">
    <button class="btn btn-flat btn-primary btn_save" id="btn_save" data-stype='stay'>
    Submit
    </button>
    <span class="loading loading-hide">
    <img src="http://localhost:80/cicool/asset//img/loading-spin-primary.svg"> 
    <i>Loading, Submitting data</i>
    </span>
</div>
</form></div>


<!-- Page script -->
<script>
    $(document).ready(function(){
          $('.form-preview').submit(function(){
        return false;
     });

     $('input[type="checkbox"].flat-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
     });


    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_form_asessment = $('#form_form_asessment');
        var data_post = form_form_asessment.serializeArray();
        var save_type = $(this).attr('data-stype');
    
        $('.loading').show();
    
        $.ajax({
          url: BASE_URL + 'form/form_asessment/submit',
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
          $('html, body').animate({ scrollTop: $(document).height() }, 1000);
        });
    
        return false;
      }); /*end btn save*/


      
             
           
    }); /*end doc ready*/
</script>