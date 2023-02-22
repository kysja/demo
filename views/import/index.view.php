<?php require base_path('views/layout/header.php'); ?>

<h1 class="mb-5">Import Data</h1>

<div class="row">
    <div class="col col-8">
        <div class="mb-4">
            
            <h2>Step 1. Download xml-file from the remote server</h2>
            
            <form action="/import/download" method="post">
                <div class="row g-3">
                    <div class="col">
                        <input class="form-control" type="text" id="fileLink" name="fileLink">
                        <div class="mt-2 mb-3 fst-italic text-start">.xml, .zip files allowed</div>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Download</button>
                    </div>
                </div>
                <?= $downloadError ? '<div class="pt-2 text-danger text-left fw-bold">' . $downloadError .'</div>'  : '' ?>
            </form>

            <div class="mt-2 text-start">
                <p class="fw-bold">Please select one of the demo files:</p>
                <ul>
                    <li class="my-3"><span role="button" style="border-bottom: dotted 1px gray;" onclick="document.getElementById('fileLink').value = 'https://www.alexu.dev/demo/demo_1.xml';">https://www.alexu.dev/demo/demo_1.xml</span></li>
                    <li class="my-3"><span role="button" style="border-bottom: dotted 1px gray;" onclick="document.getElementById('fileLink').value = 'https://www.alexu.dev/demo/demo_2.zip';">https://www.alexu.dev/demo/demo_2.zip</span></li>
                </ul>
                <p class="fst-italic text-secondary">The data in these files is sourced from publicly available information.</p>

            </div>
            <div class="my-4">You can see <a href="/storage/import/example/example.xml" target="_blank">example.xml</a> for the xml tree structure.</div>

        </div>



        <?php if (count($xmlFiles)>0): ?>
        <div class="mt-5 mb-3">
            <h2>Step 2. Parse and add downloaded file data to database</h2>
            <?= $parseError ? '<div class="pt-2 text-danger text-left fw-bold">' . $parseError .'</div>'  : '' ?>
            <table class="table w-auto">
                <tr>
                    <th>File</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </tr>
                <?php foreach ($xmlFiles as $file) : ?>
                    <tr>
                        <td><?= $file['name'] ?></td>
                        <td><?= round($file['size']/(1024*1024),3) ?> Mb</td>
                        <td><a href="/import/parse?file=<?= $file['name'] ?>" class="btn btn-sm btn-primary btn_parse">Parse</a></td>
                        <td><a href="/import/deletefile?file=<?= $file['name'] ?>" class="btn btn-sm btn-outline-danger">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>

    </div>
    <div class="col col-4">
        
        <div class="mt-5 mb-3">
            <h2>Database</h2>
            <table class="table w-auto">
                <tr>
                    <th>Table</th>
                    <th>Records</th>
                </tr>
                <tr>
                    <td>persons</td>
                    <td><?= $dbStat['persons'] ?></td>
                </tr>
                <tr>
                    <td>companies</td>
                    <td><?= $dbStat['companies'] ?></td>
                </tr>
            </table>
            <div class="my-3">
                <?php if ($dbStat['persons'] != 0 && $dbStat['companies'] != 0): ?>
                    <a href="/" class="btn btn-primary me-3">View Data</a>
                    <a href="/import/dbempty" class="btn btn-outline-danger" onclick="confirmDelete()">Empty Database</a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>





<script src="/js/import.js"></script>

<?php require base_path('views/layout/footer.php'); ?>