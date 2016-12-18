$(document).ready(function() {
    /*COMPETITIONS*/

    //Liste des competitions
    var listAdmin = $('#listCompetitions').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        "responsive": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "lengthMenu": "Affichage de _MENU_ résultats par page",
            "zeroRecords": "Aucun résultat trouvé",
            "info": "Affichage de la page numéro _PAGE_ sur un total de _PAGES_ page(s)",
            "infoEmpty": "Pas de résultat trouvé",
            "infoFiltered": "(trier sur un enregistrement total de _MAX_ résultats)",
            "search": "Rechercher"
        }
    } );


    //Affichage de la pop-up d'une competition
    $('#listCompetitions>tbody>tr').click(function(){
        $(this).find("td").each(function(){
            var type = $(this).attr('name');
            $('#Modal input[name="'+type+'"]').val($(this).text());
            $('#Modal textarea[name="'+type+'"]').val($(this).text());
            if(type=="url_prize")
                $('#Modal input[name="'+type+'"]').val($(this).find('a').attr("href"));
        })
    });

    //Envoi des modifications en ajax
    $('#Modal #submit').click(function(){
        $.ajax({
          method: "POST",
          url: $('[name="webpath"]').val()+"/admin/editCompetition",
          data: $('#data_competition').serialize()
        })
          .done(function( msg ) {
           console.log(msg);
           //location.reload();
          });
    });

     //Envoi du nouveau concours en ajax
    $('#CreateCompetition #submit').click(function(){
        $.ajax({
          method: "POST",
          url: $('[name="webpath"]').val()+"/admin/addCompetition",
          data: $('#create_data_competition').serialize()
        })
          .done(function( msg ) {
           location.reload();
          });
    });

    /*PARTICIPANTS*/

    //Liste des photo reported
    var listReportedPhoto = $('#listReportedPhoto').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        "responsive": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "lengthMenu": "Affichage de _MENU_ résultats par page",
            "zeroRecords": "Aucun résultat trouvé",
            "info": "Affichage de la page numéro _PAGE_ sur un total de _PAGES_ page(s)",
            "infoEmpty": "Pas de résultat trouvé",
            "infoFiltered": "(trier sur un enregistrement total de _MAX_ résultats)",
            "search": "Rechercher"
        }
    } );

} );