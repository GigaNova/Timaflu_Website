<div class="container">
    <h2>Medicijnen</h2>
    <table class="table table-hover">
        <thead>
        <tr>
            <?php

            $class = new \timaflu\models\Medicine();
            $attributes = $class->attributes();
            foreach($attributes as $attribute){
                echo "<th>".$class->getAttributeName($attribute)."</th>";
            }

            ?>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach($medicine as $med){
            echo "<tr>";
            foreach($attributes as $attribute){
                echo "<td>".$med->$attribute."</td>";
            }
            echo "</tr>";
        }

        ?>
        </tbody>
    </table>
</div>