<div class="form-group">
  	<h1 class="text-uppercase">Règlement du concours </h1>
  	<textarea class="summernote" id="regulation"><?php echo (isset($listSetting) && is_array($listSetting)) ? $listSetting[1]->getValue() : "";?></textarea> 
  	<button type="submit" id="saveRegulation" class="btn btn-success">Sauvegarder le règlement</button>
</div><br>
<div class="form-group">
  	<h1 class="text-uppercase">Conditions Générales d'Utilisation </h1>
  	<div class="summernote" id="cgu"><?php echo (isset($listSetting) && is_array($listSetting)) ? $listSetting[0]->getValue() : "";?></div>
  	<button type="submit" id="saveCGU" class="btn btn-success">Sauvegarder les CGU</button>
</div>
<script>
	$('.summernote').summernote({
      minHeight: null,             // set minimum height of editor
      maxHeight: null,             // set maximum height of editor
      focus: true 
    }); 

    $('#saveRegulation').click(function(){
				$.ajax({
					method: "POST",
					url: $('[name="webpath"]').val()+"/setting/saveRegulation",
					data: {
						regulation: $('#regulation').summernote('code'),
						id_setting: <?php echo $listSetting[1]->getId_setting();?>
					}
				})
				.done(function( msg ) {
					location.reload();
				});
		});

    $('#saveCGU').click(function(){
        $.ajax({
          method: "POST",
          url: $('[name="webpath"]').val()+"/setting/saveCGU",
          data: {
            cgu: $('#cgu').summernote('code'),
            id_setting: <?php echo $listSetting[0]->getId_setting();?>
          }
        })
        .done(function( msg ) {
          location.reload();
        });
    });
</script>