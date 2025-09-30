<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var array<\App\Models\Movie> $movies
 */
?>

<?php $view->component('start'); ?>

<main>
    <div class="container">
        <h3 class="mt-3">Новинки</h3>
        <hr>
        <div class="movies">
            <?php if(isset($movies)) :?>
            <?php foreach ($movies as $movie) { ?>
                <?php $view->component('movie', ['movie' => $movie]); ?>
            <?php } ?>
            <?php endif ?>
        </div>
    </div>
</main>

<?php $view->component('end'); ?>