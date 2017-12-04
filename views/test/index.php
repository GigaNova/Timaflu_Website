<h1>Herro</h1>
<table class="table table-striped">
    <tr>
        <th>Firstname</th>
        <th>Height</th>
        <th>Weight</th>
    </tr>
    <?php foreach($people as $person): ?>
        <tr>
            <td><?= $person->name ?></td>
            <td><?= $person->height ?></td>
            <td><?= $person->weight ?></td>
        </tr>
    <?php endforeach; ?>
</table>
