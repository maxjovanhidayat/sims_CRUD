<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
</head>
<body>

<h1>Users</h1>

<ul>
    <?php foreach ($users as $user): ?>
        <li><?= esc($user['name']) ?> (<?= esc($user['email']) ?>)</li>
    <?php endforeach; ?>
</ul>

</body>
</html>
