$(document).ready(function() {
    //Liste des competitions
    $('#listCompetitions').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "lengthMenu": "Affichage de _MENU_ résultats par page",
            "zeroRecords": "Aucun résultat trouvé",
            "info": "Affichage de la page numéro _PAGE_ sur un total de _PAGES_ page(s)",
            "infoEmpty": "Pas de résultat trouvé",
            "infoFiltered": "(trier sur un enregistrement total de _MAX_ résultats)"
        }
    } );

    //Affichage de la pop-up d'une competition
    $('#listCompetitions tbody tr').click(function(){
        $(this).find("td").each(function(){
            var type = $(this).attr('name');
            $('#Modal input[name="'+type+'"]').val($(this).text());
        })
        $("#Modal").modal();    
    });

    //Envoi des nouvelles données en ajax
    $('#Modal #submit').click(function(){
        $.ajax({
          method: "POST",
          url: $('[name="webpath"]').val()+"/admin/editCompetition",
          data: $('#data_competition').serialize()
        })
          .done(function( msg ) {
            console.log( "Data Saved: " + msg );
          });
    });
} );