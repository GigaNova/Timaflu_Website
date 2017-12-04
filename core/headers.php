<?php

$config = \timaflu\Core::$config;
$js = &$config['js'];
$css = &$config['css'];

?>

<?php foreach($js as $part): ?>
    <script src="<?= '/'.$config['basename'].'/'.$part['main'].$part['file'] ?>"></script>
<?php endforeach; ?>

<?php foreach($css as $part): ?>
    <link href="<?= '/'.$config['basename'].'/'.$part['main'].$part['file'] ?>" rel="stylesheet">
<?php endforeach; ?>
