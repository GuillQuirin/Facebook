<div class="container">
  <h2>Création d'un concours </h2>
  <form>
    <div class="form-group">
      <label for="name">Intitulé du concours : </label>
      <input type="text" class="form-control" id="name"/>
    </div>
    <div class="form-group">
      <label for="description">Description du concours :</label>
      <div id="summernote">Hello Summernote</div>
    </div>
    <div class="form-group">
      <label for="start_date">Date de début du concours : </label>
      <div class="date" id="datePicker">
        <div class="input-group">
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          <input type="text" class="form-control" name="start_date" id="start_date" placeholder="jj/mm/aaaa" required/>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="end_date">Date de fin du concours : </label>
      <div class="date" id="datePicker2">
        <div class="input-group">
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          <input type="text" class="form-control" name="end_date" id="end_date" placeholder="jj/mm/aaaa" required/>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="prize">Description du concours :</label>
      <input type="text" class="form-control" id="prize"/>
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-lg btn-success">Créer le concours !</button>
    </div>
  </form>
</div>
<script>
  $(document).ready(function() {
    $.fn.datepicker.defaults.language = 'fr';

    $('#datePicker').datepicker({
      endDate: "+",
      startDate: "-2m",
      autoclose: true,
      format: "dd/mm/yyyy"
    });

    $('#datePicker2').datepicker({
      endDate: "+12m",
      startDate: "+1d",
      autoclose: true,
      format: "dd/mm/yyyy"
    })

    $('#summernote').summernote({
      height: 200,                 // set editor height
      minHeight: null,             // set minimum height of editor
      maxHeight: null,             // set maximum height of editor
      focus: true 
    }); 
  });
</script>