<?php
$errors = [];
$uploadFile = '';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES['avatar'])) {


        $uploadDir = 'public/uploads/';

        $uploadFile = $uploadDir . uniqid("", true) . basename($_FILES['avatar']['name']);

        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

        $authorizedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $maxFileSize = 1000000;


        if ((!in_array($extension, $authorizedExtensions))) {
            $errors[] = 'Veuillez sélectionner une image de type Jpg, Jpeg, Png, gif ou webp !';
        }

        if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
            $errors[] = "Votre fichier doit faire moins de 1M !";
        }
        if (empty($errors)) {
            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        }
    } else {
        $errors[] = 'Le fichier est trop volumineux ! ';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpson</title>
</head>

<body>
    <?php
    if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>

    <form method="POST" enctype="multipart/form-data">
        <label for="imageUpload">Upload an profile image</label>
        <input type="file" name="avatar" id="imageUpload" />
        <button> Send </button>
    </form>

    <?php
    if (!empty($uploadFile) && empty($errors)) : ?>
        <img src="<?= $uploadFile ?>" alt="blalba">
    <?php endif ?>

</body>

</html>