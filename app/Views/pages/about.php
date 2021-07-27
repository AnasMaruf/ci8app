<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-4">About Me</h2>
            <img src="/img/orang1.jpg" class="img rounded-circle my-2">
            <p>Perkenalkan nama saya <?= $profil['nama']; ?>, umur saya <?= $profil['umur']; ?> tahun, Saya bekerja sebagai <?= $profil['pekerjaan']; ?></p>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>