<div class="container">
  <h2>Création d'un concours </h2>
  <form>
    <div class="form-group">
      <label for="email">Intitulé du concours : </label>
      <input type="email" class="form-control" id="email">
    </div>
    <div class="form-group">
      <label for="pwd">Description du concours :</label>
      <div id="summernote">Hello Summernote</div>
    </div>
    <div class="form-group">
      <label for="dateDebut">Date de début du concours : </label>
      <div class="date" id="datePicker">
        <div class="input-group">
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          <input type="text" class="form-control" name="dateDebut" id="dateDebut" placeholder="jj/mm/aaaa" required/>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="dateFin">Date de fin du concours : </label>
      <div class="date" id="datePicker2">
        <div class="input-group">
          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          <input type="text" class="form-control" name="dateFin" id="dateFin" placeholder="jj/mm/aaaa" required/>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
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