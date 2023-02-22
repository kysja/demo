<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/about.css">
    
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.6.3.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">

    <title><?= $title ?? $viewGlobal['title'] ?></title>
</head>
<body class="d-flex flex-column h-100">

<main>
<div class="container mb-5">
    <h1><?= $title ?></h1>

    <div class="mt-4">See: <a href="https://demo.alexu.dev" target="_blank">demo.alexu.dev</a> | <a href="https://github.com/kysja/demo" target="_blank">Github.com</a></div>

    <h2>Project Description</h2>
    <p>The project involves importing an XML file from a remote source, parsing the data contained in the file, and adding the parsed data to a database. The data can then be displayed to the user with options to sort and filter the data based on various criteria. </p>

    <h2>Directory Structure</h2>
    <div>
        <ul>
            <li><b>app</b>
                <ul>
                    <li><b>controllers</b> - contains the controllers</li>
                    <li><b>core</b> - contains the core classes</li>
                    <li><b>models</b> - contains the models</li>
                </ul>
            </li>
            <li><b>public</b> - contains the entry script and resources
                <ul>
                    <li><b>css</b> - contains the CSS files</li>
                    <li><b>images</b> - contains the images</li>
                    <li><b>js</b> - contains the JavaScript files</li>
                    <li><b>storage</b> - contains the uploaded files</li>
                </ul>
            </li>
            <li><b>vendor</b> - contains the third-party libraries</li>
            <li><b>views</b> - contains the view files</li>
        </ul>
    </div>

    <h2>MVC Design Pattern</h2>
    <p>This design pattern separates the application into three main components: the Model, which represents the data and business logic; the View, which displays the data to the user; and the Controller, which handles user input and communicates between the Model and View.</p>

    <h3>Routing</h3>
    <p>The routes are defined in the entry script, public\index.php. The routes are then matched against the current URL and the corresponding controller is called.</p>

    <h3>Controllers</h3>
    <p>The controllers are stored in the app\controllers directory. The controllers call the appropriate models and render the views.</p>

    <h3>Models</h3>
    <p>The models are stored in the app\models directory. The models are used to perform database and other operations.</p>

    <h3>Views</h3>
    <p>I didn't use any template engines for the views. The views are stored in the views directory. The views are rendered using the app\core\View class.</p>


    <h2>Stack</h2>
    <p>I used the following technologies for this project:</p>
    <ul>
        <li>Backend
            <ul>
                <li>PHP</li>
                <li>MySQL</li>
            </ul>
        </li>
        <li>Frontend
            <ul>
                <li>Bootstrap</li>
                <li>Javascript</li>
                <li>jQuery</li>
            </ul>
        </li>
    </ul>
    

    <h2>MySQL Schema</h2>
    <div>
        <iframe width="600px" height="360px" style="box-shadow: 0 2px 8px 0 rgba(63,69,81,0.16); border-radius:15px;" allowtransparency="true" allowfullscreen="false" scrolling="no" title="Embedded DrawSQL IFrame" frameborder="0" src="https://drawsql.app/teams/k5-team/diagrams/demo/embed"></iframe>
    </div>

    <h2>Database Connection</h2>
    <p>I used the PDO class to connect to the MySQL database. The database connection is established in the app\core\Database class. The database connection is then passed to the models, which use it to perform database operations.</p>

    <h2>Authentication</h2>
    <p>I used JSON Web Tokens (JWT) for authentication. When a user logs in, the server would generate a JWT token containing the user's credentials and expiration time. This token is then sent back to the client, where it is stored in Cookies. The server would verify the token and grant access to the requested pages if the token is valid.</p>

    <h2>Code examples</h2>

    <h3>Routing</h3>
    <div><span role="button" style="border-bottom:dotted 1px gray;" onclick="$(this).hide();$('#routing_code').removeClass('d-none');">Show code</span></div>
    <div class="d-none" id="routing_code">
        public/index.php
        <script src="https://gist.github.com/kysja/f052550f9f6badf0c952ccafe41a3c3e.js"></script>    
        
        app/core/Router.php
        <script src="https://gist.github.com/kysja/6f0e6c33ffbf6b55a495bb5edbbc45b4.js"></script>
    </div>

    <h3>Rate with stars</h3>
    <p>When a user clicks on a star, the rating is saved in the database using AJAX.</p>
    <div><span role="button" style="border-bottom:dotted 1px gray;" onclick="$(this).hide();$('#rate_code').removeClass('d-none');">Show code</span></div>
    <div class="d-none" id="rate_code">
        view/person/index.view.php (part of the code)
        <script src="https://gist.github.com/kysja/530df3396ba56f3aec4dce351708882f.js"></script>
    
        public/js/person.js (part of the code)
        <script src="https://gist.github.com/kysja/95a25715cf73084569fc0a337f33d751.js"></script>

        app/models/Ajax.php
        <script src="https://gist.github.com/kysja/4b98cc8b2b89827c1038d62f649691bf.js"></script>
    </div>

    <h3>Model: Person.php | Method: getList()</h3>
    <p>The getList() method of the Person model is used to show the data from the "persons" and "companies" tables.</p>
    <div><span role="button" style="border-bottom:dotted 1px gray;" onclick="$(this).hide();$('#person_code').removeClass('d-none');">Show code</span></div>
    <div class="d-none" id="person_code">
        app/models/Person.php (part of the code)
        <script src="https://gist.github.com/kysja/727dd32d19620b741dcf6dde88676192.js"></script>
    </div>

    <h3>Model: Import.php</h3>
    <p>The Import model is used to download xml files from the remote server, parse and save the data in the database.</p>
    <div><span role="button" style="border-bottom:dotted 1px gray;" onclick="$(this).hide();$('#import_code').removeClass('d-none');">Show code</span></div>
    <div class="d-none" id="import_code">
        app/models/Import.php (part of the code)
        <script src="https://gist.github.com/kysja/6ef5dfc62e2bafef09dac395a9df79c0.js"></script>
    </div>

        






</div>
</main>

</body>
</html>