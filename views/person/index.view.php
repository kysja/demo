<?php require base_path('views/layout/header.php'); ?>





    <div class="d-inline-block me-4">
        <div class="my-3">
            <select class="form-select" id="stateSel" data-qs="<?= http_build_query(array_diff_key($qs,['state'=>''])) ?>">
                <option value="">Filter By State</option>
                <?php foreach ($states as $key=>$val): ?>
                    <option value="<?= $key ?>" <?= isset($qs['state']) && $qs['state']===$key ? 'selected' : ''  ?>><?= $val ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>


    <div class="d-inline-block me-4">
        <div class="my-3">
            <input class="form-control" type="text" id="search" placeholder="Search" value="<?= isset($qs['search']) ? $qs['search'] : '' ?>" data-qs="<?= http_build_query(array_diff_key($qs,['search'=>''])) ?>">
        </div>
    </div>



<?php if (count($persons['rows'])>0): ?>

    <div class="my-4">
    <div class="my-2">Records: <?= $persons['paginate']['total'] ?></div>
    <table class="table table-bordered w-auto">
        <thead>
            <tr class="bg-body-secondary">
                <th rowspan="2" class="text-center">Rate</th>
                <th colspan="2" class="text-center">Person</th>
                <th colspan="5" class="text-center">Company</th>
            </tr>
            <tr class="bg-body-secondary">
                <th class="text-center"><a href="?<?= http_build_query(array_merge($qs,['sort'=>'number'])) ?>">Number</a></th>
                <th class="text-center"><a href="?<?= http_build_query(array_merge($qs,['sort'=>'name'])) ?>">Name</a></th>
                <th class="text-center"><a href="?<?= http_build_query(array_merge($qs,['sort'=>'company_number'])) ?>">Number</a></th>
                <th class="text-center">Company</th>
                <th class="text-center">City</th>
                <th class="text-center">State</th>
                <th class="text-center">Zip</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($persons['rows'] as $person): ?>
            <tr>
                <td class="text-start text-nowrap">
                    <div id="stars" data-current="<?= $person['stars'] ?? 0 ?>">
                        <?php for ($i=1; $i<=5; $i++): ?>
                            <span class="starRate <?= ($person['stars']>=$i ? 'active' : '') ?>" id="star-<?= $person['id'] ?>-<?= $i ?>" data-rate="<?= $i ?>" data-id="<?= $person['id'] ?>"></span>
                        <?php endfor; ?>
                    </div>
                </td>
                <td class="text-center"><?= $person['number'] ?></td>
                <td class="text-start"><?= ucwords(strtolower($person['full_name'])) ?></td>
                <td class="text-center"><?= $person['cmp_number'] ?></td>
                <td class="text-start"><?= ucwords(strtolower($person['cmp_name'])) ?></td>
                <td class="text-start"><?= ucwords(strtolower($person['cmp_city'])) ?></td>
                <td class="text-start"><?= $person['cmp_state'] ?></td>
                <td class="text-start"><?= $person['cmp_zip'] ?></td>
                
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>



    <?php if ($persons['paginate']['pages']>1): ?>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php if ($persons['paginate']['page']>1): ?>
                    <li class="page-item"><a href="?<?= http_build_query(array_merge($qs,['page'=>$persons['paginate']['page']-1])) ?>" class="page-link">Previous</a></li>
                <?php endif; ?>
                    
                <?php for ($i=1; $i<=$persons['paginate']['pages']; $i++): ?>
                    <?php if ($i<=3 || $i>=($persons['paginate']['pages']-2) || abs($persons['paginate']['page']-$i)<=2): ?>
                        <?php $dotsShow=true; ?>
                        <li class="page-item"><a class="page-link <?= $i==$persons['paginate']['page'] ? 'active' : '' ?>" href="?<?= http_build_query(array_merge($qs,['page'=>$i])) ?>"><?= $i ?></a></li>
                    <?php endif; ?>
                    <?php if ($i>3 && $i<($persons['paginate']['pages']-2) && abs($persons['paginate']['page']-$i)>2 && $dotsShow) : ?>
                        <?php $dotsShow=false; ?>
                        <li class="page-item"><a class="page-link">...</a></li>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($persons['paginate']['page']<$persons['paginate']['pages']): ?>
                    <li class="page-item"><a class="page-link" href="?<?= http_build_query(array_merge($qs,['page'=>$persons['paginate']['page']+1])) ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>

    <?php endif ?>


<?php else: ?>
    <p>No records</p>
<?php endif ?>

<script src="js/persons.js"></script>

<?php require base_path('views/layout/footer.php'); ?>