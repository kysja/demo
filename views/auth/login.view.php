<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <title>Login</title>

</head>
<body class="d-flex flex-column h-100 bg-body-tertiary">
<div class="w-100 m-auto">
<div class="mx-auto border rounded-3 p-4 bg-white" style="max-width:360px;">

    <?= $authError ? '<div class="text-danger text-center">' . $authError .'</div>'  : '' ?>

    <form action="/login" method="post">
        <?= $form->csrfField(); ?>

        <div class="form-outline mt-3 mb-4">
            <label class="form-label" for="login">Login</label>
            <input type="text" name="login" id="login" class="form-control w-100" value="" />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control w-100" value=""  />
        </div>

        <div class="text-start">
            <button type="submit" class="btn btn-primary btn-block mb-4 w-100">Sign in</button>
        </div>

    </form>

    <div class="text-center"><span role="button" style="border-bottom: dotted 1px gray;" onclick="document.getElementById('login').value = 'demo';document.getElementById('password').value = 'Tvb6wabTRr5gWdnLwqZ9';">Login and password for demo purposes</span></div>

</div>
</div>
</body>
</html>