<div class="header">
<p>
<strong>
Parroisse Saint Michel <br />

Archidiocèse de Bujumbura <br />

B.P : 1 045 BUJUMBURA <br />

Téléphone : +257 22 22 29 97 <br />

E-mail:cathedralerm@yahoo.fr <br />
</strong>
</p>
</div>
<div class="title">
    <p style="text-align:center;text-decoration:underline;padding-bottom:14px;"><strong>DELEGATION DE BAPTEME</strong></p>
</div>
<div class="content">
Le Curé de la Paroisse Cathédrale Regina Mundi accorde à Monsieur l'Abbé, la délégation de baptiser l'enfant ci-après : 
<table>
<tr>
    <td>Prénom et Nom de l'enfant </td>
    <td>: <?php echo $bapteme->prenom_bapt .' '.$bapteme->nom_bapt; ?> </td>
</tr>
<tr>
    <td>Date de Naissance </td>
    <td>: <?php echo $bapteme->date_naissance; ?> </td>
</tr>
<tr>
    <td>Prénom et Nom du père</td> 
    <td>: <?php echo $bapteme->prenom_pere.' '.$bapteme->nom_pere; ?></td>
</tr>
<tr>
    <td>Prénom et Nom de la mère </td> 
    <td>: <?php echo $bapteme->prenom_mere.' '.$bapteme->nom_mere; ?></td>
</tr>
<tr>
    <td>Domicile </td>
    <td>: <?php echo $bapteme->domicile_bapt; ?></td>
</tr>
<tr>
    <td>Date de Mariage des parents </td>
    <td>: <?php echo $bapteme->dateMariageParent; ?></td>
</tr>
<tr>
    <td>Marraine </td>
    <td>: <?php echo $bapteme->prenom_parrain.' '.$bapteme->nom_parrain; ?></td>
</tr>
<tr>
    <td>Date de Baptême </td>
    <td>: <?php echo $bapteme->date_bapt; ?></td>
</tr>
<tr>
    <td>Lieu de Baptême </td>
    <td>: <?php echo $bapteme->lieu_bapteme; ?></td>
</tr>
<tr>
    <td>Ministre+Contact</td>
    <td>: <?php echo $bapteme->prenom_celebrant.' '.
                    $bapteme->nom_celebrant; 
            echo ($bapteme->contact)?' - '.$bapteme->contact : '';
    ?>
    </td>
</tr>
<tr>
    <td>Lieu du Ministère </td>
    <td>: <?php echo $bapteme->lieu_ministere; ?></td>
</tr>
<tr>
    <td>Service </td>
    <td>: <?php echo $bapteme->service; ?></td>
</tr>
</table>

</div>
<div class="nb">
<p><strong>N.B: Veuillez nous ramener ce papier post factum dûment signé.</strong></p>
</div>
<div class="signature">
<p style="text-align:right">
<strong>
Fait à Bujumbura, le <?php echo date('dd/MM/YYYY'); ?><br />

Abbé Emmanuel MUGIRANEZA,<br />

Curé de la Parroisse Saint Michel.<br />
<strong>
</p>
</div>
