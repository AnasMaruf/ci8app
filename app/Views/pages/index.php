<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <div class="jumbotron">
                <h1 class="display-4">Selamat Datang di Website Kami</h1>
                <p class="lead"><?= $nama; ?></p>
                <hr class="my-4">
                <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>